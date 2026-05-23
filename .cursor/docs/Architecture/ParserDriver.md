# Parser Architecture

## Goal

The parser builds a `Node` tree from a lexer `TokenStream` through **sub-parser
composition**: each YAML construct has a dedicated class, helpers hold shared
logic, and [`Parser`](../../../src/Parser/Parser.php) is a thin façade. The previous
**Driver / Frame / Builder** runtime and **`FlowHost`** closure bridge were removed;
flow and block parsing now use the same direct-delegation model.

## Entry point

```text
Parser::parse(input)
  → Lexer::tokenize
  → Parser::parseStream(TokenStream)
       → new ParseContext(TokenStreamProxy, AnchorsRegistry, ParseState)
       → ParserRegistry::getStreamParser()->parseStream(ctx)
            → StreamParser → DocumentParser → …
```

[`ParserBuilder`](../../../src/Parser/ParserBuilder.php) is the production factory:
it creates shared helpers once, wraps them in [`ParserAssembler`](../../../src/Parser/Assembler/ParserAssembler.php),
and injects the assembler into [`ParserRegistry`](../../../src/Parser/ParserRegistry.php).

## Runtime state: ParseContext

[`ParseContext`](../../../src/Parser/ParseContext.php) replaces the former `Harvester`.
It is passed to every sub-parser method and holds:

| Member | Role |
|--------|------|
| `tokens` | [`TokenStreamProxy`](../../../src/Parser/Dto/TokenStreamProxy.php) — cursor over the lexer stream |
| `anchorsRegistry` | [`AnchorsRegistry`](../../../src/Parser/Dto/AnchorsRegistry.php) — named anchors for alias resolution |
| `state` | [`ParseState`](../../../src/Parser/Dto/ParseState.php) — indentation steps |
| `depth` | Recursion depth counter (safety threshold in sub-parsers) |
| context stack | [`ContextFrame`](../../../src/Parser/Dto/ContextFrame.php) + [`ParsingContext`](../../../src/Parser/Enum/ParsingContext.php) enum (Block / Flow / BareDocumentRoot) |

`ParseContext` does not reference `StreamNode` or any sub-parser instance.

## Registry and assembler

[`ParserRegistry`](../../../src/Parser/ParserRegistry.php) lazy-creates and caches
sub-parsers on first access via typed getters (`getValueParser()`, `getFlowSequenceParser()`, …).
Each sub-parser receives the registry in its constructor, which resolves circular
dependencies (e.g. `ValueParser ↔ BlockMappingParser`) without two-phase wiring.

[`ParserAssembler`](../../../src/Parser/Assembler/ParserAssembler.php) owns stateless
helpers (created eagerly) and exposes one `create*Parser(ParserRegistry)` factory
per sub-parser. Structure identifiers (`BlockStructureIdentifier`, `FlowStructureIdentifier`,
`KeyIdentifier`, `NodePropertyIdentifier`) are also lazily created on the assembler
and injected into the sub-parsers that need them.

[`StructureType`](../../../src/Parser/Enum/StructureType.php) and
`ParserRegistry::getByType()` exist for dynamic scalar dispatch; most delegation
uses typed registry getters instead.

## Sub-parsers

All sub-parsers implement the marker [`SubParserInterface`](../../../src/Parser/Contract/SubParserInterface.php)
and define their own `parse()` (or similarly named) signatures.

| Group | Path | Responsibility |
|-------|------|------------------|
| Structural | `SubParser/StreamParser`, `DocumentParser`, `ValueParser`, `DirectiveParser`, `MergeInstructionParser`, `NodePropertiesParser` | Stream, documents, universal value entry, directives, merge keys, anchor/tag properties |
| Block | `SubParser/Block/*` | Block mappings/sequences, compact collections, keys, couples, sequence entries, indented values |
| Flow | `SubParser/Flow/*` | Flow sequences/mappings, entries, mapping pairs |
| Scalar | `SubParser/Scalar/*` | Simple scalars, multiline plain, block scalars |

Full mapping from legacy `Parser.php` methods: [Sub-Parser Catalog](../Feature/ParserRefactoring-SubParsers.md).

### Control-flow example

