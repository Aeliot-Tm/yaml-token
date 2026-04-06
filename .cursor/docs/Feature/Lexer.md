# Lexer

## Goal

The lexer converts YAML source text into a linear `TokenStream` while preserving formatting details (indentation, whitespace, newlines, comments).
Mapping tests assert the exact token sequence, including service tokens.

## Tokenization contract

The rules below describe the practical behavior relied upon by lexer unit tests.

- **Newlines**: `\r\n`, `\r`, `\n` are emitted as `NEWLINE`. Newline resets tracked indentation state.
- **Indentation vs whitespace**:
  - At column 1, a run of spaces/tabs is emitted as `INDENTATION`.
  - Elsewhere within a line, a run of spaces/tabs is emitted as `WHITESPACE`.
  - Tab counts as 4 spaces for indentation tracking.
- **Document markers**: `---` → `DOCUMENT_START`, `...` → `DOCUMENT_END`.
- **Comments**: `#...` until line break is `COMMENT` (newline is a separate `NEWLINE` token).
- **Directives**:
  - `%YAML...` until line break → `YAML_DIRECTIVE`
  - `%TAG...` until line break → `TAG_DIRECTIVE`
  - any other `%...` until line break → `DIRECTIVE`
- **Flow indicators**: `[ ] { } ,` are emitted as flow tokens:
  - `FLOW_SEQUENCE_START`, `FLOW_SEQUENCE_END`
  - `FLOW_MAPPING_START`, `FLOW_MAPPING_END`
  - `FLOW_ENTRY`
- **Quoted scalars**:
  - `"`...`"` → `DOUBLE_QUOTED_SCALAR` (backslash escapes are preserved as raw text)
  - `'`...`'` → `SINGLE_QUOTED_SCALAR` (`''` is preserved as escaped `'`)
- **Block scalars**:
  - `|` / `>` start a block scalar when followed by whitespace or `+`/`-`
  - emitted as a single token: `LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR`
  - token text includes the header and subsequent indented content as raw text
- **Structural indicators with lookahead**:
  - `-` is `SEQUENCE_ENTRY` only when followed by whitespace or end of input
  - `?` is `MAPPING_KEY` only when followed by whitespace or end of input
  - `:` is `MAPPING_VALUE` only when followed by whitespace, `#`, `[`, `{`, `"`, `'`, or end of input
- **Anchors, aliases, tags**:
  - `&name` → `ANCHOR`, `*name` → `ALIAS`
  - `!<...>` and `!tag` → `TAG`
  - the name continues until a forbidden delimiter: whitespace, `[]{} , : #` or `\0`
- **Plain scalars**: everything else is `PLAIN_SCALAR` until a stop character is reached: line break, `[ ] { } , : # ?`.
  - trailing whitespace before newline or a comment does not become part of the plain scalar token
- **Fallback**: anything not consumed by rules above is emitted as `UNRECOGNIZED` (one UTF-8 code point fragment).

## Fixture and test rules

- **Spec fixtures**: `tests/fixture/spec/<version>/` should contain one syntactic feature per file. Avoid comments except `comment-*.yaml` files.
- **Mapping tests**: `tests/unit/Lexer/Spec/*` must assert token sequences exactly (`TokenType` + `text`), including `INDENTATION`, `WHITESPACE`, and `NEWLINE`.

