# Parser Refactoring: Design Decisions

Parent: [Parser Refactoring](ParserRefactoring.md)

## Implementation notes (post-migration)

The refactor is complete. A few decisions below describe the **target** design;
the shipped code differs in these ways:

- **`EspecialIndent` sentinels remain** — `ValueParser::parseValue($ctx, $parentIndentLen)`
  still uses `BARE_DOCUMENT_BLOCK_PARENT` and `FLOW_COLLECTION_VALUE_PARENT`.
  `ParseContext` exposes a context stack API, but sub-parsers do not push/pop
  frames yet; indent sentinels carry flow vs bare-root semantics for now.
- **No `OngoingStructureIdentifier` facade** — look-ahead predicates live in
  four identifier classes injected directly into the sub-parsers that need them.
- **`SimpleScalarParser`** — plain and quoted scalars share one leaf parser
  (via `NodeFactory::createScalarNode()`), not separate `PlainScalarParser` /
  `QuotedScalarParser` classes.
- **`ParserBuilder`** — production wiring creates helpers, assembler, registry,
  and `Parser` in one place; `Parser` receives `ParserRegistry` by constructor
  injection.

## Lazy Resolution via Registry

**Problem:** Circular dependencies between sub-parsers
(`ValueParser → BlockMappingParser → KeyValueCoupleParser → ValueParser`).
Constructor injection of concrete peers is impossible — you can't pass an
object that doesn't exist yet.

**Considered:**
- Setter injection (create all parsers, then wire via setters) — two-phase,
  easy to forget a setter, mutable after construction.
- Eager assembly with a specific creation order — fragile, breaks when a new
  cycle appears.
- Lazy resolution through the registry.

**Decision:** `ParserRegistry` receives `ParserAssembler` in its constructor.
Each typed getter (`getBlockMappingParser()`, etc.) creates the sub-parser on
first call via `$this->assembler->create*(this)` and caches it with `??=`.
Sub-parsers store `ParserRegistry` (not concrete peers) and resolve
dependencies only at `parse()` time, when the full graph is already available.

**Consequence:** No sub-parser constructor ever triggers creation of another
sub-parser. Cycles are impossible by construction.

## Single Assembler

**Problem:** How many assembler classes to have for wiring sub-parsers.

**Considered:**
- Multiple assemblers per domain (`FlowAssembler`, `BlockAssembler`,
  `ScalarAssembler`, `StructuralAssembler`).
- Single `ParserAssembler`.

**Decision:** Start with a single `ParserAssembler`. With lazy resolution,
creation order is irrelevant — the assembler is just a collection of
independent `create*Parser(ParserRegistry)` factory methods. If it grows too
large, splitting into domain-specific assemblers is trivial (move methods,
delegate).

## Recursion Depth Protection

**Problem:** Direct delegation via PHP call stack means nesting depth is
bounded by the C stack size. Deeply nested YAML
(`[[[[…]]]]`, `a:\n  b:\n    c:\n      …`) could cause a stack overflow.

**Considered:**

| Approach | Parser API | Depth limit | Complexity |
|----------|-----------|-------------|------------|
| **A. Recursion + depth counter** | Simple `parse() → Node` | ~256 (configurable) | Minimal: one counter in `ParseContext` |
| **B. Generalized Driver** (explicit frame stack) | Step-based state machine (`step()` / `onChildCompleted()`) | Unlimited (memory) | High: every parser becomes a state machine — the very pattern we're moving away from |
| **C. PHP Fibers** (trampoline) | Simple `parse() → Node` | Unlimited (memory) | Medium: trampoline loop, Fiber per delegation |

**Decision:** Variant A — recursion with a depth counter. Rationale:

1. Preserves the core goal: simple parsers with `parse() → Node`.
2. Real-world YAML files rarely nest beyond 20–30 levels; a limit of 256 is
   extremely generous.
3. If unlimited depth is ever needed, migration to Fibers (variant C) is
   possible without changing any sub-parser API — only the delegation
   mechanism changes.
4. Variant B contradicts the refactoring motivation (escape from
   step/phase/callback complexity of the current Driver/Builder pattern).

**Implementation:** A `$depth` counter on `ParseContext`. Each sub-parser
that performs recursive delegation increments on entry and decrements in a
`finally` block:

```php
private const MAX_DEPTH = 256;

public function parse(ParseContext $ctx, int $parentIndentLen): BlockMappingNode
{
    if (++$ctx->depth > self::MAX_DEPTH) {
        throw new NestingTooDeepException(/* ... */);
    }

    try {
        // ... parsing logic with delegation to other sub-parsers ...
    } finally {
        --$ctx->depth;
    }
}
```

`MAX_DEPTH` is a constant on each sub-parser (or a shared constant). Only
parsers that delegate recursively need the guard — leaf parsers (e.g.
`SimpleScalarParser`) do not increment the counter.

## Context Stack (Partial — Sentinels Still in Use)

**Problem:** The former `Parser` used `$parentIndentLen` to carry two
unrelated meanings in one parameter:

1. The actual parent indent level (≥ 0).
2. The parsing context type, encoded as sentinel constants:
   `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT = -1`,
   `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::FLOW_COLLECTION_VALUE_PARENT = -2`.

This conflation makes the API confusing and forces every intermediate caller
to forward magic integers.

**Considered:**

