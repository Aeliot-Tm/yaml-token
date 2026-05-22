# Parser

## Goal

The parser builds a tree of `Node` objects from the lexer `TokenStream`: stream, documents,
block and flow collections, scalars, and layout (comments, indentation, newlines, structural tokens).

## Flow collection driver

Flow collections (`[ ... ]`, `{ ... }`) are parsed by a dedicated **Driver / Frame /
Builder** runtime instead of nested recursive private methods. Each flow construct
(sequence, sequence entry, sequence operand, mapping, mapping pair) has its own
builder class under [`src/Parser/Builder/`](../../../src/Parser/Builder), the
[`Driver`](../../../src/Parser/Driver/Driver.php) owns a frame stack and dispatches
`Continued` / `Delegate` / `Completed` results, and a [`FlowHost`](../../../src/Parser/Flow/FlowHost.php)
exposes the few `Parser` private helpers builders need (via closures bound in
`Parser::createFlowHost()`). The two entry points used from block-level parsing
are `Parser::runFlowSequenceDriver()` and `Parser::runFlowMappingDriver()`.

JSON-style flow-pair keys in sequences (YAML 1.2.2 production [153], e.g.
`["key":value]` or `[{a: b}:c]`) are tokenized by the lexer as a separate
`VALUE_INDICATOR` even when `:` is adjacent to the value; flow builders then
use the same `tryConsumeFlowMappingValueIndicator()` path as for `{a:1}`.

See [Parser Driver Architecture](../Architecture/ParserDriver.md) for the
component-level description.

## Anchor declaration in complex keys

`Parser::postProcessKeyValueCouple()` records each `KeyValueCoupleNode` as the
**declaring couple** of every anchor that belongs to it:

- The value's direct anchor, via `ValueNode::getAnchor()`.
- All anchors inside the **key subtree**, via the recursive helper
  `Parser::collectKeyAnchorsRecursive()`. The recursion stops at any nested
  `KeyValueCoupleNode` so anchors declared inside an inner couple keep their
  inner-couple declaration. This makes aliases resolve back to the surrounding
  couple even when the anchor is buried inside a flow sequence or flow mapping
  that serves as the key (`[ &a foo, bar ]: value`, `? [ &a foo, bar ]\n: value`,
  `{ &a foo: bar }: outer`).

## Source round-trip and empty nodes

This project preserves the original source text by keeping all lexed tokens (including layout tokens
like whitespace, newlines and comments) in the node tree. The YAML emitter then reconstructs
the source by concatenating `TokenHolderInterface::getToken()->text` for all nodes.

Because of this, the parser must not invent tokens that did not exist in the original input.

- **Round-trip invariant**: emitting a parsed stream must reproduce the original input byte-for-byte.
- **Empty node invariant**: YAML “empty nodes” are represented structurally, not by synthetic tokens.
  - If a key or value is empty in YAML grammar, the corresponding node reference is `null` (absence).
  - If a value is syntactically present (e.g. `:` is present) but its content is empty (`e-node`),
    the parser keeps a `ValueNode` instance whose content is empty (`ValueNode::isEmpty()`).

## Node class hierarchy

The parser builds an AST from the following node types. Every node extends
[`AbstractNode`](../../../src/Node/AbstractNode.php) (which implements
[`Node`](../../../src/Node/Node.php) — `addChild`, `getChildren`, `getParent`)
unless stated otherwise.

### Base classes

| Class | Role |
|-------|------|
| `AbstractNode` | Mutable children list (`addChild`, `removeChild`, `getChildren`, `setParent`). |
| `SyntaxNode` *(abstract)* | Wraps a single structural `Token` (`getToken()`). Extends `AbstractNode`, implements `TokenHolderInterface`. |
| `ScalarNode` *(abstract)* | Wraps a single scalar `Token` (`getToken()`). Extends `AbstractNode`, implements `TokenHolderInterface`. |

