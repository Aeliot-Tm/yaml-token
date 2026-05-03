# Parser

## Goal

The parser builds a tree of `Node` objects from the lexer `TokenStream`: stream, documents,
block and flow collections, scalars, and layout (comments, indentation, newlines, structural tokens).

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
  with the `DIRECTIVE_YAML` keyword token and child nodes for optional horizontal whitespace,
  optional `VALUE_INDICATOR` (`:`), and required `DIRECTIVE_YAML_VERSION`
  (as [`YamlDirectiveVersionNode`](../../../src/Node/YamlDirectiveVersionNode.php)).
  Horizontal whitespace and comments after the version token stay at document level
  (same loop as other layout). If a newline or comment appears before a version token, or the token stream
  ends before a version token, the parser throws [`LogicException`](../../../src/Parser/Parser.php).
- `%TAG` directive: built as [`TagDirectiveNode`](../../../src/Node/TagDirectiveNode.php) 
  with the `DIRECTIVE_TAG` keyword token and child nodes for optional horizontal whitespace,
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
- Collections:
  - Block mapping: `key:` followed by an indented block of key/value couples (`BlockMappingNode`).
  - A line that looks like `key: value` only counts as a new mapping entry when the scalar key is
    followed by `:` on the **same** line (implicit YAML key). Indented text on the next line without
    that pattern is a **block scalar value** (plain or quoted), represented as `ValueNode` with
    `ScalarNode` / layout children, not as `KeyValueCoupleNode`.
  - Literal and folded block scalars (`|` / `>`): after the header line, non-empty continuation lines
    use the same newline + indentation + scalar consumption as multiline plain scalars; the value may
    become `MultilinePlainScalarNode` when several `PLAIN_SCALAR` fragments are present.
  - Block sequence: `key:` followed by an indented list of `-` entries (`BlockSequenceNode`
    with `SequenceEntryNode` children).
  - Flow mapping / sequence: `{...}` / `[...]`.
  - Inside flow collections, a mapping value may start after a line break; the lexer then uses
    `WHITESPACE` (not `INDENTATION`) before the node. Those values are parsed via `parseValue()`
    with sentinel `FLOW_COLLECTION_VALUE_PARENT_INDENT` so newline-prefixed content is not mistaken
    for block `parseIndentedBlockValue()` at indent `0` (which would not consume the value and could
    split one `KeyValueCoupleNode` into two).
- Bare document content that is only a scalar (no mapping key) is parsed as a top-level `ValueNode`
  when the first token is a scalar and it is not an implicit key line.
- The bare-document block context follows YAML 1.2.2 rule [211]. The parser passes a sentinel `BARE_DOCUMENT_BLOCK_PARENT_INDENT` (-1) into `parseValue()` so the same `$lineIndent <= $parentIndent` checks work at column 0; it is not a physical space count.