- **A. Typed value-object parameter** (`BlockValueContext`,
  `FlowValueContext`, `BareDocumentRootValueContext`) passed to
  `ValueParser::parse()`. Clean at the call site, but the context must be
  threaded through every signature; deeper participants
  (e.g. `OngoingStructureIdentifier`) still need it.
- **B. Context stack on `ParseContext`** — push/pop upon entering/leaving a
  context. Any parser or helper can inspect the current context via
  `$ctx->getCurrentContext()` without receiving it as a parameter.
- **C. Separate parsers per context** (`BlockValueParser`,
  `FlowValueParser`, `BareDocumentRootValueParser`) — significant code
  duplication.

**Decision:** Variant B — context stack on `ParseContext` (infrastructure in place).

**Shipped state:** `ContextFrame`, `ParsingContext`, and push/pop APIs exist on
`ParseContext`, but `ValueParser` and block parsers still pass
`EspecialIndent` sentinels as `$parentIndentLen`. Eliminating sentinels in
favour of stack-only context is a possible follow-up.

Each parser that introduces a new context *would* push a `ContextFrame` on entry
and pop in a `finally` block (same pattern as the depth counter):

```php
enum ParsingContext
{
    case BareDocumentRoot;
    case Block;
    case Flow;
}

final readonly class ContextFrame
{
    public function __construct(
        public ParsingContext $context,
        public int $indentLen = 0,  // meaningful only for Block
    ) {}
}
```

`ParseContext` exposes the stack:

```php
final class ParseContext
{
    public int $depth = 0;
    /** @var ContextFrame[] */
    private array $contextStack = [];

    public function pushContext(ContextFrame $frame): void
    {
        $this->contextStack[] = $frame;
    }

    public function popContext(): void
    {
        array_pop($this->contextStack);
    }

    public function getCurrentContext(): ContextFrame
    {
        return $this->contextStack[array_key_last($this->contextStack)];
    }
}
```

Usage in sub-parsers:

```php
// DocumentParser — bare document root
$ctx->pushContext(new ContextFrame(ParsingContext::BareDocumentRoot));
try { /* ... */ } finally { $ctx->popContext(); }

// BlockMappingParser — block with known indent
$ctx->pushContext(new ContextFrame(ParsingContext::Block, $indentLen));
try { /* ... */ } finally { $ctx->popContext(); }

// FlowSequenceParser — flow context
$ctx->pushContext(new ContextFrame(ParsingContext::Flow));
try { /* ... */ } finally { $ctx->popContext(); }
```

`ValueParser` reads the context from the stack instead of receiving
`$parentIndentLen`:

```php
public function parse(ParseContext $ctx): ValueNode
{
    $frame = $ctx->getCurrentContext();
    // $frame->context tells flow vs block vs bare-document-root
    // $frame->indentLen gives the real indent (Block only)
}
```

**Consequences (target vs shipped):**
- Target: sentinel constants `-1` / `-2` eliminated; `ValueParser` reads the stack.
- Shipped: sentinels remain; context stack API is reserved for a later step.
- `FlowValueParser` as a separate class is not needed — `ValueParser` checks
  `$parentIndentLen` / flow sentinel.
- Structure identifiers are injected per sub-parser; there is no
  `OngoingStructureIdentifier` facade.
- `$parentIndentLen` in block-specific parsers is still a real value ≥ 0 or an
  `EspecialIndent` sentinel where flow/bare-root semantics apply.

## ParserRegistry Caching in the Façade

**Problem:** `ParserAssembler` creates shared helpers eagerly and
`ParserRegistry` caches sub-parsers lazily. Should this object graph be
rebuilt on every `Parser::parse()` call?

**Decision:** `ParserRegistry` (and its `ParserAssembler`) are created once per
`Parser` instance — typically via [`ParserBuilder`](../../../src/Parser/ParserBuilder.php).
Only `ParseContext` is created per `parseStream()` call.

```php
final class Parser
{
    public function __construct(private ParserRegistry $parserRegistry) {}

    public function parseStream(TokenStream $tokens): StreamNode
    {
        $parseContext = new ParseContext(
            new TokenStreamProxy($tokens),
            new AnchorsRegistry(),
            new ParseState(),
        );

        return $this->parserRegistry->getStreamParser()->parseStream($parseContext);
    }
}
```

## Context-Sensitive Identification Signatures

**Problem:** Structure identifiers need to know the current parsing context
(flow / block / bare-document-root) to apply the correct rules.

**Decision:** Split predicates into `BlockStructureIdentifier`,
`FlowStructureIdentifier`, `NodePropertyIdentifier`, and `KeyIdentifier`.
Each sub-parser receives the identifiers it needs. Identifiers take
`ParseContext` (token stream) as their primary input; they do not rely on a
separate facade class.

## Testing Strategy

**Decision:** During migration, rely on existing integration tests (which run
through `Parser::parse()`) as the safety net. Keep all tests green after every
step. Unit tests for individual sub-parsers can be added later and are not
a prerequisite for the refactoring.

## ParserRegistry Naming

**Problem:** The codebase already has a `ParseRegistry` (used for anchor
storage). The proposed `ParserRegistry` (sub-parser lookup) has a similar name.

**Decision:** Use `ParserRegistry` for the new sub-parser registry. The
existing `ParseRegistry` is effectively an `AnchorsRegistry` — it will be
renamed or removed during migration as its responsibilities are absorbed by
`AnchorsRegistry` (which already exists in `Dto/`).
