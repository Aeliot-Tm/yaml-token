# Parser

## Goal

The parser builds a tree of `Node` objects from the lexer `TokenStream`: stream, documents, block and flow collections, scalars, and layout (comments, indentation, newlines, structural tokens).

## Technical details

- Entry points: [`Parser::parse`](../../src/Parser/Parser.php) (lexes input), [`Parser::parseStream`](../../src/Parser/Parser.php) for an existing `TokenStream`.
- Collections:
  - Block mapping: `key:` followed by an indented block of key/value couples (`BlockMappingNode`).
  - Block sequence: `key:` followed by an indented list of `-` entries (`BlockSequenceNode` with `SequenceEntryNode` children).
  - Flow mapping / sequence: `{...}` / `[...]`.
