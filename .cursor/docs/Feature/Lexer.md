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
  - `%YAML` lines: when the keyword is followed by horizontal whitespace, `:`, or a digit, the line is split into `DIRECTIVE_YAML` (`%YAML`), optional `WHITESPACE`, optional `VALUE_INDICATOR` (`:`), optional `WHITESPACE`, `DIRECTIVE_YAML_VERSION` (text until horizontal whitespace, line break, or `#` that starts a comment), optional `WHITESPACE`, optional `COMMENT`, then the line break is a separate `NEWLINE`. If `%YAML` is immediately followed by a line break, or not followed by whitespace/`:`/digit (e.g. glued suffix), the rest of the line is emitted as a single `DIRECTIVE_YAML` token as before.
  - `%TAG` lines: when the keyword is followed by horizontal whitespace, `!` (start of a tag handle), or end of input, the line is split into `DIRECTIVE_TAG` (`%TAG`), optional `WHITESPACE`, `DIRECTIVE_TAG_HANDLE` (`!`, `!!`, or `!name!`), optional `WHITESPACE`, `DIRECTIVE_TAG_PREFIX` (URI prefix until whitespace, line break, or `#` that starts a comment), optional `WHITESPACE`, optional `COMMENT`, then the line break is a separate `NEWLINE`. If `%TAG` is immediately followed by a line break, or `%TAG` is not followed by whitespace/`!` (e.g. glued text), the rest of the line is emitted as a single `DIRECTIVE_TAG` token as before.
  - any other `%...` until line break → `DIRECTIVE`
- **Flow indicators**: `[ ] { } ,` are emitted as flow tokens:
  - `FLOW_SEQUENCE_START`, `FLOW_SEQUENCE_END`
  - `FLOW_MAPPING_START`, `FLOW_MAPPING_END`
  - `FLOW_ENTRY`
- **Quoted scalars**:
  - `"`...`"` → `DOUBLE_QUOTED_SCALAR` (backslash escapes are preserved as raw text)
  - `'`...`'` → `SINGLE_QUOTED_SCALAR` (`''` is preserved as escaped `'`)
- **Block scalars**:
  - `|` / `>` start a block scalar when followed by whitespace, `+`/`-`, or a digit (`0`–`9`, the block-indentation indicator)
  - `LITERAL_BLOCK_SCALAR_INDICATOR` / `FOLDED_BLOCK_SCALAR_INDICATOR` for the `|` / `>` character
  - the rest of the block scalar header line uses the same rules as elsewhere on the line: `WHITESPACE`, `COMMENT`,
    `BLOCK_SCALAR_CHOMPING_INDICATOR` (`+` or `-`), `BLOCK_SCALAR_INDENTATION_INDICATOR` (one digit),
    then `NEWLINE` ending the header line; the cursor holds the expected body token type (`LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR`)
    while the header line is open
  - **Body tokenization**: if the header included a digit `BLOCK_SCALAR_INDENTATION_INDICATOR`, the block body is not a single
    `LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR` token; it is split per physical line into leading horizontal whitespace as
    `INDENTATION`, non-whitespace line suffix as `PLAIN_SCALAR`, and line breaks as `NEWLINE` (same raw bytes as in the source).
    Otherwise the next token is one `pendingBlockScalarBody` body token as before
  - chomping: `BlockScalarChomping` on the cursor is set from `+` / `-` (`Keep` / `Strip`); if the header ends without them, it defaults to `Clip` when the body is promoted
  - **Strip** (`-`): after the block body is read, the line break that ends the last body line with non-horizontal-whitespace content is excluded from the block body token, together with any following trailing empty lines (lines with only horizontal whitespace in the body); the lexer rewinds the byte offset and line/column so those bytes are emitted next as normal tokens (`NEWLINE`, and leading `INDENTATION` when empty lines were indented in the source)
  - `LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR` carry only the indented block body (raw text), without the indicator or header line
- **Structural indicators with lookahead**:
  - `-` is `SEQUENCE_ENTRY` only when followed by whitespace or end of input
  - `?` is `EXPLICIT_KEY_INDICATOR` only when followed by whitespace or end of input
  - `:` is `VALUE_INDICATOR` only when followed by whitespace, `#`, `[`, `{`, `"`, `'`, or end of input
  - `<<` is `MERGE_INDICATOR` (YAML 1.1 merge key) only when followed by optional horizontal whitespace and the same `:` lookahead as for `VALUE_INDICATOR`; otherwise plain scalar `<` / `<<`… is tokenized as `PLAIN_SCALAR`
- **Anchors, aliases, tags**:
  - `&name` → `ANCHOR`, `*name` → `ALIAS`
  - Explicit tag property at a node (not `%TAG` directive lines):
    - Shorthand primary `!suffix` → `TAG_HANDLE_PRIMARY` (`!`), `TAG_BODY` (suffix)
    - Shorthand secondary `!!suffix` → `TAG_HANDLE_SECONDARY` (`!!`), `TAG_BODY` (suffix)
    - Shorthand named `!name!suffix` → `TAG_HANDLE_NAMED` (`!name!`), `TAG_BODY` (suffix)
    - Non-specific explicit tag `!` alone → `TAG_NON_SPECIFIC` (`!`)
    - Verbatim `!<...>` → `TAG_HANDLE_VERBATIM` (full `!<...>` including brackets)
  - Tag suffix / shorthand continues until a forbidden delimiter: whitespace, `[]{} , : #` or `\0`
  - exception (YAML 1.0-style global tag shorthand): a comma followed by four ASCII digits (`!,NNNN`) is part of the tag (registration year after the domain), not a flow `,` token
  - after that `!,NNNN` segment, optional `-MM` / `-DD` (tag URI / ISO date parts) and the rest of the shorthand continue as normal tag characters (for example `!domain,2000-01-01/path`)
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

