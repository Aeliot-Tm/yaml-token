# Mapping of project token types to the YAML specification

This document maps `Aeliot\YamlToken\Enum\TokenType` values to the closest
terms in the official [YAML 1.2.2](https://yaml.org/spec/1.2.2/) grammar.

## Scope

- **Source of project names:** `src/Enum/TokenType.php` (string-backed enum).
- **Source of specification names:** YAML 1.2.2 Chapter 6–9 productions
  (rules `[n] production-name`), cited by rule number where applicable.
- **Default spec version:** 1.2.2. One token (`MERGE_INDICATOR`) is tied to
  YAML 1.1 merge-key behavior and has no production in the 1.2.2 grammar.

The specification defines a **context-free grammar**, not a token taxonomy.
This project emits a linear `TokenStream` with extra **service** tokens
(indentation, whitespace, newlines) that the spec expresses via parameterized
productions such as `s-indent(n)` rather than as named lexemes.

## Project vs specification naming style

| Aspect | Project (`TokenType`) | YAML 1.2.2 grammar |
|--------|---------------------|-------------------|
| Casing | `SCREAMING_SNAKE_CASE` | `kebab-case` with prefixes |
| Prefixes | None | `c-` (core), `s-` (separation), `b-` (break), `ns-` (content), `l-` (line), … |
| Granularity | Lexer-oriented slices of input | Parse productions (often multi-line) |
| Role in name | Flow context, “indicator”, “property”, “scalar” | Production kind (`c-mapping-value`, `ns-plain-one-line`, …) |

## Grammar prefix reference (YAML 1.2.2)

| Prefix | Role in spec |
|--------|----------------|
| `c-` | Core structural indicators and some node properties |
| `s-` | Separation (spaces, tabs, indentation parameters) |
| `b-` | Line breaks and chomping-related breaks |
| `ns-` | Non-specific node content |
| `nb-` | Non-break content inside quoted scalars |
| `l-` | Line-level constructs (directives, comments, document lines) |

## Correspondence legend

How each `TokenType` relates to the cited YAML 1.2.2 production (column **Correspondence** in the table below):

| Symbol | Meaning |
|:------:|---------|
| ≈ | Same role; naming differs mainly in style or extra words |
| ⊂ | Token covers part of the cited production (one character, a fragment, or body without header) |
| ⊃ | Token text spans more than the cited production (e.g. full comment line) |
| — | No direct production name in YAML 1.2.2; lexer-specific token |
| 1.1 | Not in the 1.2.2 grammar; tied to YAML 1.1 merge-key behavior |

Several spec line productions (directives, block headers) are emitted as
**several** `TokenType` values on one line; each fragment row uses ⊂ for its
piece of the production.

## Mapping table

- Sorted alphabetically by `TokenType` name.
- Correspondence legend see [bellow](#correspondence-legend).

| `TokenType` | YAML 1.2.2 (closest) | Rule | Correspondence | Notes |
|-------------|----------------------|------|:--------------:|-------|
| `ALIAS_NODE` | `c-ns-alias-node` | [104] | ≈ | Spec uses *alias node*; lexer emits the `*name` lexeme. |
| `ANCHOR_PROPERTY` | `c-ns-anchor-property` | [101] | ≈ | |
| `BLOCK_INDENT` | — | — | — | Spaces after `?` (`c-mapping-key`) on the same line when the next character is not `#` or a line break; see lexer behavior for explicit block keys. |
| `BYTE_ORDER_MARK` | `c-byte-order-mark` | [3] | ≈ | |
| `CHOMPING_INDICATOR` | `c-chomping-indicator` | [164] | ≈ | `+` (KEEP), `-` (STRIP); absence of indicator is CLIP in the header production. |
| `COMMENT` | `c-comment` + comment text | [12], [75] - [79] | ⊃ | Token is `#` through end of comment text on the line; newline is `NEWLINE`. |
| `DOCUMENT_END` | `c-document-end` | [204] | ≈ | `...` not followed by non-whitespace. |
| `DOCUMENT_START` | `c-directives-end` | [203] | ≈ | Marker is `---` in both; spec name is *directives end*, not *document start*. |
| `DOUBLE_QUOTED_SCALAR` | `c-double-quoted` | [109] | ⊂ | Full `"…"` lexeme; spec production includes line breaks and indentation rules. |
| `EXPLICIT_KEY_INDICATOR` | `c-mapping-key` | [5] | ≈ | `?` when recognized as mapping key; spec does not use *explicit* in the production name. |
| `FLOW_ENTRY` | `c-collect-entry` | [7] | ≈ | Comma in flow collections; spec name is *collect entry*. |
| `FLOW_MAPPING_END` | `c-mapping-end` | [11] | ≈ | `}` |
| `FLOW_MAPPING_START` | `c-mapping-start` | [10] | ≈ | `{` |
| `FLOW_SEQUENCE_END` | `c-sequence-end` | [9] | ≈ | `]` |
| `FLOW_SEQUENCE_START` | `c-sequence-start` | [8] | ≈ | `[` |
| `FOLDED_BLOCK_SCALAR` | `c-l+folded`, folded content | [174] - [181] | ⊂ | Block **body** only (after header line); header uses indicator, chomp, and indentation tokens. |
| `FOLDED_BLOCK_SCALAR_INDICATOR` | `c-folded` | [17] | ⊂ | Single `>` character starting the block scalar header. |
| `INDENT` | `s-indent(n)` (parameter) | §6.4 | — | Leading spaces at column 1 (U+0020 only); not a separate grammar token. |
| `INDENTATION_INDICATOR` | `c-indentation-indicator` | [163] | ≈ | Digit `1`-`9` on the block scalar header line. |
| `LITERAL_BLOCK_SCALAR` | `c-l+literal`, literal content | [170] - [173] | ⊂ | Block **body** only; header emitted separately. |
| `LITERAL_BLOCK_SCALAR_INDICATOR` | `c-literal` | [16] | ⊂ | Single `\|` character starting the block scalar header. |
| `MERGE_INDICATOR` | — (merge type, YAML 1.1) | — | 1.1 | `<<` when recognized as merge key before `:`; not defined in YAML 1.2.2 grammar. |
| `NEWLINE` | `b-line-feed`, `b-carriage-return`, `b-break` | [24] - [28] | ⊃ | One type for `\n`, `\r`, and `\r\n`. |
| `PLAIN_SCALAR` | `ns-plain-one-line`, `ns-plain-multi-line` | [133], [135] | ⊂ | Raw plain scalar fragment; spec ties content to context `c` and indentation `n`. |
| `RESERVED_DIRECTIVE` | `ns-reserved-directive` | [83] | ⊂ | Unknown `%` directive payload (often one token for the line tail). |
| `SEQUENCE_ENTRY` | `c-sequence-entry` | [4] | ≈ | `-` when recognized as sequence entry. |
| `SINGLE_QUOTED_SCALAR` | `c-single-quoted` | [120] | ⊂ | Full `'…'` lexeme. |
| `TAG_DIRECTIVE` | `ns-tag-directive` (fragment) | [88] | ⊂ | `%TAG` keyword part of a tag directive line. |
| `TAG_HANDLE` | `c-tag-handle`, named handles | [89] - [92] | ⊂ | `!`, `!!`, or `!name!` on a `%TAG` line. |
| `TAG_PREFIX` | `ns-tag-prefix` | [93] | ⊂ | URI prefix on a `%TAG` line. |
| `TAG_PROPERTY` | `c-ns-tag-property` | [97] | ⊃ | Full node tag lexeme (`c-verbatim-tag`, `c-ns-shorthand-tag`, or `c-non-specific-tag`). |
| `VALUE_INDICATOR` | `c-mapping-value` | [6] | ≈ | `:` when recognized as mapping value. |
| `WHITESPACE` | `s-space`, `s-tab`, `s-white` | [31] - [33] | ⊃ | Horizontal whitespace not emitted as `INDENT` (e.g. mid-line; tab at column 1). |
| `YAML_DIRECTIVE` | `ns-yaml-directive` (fragment) | [86] | ⊂ | `%YAML` keyword part of a YAML directive line. |
| `YAML_VERSION` | `ns-yaml-version` | [87] | ⊂ | Version digits (and `.`) on a `%YAML` line. |

## Decomposed directive and block-scalar lines

The spec line productions below are **not** single `TokenType` values; the lexer
emits several token types per line (each fragment is ⊂ of the line production).

| Spec production | Rule | Emitted `TokenType` values (typical order) |
|-----------------|------|---------------------------------------------|
| `l-directive` | [82] | `%` branch: `YAML_DIRECTIVE` / `TAG_DIRECTIVE` / `RESERVED_DIRECTIVE`, plus `WHITESPACE`, `VALUE_INDICATOR`, `YAML_VERSION`, `TAG_HANDLE`, `TAG_PREFIX`, `COMMENT`, `NEWLINE` as applicable |
| `ns-yaml-directive` | [86] | `YAML_DIRECTIVE`, `WHITESPACE`, optional `VALUE_INDICATOR`, `YAML_VERSION` |
| `ns-tag-directive` | [88] | `TAG_DIRECTIVE`, `TAG_HANDLE`, `TAG_PREFIX`, … |
| `c-b-block-header` | [162] | `LITERAL_BLOCK_SCALAR_INDICATOR` or `FOLDED_BLOCK_SCALAR_INDICATOR`, `CHOMPING_INDICATOR`, `INDENTATION_INDICATOR`, `WHITESPACE`, `COMMENT`, then `NEWLINE` |
| `c-l+literal` / `c-l+folded` | [170], [174] | Header tokens above, then body as `LITERAL_BLOCK_SCALAR` or `FOLDED_BLOCK_SCALAR` (or per-line `INDENT` / `PLAIN_SCALAR` / `NEWLINE` when an indentation indicator is present) |

## References

- [YAML 1.2.2 specification](https://yaml.org/spec/1.2.2/)
- [Chapter 6.4 — Separation Spaces](https://yaml.org/spec/1.2.2/#64-separation-spaces)
- [Chapter 6.8 — Directives](https://yaml.org/spec/1.2.2/#68-directives)
- [Chapter 7.3 — Flow Styles](https://yaml.org/spec/1.2.2/#73-flow-styles)
- [Chapter 8.1 — Block Scalars](https://yaml.org/spec/1.2.2/#81-block-scalars)
- [Chapter 9.1 — Document Stream](https://yaml.org/spec/1.2.2/#91-document-stream)
- [YAML 1.1 merge type](https://yaml.org/type/merge.html) (for `MERGE_INDICATOR`)
