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
  - Block sequence: `key:` followed by an indented list of `-` entries (`BlockSequenceNode`
    with `SequenceEntryNode` children).
  - Flow mapping / sequence: `{...}` / `[...]`.
