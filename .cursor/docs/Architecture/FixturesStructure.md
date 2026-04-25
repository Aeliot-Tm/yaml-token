# Fixtures Structure

All test fixtures live under `tests/fixture/`. The root is split into a small,
fixed set of sub-folders, each with a clear purpose.

Most fixtures describe **valid** YAML inputs and are split along two
orthogonal axes:

- **Origin** — does the fixture come from the official YAML specification, or
  was it produced ad-hoc while debugging the parser?
- **Lintability** — does the fixture pass validation by the current `yamllint`
  version that the project uses in CI?

The combination yields four primary buckets (`spec`, `spec_extra`,
`edge_cases`, `edge_cases_extra`). One additional bucket (`invalid`) holds
deliberately malformed YAML used for negative-case testing.

## Layout

```
tests/fixture/
├── edge_cases/         # debugging-derived, yamllint-clean
├── edge_cases_extra/   # debugging-derived, yamllint rejects
├── invalid/            # deliberately malformed YAML, for negative tests
├── spec/               # spec-derived, yamllint-clean
└── spec_extra/         # spec-derived, yamllint rejects
```

## Buckets

### `tests/fixture/spec/`

Fixtures that cover the official YAML specification by example, built directly
from the official documentation of each supported version (1.0, 1.1, 1.2.0,
1.2.1, 1.2.2). These fixtures must pass `yamllint`.

The internal layout of this folder (covering files, per-version minimal
examples, naming, version-specific files, modification rules) is described
separately — see [Specification Cover Fixtures Structure](../Feature/SpecificationCoverFixtures.md).

### `tests/fixture/spec_extra/`

Spec-derived fixtures that **the current `yamllint` version cannot validate**
(it rejects them as malformed even though they are well-formed per the
official YAML specification). They are kept here, separated from `spec/`, so
that `yamllint`-based checks can stay green on `spec/` while these examples
remain available to the lexer/parser test suite.

The internal directory layout mirrors `spec/` (per-version sub-folders and
file naming), so the same conventions from
[Specification Cover Fixtures Structure](../Feature/SpecificationCoverFixtures.md)
apply.

### `tests/fixture/edge_cases/`

Additional fixtures that were **not** taken from the specification document
but were created on demand while debugging the parser — minimal reproductions
of corner cases discovered through real input. These fixtures must pass
`yamllint`. Sub-folders are organized by topic (e.g. `indentation/`).

### `tests/fixture/edge_cases_extra/`

The same kind of fixtures as `edge_cases/` (minimal reproductions found while
debugging the parser), but **rejected by the current `yamllint` version**.
They are still aligned with the official YAML specification and are therefore
kept in the suite — separated from `edge_cases/` for the same reason
`spec_extra/` is separated from `spec/`: to keep `yamllint`-based checks
green on the lintable buckets.

### `tests/fixture/invalid/`

Deliberately malformed YAML inputs used to drive **negative test cases** —
the lexer/parser is expected to reject them or to emit a specific error
shape. Unlike the four buckets above, these inputs are not valid per the
official YAML specification (e.g. tabs used as structural indentation).
They are documented next to the feature that consumes them
(see [Lexer](../Feature/Lexer.md) for the indentation samples).

## Decision rules

When adding a new fixture:

1. Decide whether the input is **valid** per the official YAML specification:
   - Not valid → `invalid/` (negative-case testing).
   - Valid → continue with the axes below.
2. Decide the **origin**:
   - Comes from the official YAML specification → `spec*`.
   - Came up while debugging the parser → `edge_cases*`.
3. Decide the **lintability** by running the project's `yamllint`:
   - Passes → base bucket (`spec/` or `edge_cases/`).
   - Fails → `*_extra` bucket (`spec_extra/` or `edge_cases_extra/`).
4. For `spec*` placements, also follow the per-version layout and naming
   defined in [Specification Cover Fixtures Structure](../Feature/SpecificationCoverFixtures.md).
