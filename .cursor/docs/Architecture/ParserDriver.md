# Parser Driver Architecture

## Goal

The parser uses a small **Driver / Frame / Builder** runtime to compose flow-collection
parsing (`[ ... ]`, `{ ... }`) from independent, single-responsibility builders.
The driver replaces deeply nested, mutually-recursive private methods inside
[`Parser`](../../../src/Parser/Parser.php) for flow contexts and gives every flow
construct (sequence, sequence entry, sequence operand, mapping, mapping pair)
its own dedicated builder class. Block parsing remains directly in `Parser`
because the driver was introduced specifically to disentangle flow collections
where YAML 1.2.2 §7.4 allows arbitrary mutual nesting (sequence inside mapping
inside sequence …).

## Components

### Driver

[`Driver`](../../../src/Parser/Driver/Driver.php) owns the **frame stack** and the
single `while (true)` dispatch loop:

1. `step()` is called on the top frame.
2. The returned [`BuilderResultInterface`](../../../src/Parser/Driver/BuilderResult/BuilderResultInterface.php)
   is dispatched (in an inner loop, using `continue 2` to restart from the top
   of the outer loop):
   - `Continued` — same frame keeps running, take the next outer iteration.
   - `Delegate` — push a child frame and run it; the new top-of-stack drives
     the next outer iteration.
   - `Completed` — pop the current frame and either return its node when the
     stack becomes empty, or hand the result to the parent's
     `onChildCompleted()` (which itself returns another `BuilderResultInterface`,
     dispatched in the same inner loop).
3. Any other return value throws `UnexpectedStateException`.

The driver never advances tokens directly: every consumption happens inside a
builder via `Harvester::tokens` (a [`TokenStream`](../../../src/Token/TokenStream.php)
proxy). This keeps the loop generic and makes builders testable in isolation.

### Frame

[`Frame`](../../../src/Parser/Driver/Frame.php) is an immutable triple
`(BuilderInterface $builder, ParseContext $context, Node $node)` plus thin
forwarders `step()` and `onChildCompleted()`. The pair `(builder, node)`
carries the structural part (what is being built), while `context` carries
all rule-level flags that depend on the lexical environment
(see `ParseContext` below).

### BuilderInterface

[`BuilderInterface`](../../../src/Parser/Driver/BuilderInterface.php) has two
methods:

```php
public function step(Harvester $harvester, Frame $self): BuilderResultInterface;
public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface;
```

`step()` advances the in-progress node when no child sub-builder is running.
`onChildCompleted()` is invoked when a delegated child frame completes and its
result must be folded back into the current frame's node (e.g. attach a parsed
flow node to a mapping pair, decide whether to continue iterating, etc.).

### BuilderResult

The three result classes describe the only transitions a builder can request:

- [`Continued`](../../../src/Parser/Driver/BuilderResult/Continued.php) — keep
  this frame on top of the stack; `step()` will be called again.
- [`Delegate`](../../../src/Parser/Driver/BuilderResult/Delegate.php) — push
  the wrapped frame; control transfers to it until it completes.
- [`Completed`](../../../src/Parser/Driver/BuilderResult/Completed.php) — this
  frame is finished; the wrapped node bubbles up to the parent's
  `onChildCompleted()` (or becomes the driver's final return value at the
  bottom of the stack).

This three-state vocabulary intentionally matches the recursive descent shape
that the legacy code expressed with nested `private function parse*()` calls,
so each old recursion site maps to a single builder method.

### ParseContext

[`ParseContext`](../../../src/Parser/Dto/ParseContext.php) is an immutable DTO
threading lexical-rule flags through frames. Defaults are tuned for "value
inside flow context" parsing (YAML 1.2.2 §7.4):

- `allowEmptyKey` / `allowEmptyValue` — empty-node admissibility per
  §7.4.1 / §7.4.2.
- `inFlow` — flow vs block context (currently always `true` for builders, but
  carried through for future block builders).
- `parentIndentLen` — passed to `Parser::parseValue()` for nested block-style
  values; uses the sentinel `FLOW_COLLECTION_VALUE_PARENT_INDENT` (`-2`).

Mutations are produced by `withAllowEmptyKey()`, …
returning a new instance. Frames hold their own `ParseContext`, so a child
frame can carry a mutated context without leaking back to the parent.

### FlowHost

[`FlowHost`](../../../src/Parser/Flow/FlowHost.php) is the bridge between flow
builders (which live in their own namespace) and the private parsing helpers
on [`Parser`](../../../src/Parser/Parser.php). It is constructed by
`Parser::createFlowHost()` and receives one closure per exposed helper:

- `appendFlowKeyMultilinePlainScalarContinuations`
- `collectSpaceAndComments`
- `createSyntaxTokenNode`
- `getFlowEntryKeyNode`
- `isScalarFollowedByValueIndicatorInFlow`
- `parseFlowContextValue`
- `parseFlowMapping` (allows `FlowEntryBuilder` to recurse into a nested mapping
  flow-pair without re-running the driver itself)
- `parseMergeInstructionAtCurrentPosition`
- `postProcessKeyValueCouple` (for deep-anchor registration; see below)
- `tryConsumeFlowMappingValueIndicator`