### Scalar nodes

All extend `ScalarNode` (constructor: `Token`; no extra methods).

| Class | Token type |
|-------|------------|
| `DoubleQuotedScalarNode` | `DOUBLE_QUOTED_SCALAR` |
| `FoldedBlockScalarNode` | `FOLDED_BLOCK_SCALAR` |
| `LiteralBlockScalarNode` | `LITERAL_BLOCK_SCALAR` |
| `PlainScalarNode` | `PLAIN_SCALAR` |
| `SingleQuotedScalarNode` | `SINGLE_QUOTED_SCALAR` |

### Structural (syntax) nodes

All extend `SyntaxNode` (constructor: `Token`; no extra methods unless noted).

| Class | Token / purpose |
|-------|-----------------|
| `IndentationNode` | `INDENTATION` |
| `NewLineNode` | `NEWLINE` |
| `WhitespaceNode` | `WHITESPACE` |
| `CommentNode` | `COMMENT` |
| `DocumentStartNode` | `DOCUMENT_START` (`---`) |
| `DocumentEndNode` | `DOCUMENT_END` (`...`) |
| `ValueIndicatorNode` | `VALUE_INDICATOR` (`:`) |
| `ExplicitKeyIndicatorNode` | `EXPLICIT_KEY_INDICATOR` (`?`) |
| `SequenceEntryNode` | `SEQUENCE_ENTRY` (`-`) |
| `FlowEntryNode` | `FLOW_ENTRY` (`,`) |
| `FlowSequenceBoundNode` *(abstract)* | Base for flow-sequence brackets. |
| `FlowSequenceStartNode` | `FLOW_SEQUENCE_START` (`[`). Extends `FlowSequenceBoundNode`. |
| `FlowSequenceEndNode` | `FLOW_SEQUENCE_END` (`]`). Extends `FlowSequenceBoundNode`. |
| `FlowMappingBoundNode` *(abstract)* | Base for flow-mapping brackets. |
| `FlowMappingStartNode` | `FLOW_MAPPING_START` (`{`). Extends `FlowMappingBoundNode`. |
| `FlowMappingEndNode` | `FLOW_MAPPING_END` (`}`). Extends `FlowMappingBoundNode`. |
| `BlockScalarIndicatorNode` | `BLOCK_SCALAR_INDICATOR` (`\|` / `>`) |
| `BlockScalarChompingIndicatorNode` | `BLOCK_SCALAR_CHOMPING_INDICATOR` (`+` / `-`) |
| `BlockScalarIndentationIndicatorNode` | `BLOCK_SCALAR_INDENTATION_INDICATOR` |
| `MergeIndicatorNode` | `MERGE_INDICATOR` (`<<`) |
| `ByteOrderNode` | `BYTE_ORDER` (BOM). Extends `AbstractNode`, implements `TokenHolderInterface`. |

### Composite nodes

