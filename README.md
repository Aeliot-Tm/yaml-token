# YAML Token

[![Testing](https://github.com/Aeliot-Tm/yaml-token/actions/workflows/automated-testing.yaml/badge.svg?branch=main)](https://github.com/Aeliot-Tm/yaml-token/actions/workflows/automated-testing.yaml?query=branch%3Amain)
[![Security Audit](https://github.com/Aeliot-Tm/yaml-token/actions/workflows/security-audit.yaml/badge.svg?branch=main)](https://github.com/Aeliot-Tm/yaml-token/actions/workflows/security-audit.yaml?query=branch%3Amain)
[![GitHub License](https://img.shields.io/github/license/Aeliot-Tm/yaml-token?label=License&labelColor=black)](LICENSE)

A YAML parser that represents YAML as a hierarchical structure of nodes and tokens.

## Purpose

The library enables working with YAML not only as data but as a full structure of the source text
represented by nodes and tokens. It provides base layer for the analysis and modification of YAML
with isolated impact and without side effects.

Unlike [`symfony/yaml`](https://github.com/symfony/YAML), which is designed for `YAML → array`
and `array → YAML` conversion, this library provides a mechanism for analyzing and precisely
manipulating the source YAML.

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

### Mapping project terms to the YAML specification

- [Mapping of project token types to the YAML specification](docs/TokenTypeNamingMapping.md)

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
