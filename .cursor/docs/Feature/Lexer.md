# Lexer

## Goal

The lexer converts YAML source text into a linear `TokenStream` while preserving
formatting details (indentation, whitespace, newlines, comments).
Mapping tests assert the exact token sequence, including service tokens.

## Tokenization contract

The rules below describe the practical behavior relied upon by lexer unit tests.

- **Newlines**: `\r\n`, `\r`, `\n` are emitted as `NEWLINE`. Newline resets tracked indentation state.
- **Indentation vs whitespace**:
  - At column 1, a run of **spaces only** (U+0020) is emitted as `INDENTATION`.
  - A **tab** at column 1 is not part of `INDENTATION` (YAML forbids tabs in structural indent):
    it is emitted as `WHITESPACE` together with any following horizontal whitespace on the same run,
    like elsewhere on the line.
  - After a space-only `INDENTATION`, a tab on the same line is the start of the next `WHITESPACE`
    token (e.g. `  \t` → `INDENTATION` `"  "` then `WHITESPACE` `"\t"`).
  - Elsewhere within a line, a run of spaces/tabs is emitted as `WHITESPACE`.
- **Document markers**: `---` → `DOCUMENT_START`, `...` → `DOCUMENT_END`.
- **Comments**: `#...` until line break is `COMMENT` (newline is a separate `NEWLINE` token).
- **Directives**:
  - `%YAML` lines: the name must be exact — the character after `L` must be horizontal whitespace,
    `:`, a digit, a line break, or end of input. Otherwise (e.g. `%YAMLL`), the whole `%...` line
    through the line break is a generic `DIRECTIVE` token. When the boundary matches, the line
    is split into `DIRECTIVE_YAML` (`%YAML`), optional `WHITESPACE`, optional `VALUE_INDICATOR` (`:`),
    optional `WHITESPACE`, `DIRECTIVE_YAML_VERSION` (text until horizontal whitespace, line break,
    or `#` that starts a comment), optional `WHITESPACE`, optional `COMMENT`, then the line break
    is a separate `NEWLINE`.
  - `%TAG` lines: when the keyword is followed by horizontal whitespace, `!` (start of a tag handle),
    or end of input, the line is split into `DIRECTIVE_TAG` (`%TAG`), optional `WHITESPACE`,
    `DIRECTIVE_TAG_HANDLE` (`!`, `!!`, or `!name!`), optional `WHITESPACE`, `DIRECTIVE_TAG_PREFIX`
    (URI prefix until whitespace, line break, or `#` that starts a comment), optional `WHITESPACE`,
    optional `COMMENT`, then the line break is a separate `NEWLINE`. If `%TAG` is immediately
    followed by a line break, or `%TAG` is not followed by whitespace/`!` (e.g. glued text),
    the rest of the line is emitted as a single `DIRECTIVE_TAG` token as before.
  - any other `%...` until line break → `DIRECTIVE`
- **Flow indicators**: `[ ] { } ,` are emitted as flow tokens:
  - `FLOW_SEQUENCE_START`, `FLOW_SEQUENCE_END`
  - `FLOW_MAPPING_START`, `FLOW_MAPPING_END`
  - `FLOW_ENTRY`
- **Quoted scalars**:
  - `"`...`"` → `DOUBLE_QUOTED_SCALAR` (backslash escapes are preserved as raw text)
  - `'`...`'` → `SINGLE_QUOTED_SCALAR` (`''` is preserved as escaped `'`)