| Class | Key methods |
|-------|-------------|
| `StreamNode` | Root of the tree (YAML rule l‑yaml‑stream :211). |
| `DocumentNode` | One document (l‑any‑document :210). |
| `BlockMappingNode` | `getEntries(): list<KeyValueCoupleNode>` — filters structural children. |
| `BlockSequenceNode` | `getEntries(): list<BlockSequenceEntryNode>`. |
| `BlockSequenceEntryNode` | `getValue(): ?ValueNode`. Typed `addChild()` / `removeChild()`. |
| `FlowSequenceNode` | `getEntries(): list<ValueNode>`. |
| `FlowMappingNode` | `getEntries(): list<KeyValueCoupleNode>`. |
| `MultilinePlainScalarNode` | Groups `PLAIN_SCALAR` fragments across lines. |
| `KeyValueCoupleNode` | `getKey()`, `getValue()`, `getValueIndicator()`, `getMergeInstruction()`, `getIndentation()` / `setIndentation()`. Typed `addChild()` / `removeChild()` with duplication guards. |
| `KeyNode` | `getName(): ?Node`, `setName(Node)` *(throws on double set)*, `getExplicitKeyIndicatorNode()` / `setExplicitKeyIndicator()`, `getProperties()` / `setProperties()`, `getAnchor()`, `getTag()`, `isEmpty()`. |
| `ValueNode` | `getScalar()`, `getMultilinePlainScalar()`, `getAlias()`, `getBlockMapping()`, `getBlockSequence()`, `getFlowMapping()`, `getFlowSequence()`, `getKeyValueCouple()`, `getProperties()` / `setProperties()`, `getAnchor()`, `getTag()`, `isEmpty()`. Typed `addChild()`. |
| `NodePropertiesNode` | Groups `&anchor` and `!tag` metadata. `getAnchor()`, `getTag()`. Typed `addChild()` / `removeChild()`. |
| `AnchorNode` | `getName()` (strips `&`), `getToken()`, `getDeclarationCouple()` / `setDeclarationCouple()`. |
| `AliasNode` | `getName()` (strips `*`), `getToken()`, `getAnchor()` / `setAnchor()`. |
| `TagNode` | `getToken()`. |
| `MergeInstructionNode` | `addAlias(AliasNode)`, `getAliases(): list<AliasNode>`. |
| `DirectiveNode` | Generic reserved directive. `getToken()`. |
| `YamlDirectiveNode` | `getIndicatorNode()`, `getVersionNode()`. Typed `addChild()` / `removeChild()`. |
| `YamlDirectiveIndicatorNode` | `getToken()` (`%YAML`). |
| `YamlDirectiveVersionNode` | `getToken()`. |
| `TagDirectiveNode` | `getIndicatorNode()`, `getHandleNode()`, `getPrefixNode()`, `getHandle(): ?string`, `getPrefix(): string`. Typed `addChild()` / `removeChild()`. |
| `TagDirectiveIndicatorNode` | `getToken()` (`%TAG`). |
| `TagDirectiveHandleNode` | `getHandle(): string`, `getToken()`. |
| `TagDirectivePrefixNode` | `getPrefix(): string`, `getToken()`. |

## Technical details

- Fixture regression: [`FixtureParserMappingTest`](../../../tests/unit/Parser/FixtureParserMappingTest.php)
  asserts the parse tree shape (via [`NodeTreeRepresenter`](../../../tests/helper/NodeTreeRepresenter.php))
  against files under `tests/parser_expectations/`. Regenerate snapshots with `composer parser-expectations`
  after intentional parser or YAML fixture changes (run inside the `php-cli` container when using Docker).
  Snapshot PHP writes token `text` fields that contain control characters (including newlines)
  as double-quoted strings with escapes (for example `"\n"`) for stable expectations
  across OS and Git line-ending settings.
- Entry points: [`Parser::parse`](../../../src/Parser/Parser.php) (lexes input),
  [`Parser::parseStream`](../../../src/Parser/Parser.php) for an existing `TokenStream`.
- `%YAML` directive: built as [`YamlDirectiveNode`](../../../src/Node/YamlDirectiveNode.php)
  with [`YamlDirectiveIndicatorNode`](../../../src/Node/YamlDirectiveIndicatorNode.php) for the
  `DIRECTIVE_YAML_INDICATOR` (`%YAML`) token and child nodes for optional horizontal whitespace,
  optional `VALUE_INDICATOR` (`:`), and required `DIRECTIVE_YAML_VERSION`
  (as [`YamlDirectiveVersionNode`](../../../src/Node/YamlDirectiveVersionNode.php)).
  Horizontal whitespace and comments after the version token stay at document level
  (same loop as other layout). If a newline or comment appears before a version token, or the token stream
  ends before a version token, the parser throws [`LogicException`](../../../src/Parser/Parser.php).
