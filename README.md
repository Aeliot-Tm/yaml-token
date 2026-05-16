# YAML Token

A YAML parser that represents YAML as a hierarchical structure of tokens and containers.

## Purpose

The library enables working with YAML not only as data but as a full structure of the source text.
Every element (key, value, indentation, comment) has its position and can be modified or recreated.

> ## Project status:
> 
> The project is in its early stages of development.
> The structure and any interfaces are subject to change without notice.
> 
> **Not ready for production.** The public API, runtime behavior, and repository layout may change
> at any time. There are no stability or semantic versioning guarantees.
> 
> **Git history may be rewritten.** Maintainers may force-push or otherwise rewrite branches.
> Older commits may no longer exist on the remote. Do not pin this repository to a specific revision
> for long-term reproducibility. A previously fetched commit may become unavailable.

## YAML Specifications

- [YAML 1.0](https://yaml.org/spec/1.0/) (2004-01-29)
- [YAML 1.1](https://yaml.org/spec/1.1/) (2005-01-18)
- [YAML 1.1: merge](https://yaml.org/type/merge.html) (2005-01-18)
- [YAML 1.2.0](https://yaml.org/spec/1.2.0/) (2009-07-21)
- [YAML 1.2.1](https://yaml.org/spec/1.2.1/) (2009-10-01)
- [YAML 1.2.2](https://yaml.org/spec/1.2.2/) (2021-10-01)
- [Specification Changes](https://yaml.org/spec/1.2.2/ext/changes/)

## Acknowledgments

Thanks to [Masaaki Goshima](https://github.com/goccy) for [goccy/go-yaml](https://github.com/goccy/go-yaml)
test fixtures used under the MIT License and with the author's permission in `tests/fixture/go_yaml/`
and `tests/fixture/go_yaml_extra/`. 

## Third-party notices

This repository includes third-party materials that are not covered solely by the copyright in [LICENSE](LICENSE).
Their sources, scope, and license terms are listed in [THIRD_PARTY_NOTICES.md](THIRD_PARTY_NOTICES.md).

## Contributing

Early feedback and contributions are welcome. Open an issue to discuss larger changes
before investing significant time. Pull requests for fixes and tests are appreciated.
Expect APIs to keep moving until the project stabilizes.
