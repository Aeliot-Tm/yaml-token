# Specification Cover Fixtures Structure

Specification-related test fixtures live in `tests/fixture/spec/` and are organized
by YAML specification version. The `tests/fixture/` root is reserved for other
(non-specification) fixtures.

## Covering Fixtures

Files `<version>.yaml` in `tests/fixture/spec/` are **covering fixtures** —
single files that contain all syntactic elements of a given YAML specification version
in one document stream. They are used as a compact reference and for full-coverage smoke testing.

- `1.0.yaml` — YAML 1.0 (2004-01-29)
- `1.1.yaml` — YAML 1.1 (2005-01-18)
- `1.2.0.yaml` — YAML 1.2.0 (2009-07-21)
- `1.2.1.yaml` — YAML 1.2.1 (2009-10-01)
- `1.2.2.yaml` — YAML 1.2.2 (2021-10-01)

## Minimal Examples

Directories `<version>/` contain the same coverage **split into minimal examples** —
one syntactic feature per file. File names are self-descriptive; the files themselves
contain no comments (except for `comment-*.yaml` files that specifically test comment syntax).

### File naming (section suffixes)

Minimal example files use the format:

`<feature>_<section>.yaml`

- `<feature>`: a stable, self-descriptive feature name (e.g. `explicit-flow-pair`, `folded-block`, `directive-tag`).
- `<section>`: the **primary section number** of the official YAML specification for the matching `<version>`
  that most directly defines the syntax being exercised (e.g. `4.5.2`, `9.1.1`, `8.2.1`).

When a fixture relates to multiple places in the spec (common for cross-cutting rules like indentation, separation, or comments),
the suffix should still contain a single number: pick the section that **introduces/defines the construct under test**,
not a tangential section that merely mentions it.

Notes:

- The section suffix is version-specific. The same `<feature>` can map to different `<section>` numbers across YAML 1.0, 1.1 and 1.2.x
  because the specification structure and numbering differs.
- The `1.2.0/`, `1.2.1/`, `1.2.2/` directories must remain identical; therefore, section suffixes
  and file names in these directories must be kept identical as well.
- If a file is renamed, update all test references that point to it (many tests use string paths to `tests/fixture/spec/<version>/...`).

To (re)generate and apply these renames consistently, use `bin/spec_fixture_suffixes.py`
(it performs renames via `git mv` and rewrites test references).

### Directory layout

```
tests/fixture/spec/
├── 1.0.yaml              # covering fixture
├── 1.0/                   # 61 minimal examples
├── 1.1.yaml
├── 1.1/                   # 68 minimal examples
├── 1.2.0.yaml
├── 1.2.0/                 # 66 minimal examples
├── 1.2.1.yaml
├── 1.2.1/                 # 66 minimal examples (identical to 1.2.0/)
├── 1.2.2.yaml
└── 1.2.2/                 # 66 minimal examples (identical to 1.2.0/)
```

### Common files (present in every version)

These files have identical content across all versions unless the feature
has version-specific syntax (e.g. `boolean.yaml`, `integer.yaml`, `double-quoted-escapes.yaml`):

| Category | Files |
|---|---|
| Documents | `bare-document`, `document-start`, `document-end`, `multi-document` |
| Block collections | `block-sequence`, `block-mapping`, `compact-nested`, `complex-key`, `sequence-entry-types` |
| Flow collections | `flow-sequence`, `flow-mapping`, `flow-sequence-trailing-comma`, `flow-mapping-trailing-comma`, `flow-empty-key`, `flow-omitted-value`, `single-pair-flow`, `explicit-flow-pair`, `implicit-key` |
| Plain scalars | `plain-scalar`, `plain-multiline`, `plain-special-chars` |
| Single-quoted | `single-quoted`, `single-quoted-escape`, `single-quoted-multiline` |
| Double-quoted | `double-quoted`, `double-quoted-empty-line`, `double-quoted-escapes`, `double-quoted-escaped-newline`, `double-quoted-multiline`, `double-quoted-unicode` |
| Block scalars | `literal-block`, `literal-chomping-clipped-empty-lines`, `literal-empty`, `literal-keep`, `literal-strip`, `folded-block`, `folded-strip`, `folded-strip-indented-empty-tail`, `folded-strip-then-sibling-key`, `folded-keep`, `indent-indicator`, `block-scalar-tab` |
| Types | `null`, `boolean`, `integer`, `float`, `float-special`, `timestamp`, `empty-scalar`, `empty-scalar-blank-before-continuation`, `empty-scalar-multiple` |
| Anchors & Tags | `anchor-alias`, `tag-builtin`, `tag-binary` |
| Comments | `comment-full-line`, `comment-inline`, `comment-block-indicator`, `comment-between-docs`, `comment-after-marker` |

### Version-specific files

Files that exist only in certain versions because the feature was added or removed:

| File | 1.0 | 1.1 | 1.2.x | Notes |
|---|---|---|---|---|
| `directive` | `%YAML:1.0` | `%YAML 1.1` | `%YAML 1.2` | syntax differs |
| `directive-tag` | — | yes | yes | `%TAG` added in 1.1 |
| `directive-reserved` | — | — | yes | `%FOO` reserved directives, 1.2 only |
| `caret-escape` | yes | — | — | `\^` escape, removed in 1.1 |
| `tag-prefix-caret` | yes (in `spec_extra/`) | — | — | `!domain/^type` + `!^name`, removed in 1.1; not lintable by yamllint |
| `tag-application` | yes | — | — | `!!custom` as application tag (1.0 convention) |
| `tag-local` | — | yes | yes | `!custom` as local tag (1.1+ convention) |
| `tag-verbatim` | — | yes | yes | `!<tag:...>` verbatim tags, added in 1.1 |
| `tag-named-handle` | — | yes | yes | `!foo!custom` with `%TAG`, added in 1.1 |
| `tag-set` | — | yes | yes | `!!set` type |
| `tag-omap` | — | yes | yes | `!!omap` type |
| `tag-pairs` | — | yes | — | `!!pairs` type, removed in 1.2 |
| `tag-timestamp` | — | yes | — | `!!timestamp` explicit tag, removed in 1.2 |
| `tag-non-specific` | — | — | yes | `! value` non-specific tag, 1.2 only |
| `merge-key` | — | yes | — | `<<` merge key, removed in 1.2 |
| `value-key` | — | yes | — | `=` value key, removed in 1.2 |
| `sexagesimal` | yes | yes | — | `3:25:45` base-60 numbers, removed in 1.2 |

### Key content differences in same-named files

| File | 1.0 | 1.1 | 1.2.x |
|---|---|---|---|
| `boolean` | y, n, yes, no, true, false, on, off | same as 1.0 | true, false only |
| `integer` | octal `014` | octal `014` | octal `0o14` |
| `double-quoted-escapes` | no `\/` | no `\/` | includes `\/` |
| `tag-builtin` | `!str`, `!int`, `!float` | `!!str`, `!!int`, `!!float` | `!!str`, `!!int`, `!!float` |
| `tag-binary` | `!binary` | `!!binary` | `!!binary` |

## Rules for Modifying Fixtures

1. When adding a new syntactic feature, add it to both the covering fixture and as a separate minimal example.
2. Keep minimal examples free of comments — use descriptive file names instead.
3. Exception: `comment-*.yaml` files specifically test comment placement.
4. The `1.2.1/` and `1.2.2/` directories must stay identical to `1.2.0/`
   (the three 1.2 revisions have no syntactic differences).
5. Never place features from a newer spec version into an older version's fixtures.