- `%TAG` directive: built as [`TagDirectiveNode`](../../../src/Node/TagDirectiveNode.php)
  with [`TagDirectiveIndicatorNode`](../../../src/Node/TagDirectiveIndicatorNode.php) for the
  `DIRECTIVE_TAG_INDICATOR` (`%TAG`) token and child nodes for optional horizontal whitespace,
  required `DIRECTIVE_TAG_HANDLE` (as [`TagDirectiveHandleNode`](../../../src/Node/TagDirectiveHandleNode.php))
  and required `DIRECTIVE_TAG_PREFIX` (as [`TagDirectivePrefixNode`](../../../src/Node/TagDirectivePrefixNode.php)).
  If a newline or comment appears before handle/prefix, or the token stream ends before
  the prefix token, the parser throws [`LogicException`](../../../src/Parser/Parser.php).
- Value node properties:
  - `ValueNode` may start with node properties (metadata) before its content.
  - Anchor is stored as [`AnchorNode`](../../../src/Node/AnchorNode.php).
  - Explicit tag is stored as [`TagNode`](../../../src/Node/TagNode.php) for the `TAG` token (full tag lexeme),
    exposed via `ValueNode::getTag()` and `KeyNode::getTag()` when a tag appears in node properties.
  - Block-context plain scalars may span multiple lines. In that case the value contains
    multiple `ScalarNode` fragments (one per `PLAIN_SCALAR` token). `ValueNode` groups these fragments
    into a single [`MultilinePlainScalarNode`](../../../src/Node/MultilinePlainScalarNode.php) 
    exposed via `ValueNode::getMultilinePlainScalar()`. When `multilinePlainScalar` is present,
    `ValueNode::getScalar()` is `null`. Single-line plain (and other scalar styles) still use
    `ValueNode::getScalar()` with a [`ScalarNode`](../../../src/Node/ScalarNode.php).
    Continuation lines may include `WHITESPACE` (for example a tab) between the line’s `INDENTATION`
    token and the next `PLAIN_SCALAR`; the parser consumes those tokens as part of the same scalar
    line so block collections do not treat the line as a new entry.
    At bare document root (no enclosing block indent; `Parser` passes
    `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT` as the parent length),
    a continuation may begin with a scalar at column one with no leading `INDENTATION` on that line;
    the same helper accepts it when the line is not an implicit YAML key (`:` on that line).
    Horizontal `WHITESPACE` that ends a physical line immediately before `NEWLINE` (for example trailing
    spaces after `b` on the same line) is folded into the scalar before the next continuation is probed.
    A completely empty line between continuation lines is lexed as two consecutive `NEWLINE` tokens;
    when the following line is still a valid continuation (indented probe as before, or bare-root flush probe,
    including not stealing an implicit block key), `appendMultilinePlainScalarContinuations()`
    keeps the first `NEWLINE` inside the value (YAML 1.2.2 §6.5 / §7.3.3, e.g. Example 7.12 Plain Lines).
    A line that has only block `INDENTATION` plus horizontal `WHITESPACE` (for example a tab) before
    the line break is another empty-continuation pattern: the parser consumes `NEWLINE` + indent +
    those spaces/tabs and leaves the closing `NEWLINE` so the next fragment still receives a leading
    `NewLineNode` like other continuations.
  - Plain-scalar **keys** in flow mappings (e.g. `{ multi\n  line, a: b}`) may also span
    multiple physical lines. Inside `{...}` the lexer emits `NEWLINE` + `WHITESPACE` + `PLAIN_SCALAR`
    for each continuation line (no `INDENTATION` token, since `INDENTATION` is only emitted at column 1
    outside flow). The complete key node (including multiline handling) is built by
    `FlowHost::getFlowEntryKeyNode()`, which delegates to `Parser::getKeyNode()`.
    `KeyNode::setName(Node)` assigns the key name — a single `ScalarNode` subclass for simple keys,
    or a `MultilinePlainScalarNode` for multiline plain keys, or a flow collection node.
    Trailing `NEWLINE` + `WHITESPACE` that precede `,`, `}`, or `:` on a separate continuation
    line stay as layout children of the `KeyValueCoupleNode` (collected by
    `tryConsumeFlowMappingValueIndicator()`), so the source round-trips byte-for-byte.
