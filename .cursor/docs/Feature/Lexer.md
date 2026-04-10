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
  - `%YAML...` until line break → `DIRECTIVE_YAML`
  - `%TAG...` until line break → `DIRECTIVE_TAG`
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
  - `LITERAL_BLOCK_SCALAR_INDICATOR` / `FOLDED_BLOCK_SCALAR_INDICATOR` for the `|` / `>` character
  - the rest of the block scalar header line uses the same rules as elsewhere on the line: `WHITESPACE`, `COMMENT`,
    `BLOCK_SCALAR_CHOMPING_INDICATOR` (`+` or `-`), `BLOCK_SCALAR_INDENTATION_INDICATOR` (one digit),
    then `NEWLINE` ending the header line; the cursor holds the expected body token type (`LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR`)
    while the header line is open, then `pendingBlockScalarBody` for the body token (no token queue)
  - chomping: `BlockScalarChomping` on the cursor is set from `+` / `-` (`Keep` / `Strip`); if the header ends without them, it defaults to `Clip` when the body is promoted
  - **Strip** (`-`): after the block body is read, the line break that ends the last body line with non-horizontal-whitespace content is excluded from the block body token, together with any following trailing empty lines (lines with only horizontal whitespace in the body); the lexer rewinds the byte offset and line/column so those bytes are emitted next as normal tokens (`NEWLINE`, and leading `INDENTATION` when empty lines were indented in the source)
  - `LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR` carry only the indented block body (raw text), without the indicator or header line
- **Structural indicators with lookahead**:
  - `-` is `SEQUENCE_ENTRY` only when followed by whitespace or end of input
  - `?` is `EXPLICIT_KEY_INDICATOR` only when followed by whitespace or end of input
  - `:` is `VALUE_INDICATOR` only when followed by whitespace, `#`, `[`, `{`, `"`, `'`, or end of input
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
- **Example 6.5 (YAML 1.2 spec §6.4 empty lines)**: minimal files `double-quoted-empty-line.yaml` (flow double-quoted with a blank line inside the string)
  and `literal-chomping-clipped-empty-lines.yaml` (`|-` with body text `Clipped empty lines` and trailing empty lines in the block body)
  mirror the spec’s Folding / Chomping illustration; the same structure appears in covering fixtures `*.yaml`
  under keys `double_quoted_empty_line` and `literal_chomping_clipped_empty_lines`.