This keeps `Parser` private methods truly private (no public accessors leak
out for builder needs) while letting builders call them through a single
typed seam. Adding a new flow-builder helper is a one-line change to the
`FlowHost` constructor signature plus the matching closure in
`Parser::createFlowHost()`.

## Builders

All flow-collection builders live under
[`src/Parser/Builder/`](../../../src/Parser/Builder).

- [`FlowSequenceBuilder`](../../../src/Parser/Builder/FlowSequenceBuilder.php)
  builds a [`FlowSequenceNode`](../../../src/Node/FlowSequenceNode.php). It
  consumes the opening `[`, alternates between entries (delegated to
  `FlowEntryBuilder`) and `,` separators with surrounding layout, and closes
  on `]`.
- [`FlowEntryBuilder`](../../../src/Parser/Builder/FlowEntryBuilder.php) parses
  a single flow-sequence entry, which per YAML 1.2.2 §7.4.1 is either a
  flow node or a flow pair (legacy `key: value` form). After a JSON-style
  key operand (quoted scalar or flow collection), it peeks for
  `VALUE_INDICATOR` and builds a `KeyValueCoupleNode` via
  `tryConsumeFlowMappingValueIndicator()`. It also peeks through layout
  tokens to detect entry/sequence-end boundaries
  (`isAtFlowSequenceEntryBoundary()`), enabling implicit empty values.
- [`FlowOperandBuilder`](../../../src/Parser/Builder/FlowOperandBuilder.php)
  parses a single flow-sequence operand as a `ValueNode` via
  `FlowHost::parseFlowContextValue()`. It always returns `Completed` directly
  from `step()` (no delegation).
- [`FlowMappingBuilder`](../../../src/Parser/Builder/FlowMappingBuilder.php)
  builds a [`FlowMappingNode`](../../../src/Node/FlowMappingNode.php). It
  consumes `{`, iterates over key/value pairs (delegated to
  `FlowMappingPairBuilder`) and `,` separators, and closes on `}`. Merge
  instructions (`<<: *alias`) are handled by calling
  `FlowHost::parseMergeInstructionAtCurrentPosition()` for the matching
  position.
- [`FlowMappingPairBuilder`](../../../src/Parser/Builder/FlowMappingPairBuilder.php)
  builds a single [`KeyValueCoupleNode`](../../../src/Node/KeyValueCoupleNode.php).
  It parses the key, optionally consumes the `:` value indicator, and
  delegates value parsing through `FlowHost::parseFlowContextValue()`. Like
  the sequence-entry builder, it peeks through layout tokens
  (`isAtFlowMappingEntryBoundary()`) so empty values like `{"empty":\n}` are
  represented by an empty `ValueNode` and the trailing layout is collected
  by the outer mapping builder.

## Parser integration

[`Parser`](../../../src/Parser/Parser.php) keeps two thin entry points for
flow contexts:

- `Parser::runFlowSequenceDriver(Harvester): FlowSequenceNode` — wraps
  `FlowSequenceBuilder` in an initial frame and runs the driver.
- `Parser::runFlowMappingDriver(Harvester): FlowMappingNode` — same for
  `FlowMappingBuilder`.

Both are reached from the same call sites that previously invoked
`parseFlowSequence` / `parseFlowMapping`. `Parser::createFlowHost()` builds
and returns the shared `FlowHost` for the duration of a single driver run
(its closures bind to `$this`, so each call captures the current
`Harvester`-agnostic helpers).

## Token-stream interaction

Builders observe and consume tokens through the `Harvester::tokens` proxy
([`TokenStreamProxy`](../../../src/Parser/Dto/TokenStreamProxy.php)), which
wraps the lexer [`TokenStream`](../../../src/Token/TokenStream.php). Adjacent
`:` after a JSON-style key inside a flow sequence (production [153]) is
emitted as `VALUE_INDICATOR` by the lexer (`FlowSequenceFrame` phase tracking);
builders only peek and consume those tokens.

## Anchor declaration in complex keys

`Parser::postProcessKeyValueCouple()` is invoked by both block and flow
key/value couple sites. It records the couple as the **declaring couple**
of every anchor that belongs to it:

- The value's direct anchor, via `ValueNode::getAnchor()`.
- All anchors inside the **key subtree**, via the recursive helper
  `Parser::collectKeyAnchorsRecursive()`. The recursion stops at any nested
  `KeyValueCoupleNode` so anchors declared inside an inner couple keep their
  inner-couple declaration (every couple owns its own scope).

This lets aliases resolve back to the surrounding couple even when the anchor
is buried inside a flow sequence or flow mapping that serves as the key, e.g.
`[ &a foo, bar ]: value` or `? [ &a foo, bar ]\n: value`.

## Adding a new flow builder

1. Define a new class implementing `BuilderInterface` under
   `src/Parser/Builder/`.
2. If the new builder needs a private `Parser` helper, add a typed closure
   to `FlowHost::__construct()` (alphabetical order) and bind it inside
   `Parser::createFlowHost()`.
3. Reach the builder from a thin `Parser::run*Driver()` entry point or via a
   `Delegate` from an existing builder.
4. Cover the new branch with a fixture under `tests/fixture/edge_cases_extra/`
   (or the matching bucket) and regenerate expectations via
   `bin/dev/generate-lexer-expectations.php` and
   `bin/dev/generate-parser-expectations.php`.