- **Block scalars**:
  - `|` / `>` start a block scalar when followed by whitespace, `+`/`-`, or a digit (`0`–`9`,
    the block-indentation indicator)
  - `LITERAL_BLOCK_SCALAR_INDICATOR` / `FOLDED_BLOCK_SCALAR_INDICATOR` for the `|` / `>` character
  - the rest of the block scalar header line uses the same rules as elsewhere on the line:
    `WHITESPACE`, `COMMENT`, `BLOCK_SCALAR_CHOMPING_INDICATOR` (`+` or `-`),
    `BLOCK_SCALAR_INDENTATION_INDICATOR` (one digit), then `NEWLINE` ending the header line;
    the cursor holds the expected body token type (`LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR`)
    while the header line is open
  - **Body tokenization**: if the header included a digit `BLOCK_SCALAR_INDENTATION_INDICATOR`,
    the block body is not a single `LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR` token;
    it is split per physical line into leading horizontal whitespace as `INDENTATION`,
    non-whitespace line suffix as `PLAIN_SCALAR`, and line breaks as `NEWLINE` (same raw bytes
    as in the source). Otherwise the next token is one `pendingBlockScalarBody` body token as before
  - **Single body token** (`|` / `>` without splitting per line): when scanning where the block body ends,
    only **leading spaces** (U+0020) on each line contribute to the indent depth used for comparison;
    tabs in that prefix are still copied into the body bytes but do not increase that depth
    (YAML structural indent is space-only). A line whose space-only indent is shallower than the
    first body line ends the block as soon as that indent is read (the body buffer may end with
    spaces, not a newline); the same scan builds the raw body that is split per line when the header
    had a `BLOCK_SCALAR_INDENTATION_INDICATOR` digit.
  - **Explicit digit body** (same scan as the single-token path, then split per line): the YAML
    explicit floor is **key parent indent** (spaces before the mapping key on the header line,
    taken from the last `PLAIN_SCALAR` before `VALUE_INDICATOR` on that line) plus the digit.
    The first non-empty body line then picks the comparison threshold: if its indent is at least
    two spaces deeper than that floor, that line’s indent is used to end the body on shallower
    lines (sibling keys such as `go_yaml/literal-scalars`); otherwise the floor alone is used so a
    later line may still sit on the floor (`go_yaml/more-indented-lines-at-the-beginning-of-folded-block-scalars`).
  - chomping: `BlockScalarChomping` on the cursor is set from `+` / `-` (`Keep` / `Strip`);
    if the header ends without them, it defaults to `Clip` when the body is promoted
  - **Strip** (`-`): after the block body is read, the line break that ends the last body line
    with non-horizontal-whitespace content is excluded from the block body token, together
    with any following trailing empty lines (lines with only horizontal whitespace in the body);
    the lexer rewinds the byte offset and line/column so those bytes are emitted next as normal tokens
    (`NEWLINE`, and leading `INDENTATION` when empty lines were indented in the source)
  - `LITERAL_BLOCK_SCALAR` / `FOLDED_BLOCK_SCALAR` carry only the indented block body (raw text),
    without the indicator or header line
- **Structural indicators with lookahead**:
  - `-` is `SEQUENCE_ENTRY` only when followed by whitespace or end of input
  - `?` is `EXPLICIT_KEY_INDICATOR` only when followed by whitespace or end of input
  - `:` is `VALUE_INDICATOR` only when followed by whitespace or end of input;
    inside a flow collection (`flowDepth > 0`), additionally when followed by a c-flow-indicator
    (`,`, `[`, `]`, `{`, `}`). In block context any other character right after `:` keeps it
    as part of a plain scalar (per YAML 1.2.2 §7.3.3 rule [130] `ns-plain-char(c)`),
    so e.g. `:{`, `:[`, `:"`, `:'`, `:#` are valid scalar content
  - `<<` is `MERGE_INDICATOR` (YAML 1.1 merge key) only when followed by optional horizontal
    whitespace and the same `:` lookahead as for `VALUE_INDICATOR`; otherwise plain scalar
    `<` / `<<`… is tokenized as `PLAIN_SCALAR`