```text
ValueParser::parseValue(ctx, parentIndentLen)
  ├── NodePropertiesParser::collectValueProperties(ctx, valueNode)
  ├── block scalar / NEWLINE → IndentedBlockValueParser::parseIndentedBlockValue
  ├── scalar → SimpleScalarParser or MultilinePlainScalarParser
  ├── alias / compact sequence / flow start
  │     └── registry->getFlowSequenceParser()->parse(ctx)
  │           ├── consume `[`
  │           ├── loop: FlowEntryParser::parse(ctx)
  │           │     └── ValueParser::parseValue(ctx, FLOW_COLLECTION_VALUE_PARENT)
  │           └── consume `]`
  └── return ValueNode
```

## Helpers

| Class | Purpose |
|-------|---------|
| [`NodeFactory`](../../../src/Parser/Helper/NodeFactory.php) | Map structural/scalar tokens to typed nodes |
| [`Consumer`](../../../src/Parser/Consumer.php) | Collect layout tokens, comments, spaces by type |
| [`ErrorHelper`](../../../src/Parser/Helper/ErrorHelper.php) | Append line/column to error messages |
| [`IndentationHelper`](../../../src/Parser/Helper/IndentationHelper.php) | Validate and register indent steps |
| [`LookAheadHelper`](../../../src/Parser/Helper/LookAheadHelper.php) | Peek significant block heads, insignificant lines |
| [`MultilineContinuationHelper`](../../../src/Parser/Helper/MultilineContinuationHelper.php) | Multiline plain scalar continuation predicates |
| [`AnchorPostProcessor`](../../../src/Parser/Helper/AnchorPostProcessor.php) | Wire anchors to declaring key/value couples |

### Structure identifiers

Look-ahead predicates from the former monolithic `Parser.php` live under
[`src/Parser/Helper/Identifier/`](../../../src/Parser/Helper/Identifier):

- [`BlockStructureIdentifier`](../../../src/Parser/Helper/Identifier/BlockStructureIdentifier.php) — block mapping/sequence starts, implicit keys
- [`FlowStructureIdentifier`](../../../src/Parser/Helper/Identifier/FlowStructureIdentifier.php) — flow collection starts, JSON-style keys
- [`NodePropertyIdentifier`](../../../src/Parser/Helper/Identifier/NodePropertyIdentifier.php) — anchor/tag lines and follow-on patterns
- [`KeyIdentifier`](../../../src/Parser/Helper/Identifier/KeyIdentifier.php) — scalar + `:` implicit keys

Sub-parsers receive the identifiers they need directly (there is no separate facade class).

## Parent indent sentinels

Block and flow contexts share `ValueParser::parseValue()` but use different parent
indent semantics via [`EspecialIndent`](../../../src/Parser/Enum/EspecialIndent.php):

- `BARE_DOCUMENT_BLOCK_PARENT` (-1) — bare document root (YAML 1.2.2 rule [211])
- `FLOW_COLLECTION_VALUE_PARENT` (-2) — values inside `[ … ]`, `{ … }`, or merge RHS

Flow lines use `WHITESPACE` (not `INDENTATION`) before continuation content; the
flow sentinel prevents misrouting newline-prefixed values into
`IndentedBlockValueParser` at indent 0.

## Token-stream interaction

Sub-parsers observe and consume tokens only through `ParseContext::tokens`
(`TokenStreamProxy` over [`TokenStream`](../../../src/Token/TokenStream.php)).
Adjacent `:` after a JSON-style key inside a flow sequence (production [153]) is
emitted as `VALUE_INDICATOR` by the lexer; flow sub-parsers peek and consume those tokens.

## Adding a new sub-parser

1. Add a class implementing `SubParserInterface` under the appropriate
   `src/Parser/SubParser/` subdirectory.
2. Add `create*Parser()` to `ParserAssembler` and a typed getter to `ParserRegistry`.
3. Delegate from an existing sub-parser (or extend `ValueParser` dispatch) via the registry.
4. Cover the branch with a fixture and regenerate expectations via
   `bin/dev/generate-parser-expectations.php` (inside the `php-cli` container when using Docker).

## Historical note

Flow collections were previously parsed by a **Driver / Frame / Builder** stack under
`src/Parser/Driver/` and `src/Parser/Builder/`, with private `Parser` helpers
exposed through `FlowHost` closures. That infrastructure was replaced by the
sub-parsers listed above; behaviour is preserved, control flow is direct recursion.