- Collections:
  - When a block collection (mapping or sequence) appears as a value after `:` on a new line,
    the opening layout tokens (the `NEWLINE` after `:`, any comment/empty lines, and whitespace
    before the first significant content line) belong to the enclosing `ValueNode`, not to the
    `BlockMappingNode` / `BlockSequenceNode` itself. The helper `consumeBlockValueOpeningLayout()`
    consumes these tokens onto the `ValueNode` before dispatching to the collection parser.
    The same helper is used for flow and scalar value branches in `parseIndentedBlockValue()`,
    ensuring uniform ownership of the opening layout across all value types.
  - Block mapping: `key:` followed by an indented block of key/value couples (`BlockMappingNode`).
  - A line that looks like `key: value` only counts as a new mapping entry when the scalar key is
    followed by `:` on the **same** line (implicit YAML key). Indented text on the next line without
    that pattern is a **block scalar value** (plain or quoted), represented as `ValueNode` with
    `ScalarNode` / layout children, not as `KeyValueCoupleNode`.
  - A flow sequence or flow mapping may be the whole implicit block key when it is immediately
    followed by `:` on the same line (before a newline), e.g. `[flow]: block` or `{k: v}: block`.
    The same applies when the flow collection is prefixed by node properties (anchor and/or tag) on
    that line, e.g. `&k [a]: b`. The parser detects these patterns in `isKeyValueCoupleStart()` (via
    `isFlowCollectionFollowedByBlockValueIndicatorOnSameLine()` and
    `isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine()`), and for compact sequence
    entries in `parseSequenceEntryValue()`, so the flow collection is parsed as the key’s `name`
    node, not as a separate top-level flow value before an erroneous empty-key couple.
  - Literal and folded block scalars (`|` / `>`): after the header line, non-empty continuation lines
    use the same newline + indentation + scalar consumption as multiline plain scalars; the value may
    become `MultilinePlainScalarNode` when several `PLAIN_SCALAR` fragments are present.
    After an explicit-indent header (`|N` / `>N`, …), any further `NEWLINE` tokens that represent empty
    lines before the first indented content line are consumed as part of the value before the first
    `INDENTATION` / scalar fragment.
  - Block sequence: `key:` followed by an indented list of `-` entries (`BlockSequenceNode`
    with `SequenceEntryNode` children).
  - Flow mapping / sequence: `{...}` / `[...]`.
  - Inside flow collections, a mapping value may start after a line break; the lexer then uses
    `WHITESPACE` (not `INDENTATION`) before the node. Those values are parsed via `parseValue()`
    with sentinel `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::FLOW_COLLECTION_VALUE_PARENT`
    so newline-prefixed content is not mistaken for block `parseIndentedBlockValue()` at indent `0`
    (which would not consume the value and could split one `KeyValueCoupleNode` into two).
  - In flow context, separation spaces and comments after a value (before `,`, `]`, or `}`) are
    children of the enclosing `FlowSequenceNode` or `FlowMappingNode`, not of the `ValueNode` that
    carries the scalar or nested flow node. Spaces after `:` in a flow pair stay on `KeyValueCoupleNode`
    (see Example 7.19).
- Bare document content that is only a scalar (no mapping key) is parsed as a top-level `ValueNode`
  when the first token is a scalar and it is not an implicit key line.
- The bare-document block context follows YAML 1.2.2 rule [211]. The parser passes a sentinel
  `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT` (-1) into `parseValue()`
  so the same `$lineIndent <= $parentIndent` checks work at column 0; it is not a physical space count.