- **Anchors, aliases, tags**:
  - `&name` → `ANCHOR`, `*name` → `ALIAS`
  - Explicit tag property at a node (not `%TAG` directive lines): one `TAG` token with the full lexeme
    (`!`, `!suffix`, `!!suffix`, `!name!suffix`, or `!<...>` including brackets)
  - Tag suffix / shorthand continues until a forbidden delimiter: whitespace, `[]{} , : #` or `\0`
  - exception (YAML 1.0-style global tag shorthand): a comma followed by four ASCII digits (`!,NNNN`)
    is part of the tag (registration year after the domain), not a flow `,` token
  - after that `!,NNNN` segment, optional `-MM` / `-DD` (tag URI / ISO date parts) and the rest
    of the shorthand continue as normal tag characters (for example `!domain,2000-01-01/path`)
  - **Block multiline plain continuation**: after a newline that follows `PLAIN_SCALAR` content
    for a block mapping value (`VALUE_INDICATOR` with `flowDepth == 0`) or a block sequence entry
    (`SEQUENCE_ENTRY` on the same line as the first plain fragment), the next line may continue
    that plain scalar with **greater** indentation than the key / entry line (`plainScalarContinuationBaseIndent`).
    On such continuation lines, a leading `!` (and prefixes like `!!`, `!<`) is **not** split into explicit tag tokens;
    it stays inside `PLAIN_SCALAR` until the line ends. A leading `-` followed by separation space is also kept
    inside `PLAIN_SCALAR` when the line indent exceeds the base by less than
    `MIN_NESTED_BLOCK_COLLECTION_INDENT_DELTA` (2) — YAML Test Suite AB8U / go-yaml lenient disambiguation
  - against a nested block sequence entry at a larger indent step. Continuation mode resets when indentation
    does not exceed the base indent, when a new line starts at column 1 without leading spaces
    (sibling key or sequence entry at the root), or on structural `SEQUENCE_ENTRY` / `DOCUMENT_START` /
    `DOCUMENT_END`, or opening `[` / `{`.
- **Plain scalars**: everything else is `PLAIN_SCALAR` until a stop character is reached: line break, `[ ] { } , : #`.
  - `?` is only a stop character at the start of a token (empty result so far); inside an already-started
    plain scalar `?` is a valid `ns-plain-char` per YAML 1.2.2 §7.3.3 rule [129] and does not end the scalar
  - trailing whitespace before newline or a comment does not become part of the plain scalar token
- **Fallback**: anything not consumed by rules above is emitted as `UNRECOGNIZED` (one UTF-8 code point fragment).

## Fixture and test rules

- **Spec fixtures**: `tests/fixture/spec/<version>/` and `tests/fixture/spec_extra/<version>/ should contain
  one syntactic feature per file. Avoid comments except `comment-*.yaml` files.
- **Fixture regression**: [`FixtureLexerMappingTest`](../../../tests/unit/Lexer/FixtureLexerMappingTest.php)
  compares each YAML under `tests/fixture/` to generated snapshots in `tests/lexer_expectations/`
  (regenerate with `composer lexer-expectations` or `php bin/dev/generate-lexer-expectations.php`;
  optional `--force`, repeatable `--only=relative/path.yaml` under `tests/fixture/`).
  [`LexerMappingTestCase`](../../../tests/unit/Lexer/LexerMappingTestCase.php) runs the same check against
  the snapshot when `tests/lexer_expectations/<same-relative-path>.php` exists (e.g. not for `tests/fixture/invalid/`).
  Handwritten subclasses remain only for YAML under `tests/fixture/invalid/` (no generated snapshots).
  In generated snapshot PHP, token `text` values that contain control characters (including newlines) are written
  as double-quoted strings with escapes (for example `"\n"`) so the files behave consistently
  across OS and Git line-ending settings.
- **Broken / invalid indent (tabs in indent)**: minimal samples in `tests/fixture/invalid/`;
  `LexerBrokenIndentTabTest` asserts the split above.
- **Example 6.5 (YAML 1.2 spec §6.4 empty lines)**: minimal files `double-quoted-empty-line.yaml`
  (flow double-quoted with a blank line inside the string) and `literal-chomping-clipped-empty-lines.yaml`
  (`|-` with body text `Clipped empty lines` and trailing empty lines in the block body) mirror
  the spec’s Folding / Chomping illustration; the same structure appears in covering fixtures `*.yaml`
  under keys `double_quoted_empty_line` and `literal_chomping_clipped_empty_lines`.

