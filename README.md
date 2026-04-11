# YAML Token

A YAML parser that represents YAML as a hierarchical structure of tokens and containers.

## Purpose

The library enables working with YAML not only as data but as a full structure of the source text.
Every element (key, value, indentation, comment) has its position and can be modified or recreated.

## Main ideas

**Structural representation.** YAML is turned into a tree of nodes: documents, objects, arrays, string values.
Each node has nested elements—tokens and other nodes.

**Preserving format.** The parser keeps formatting details. Comments, indentation, line breaks
and quotes are retained and can be restored when reassembling the file.

**Complex values.** Both keys and values of objects can have different structures:
plain text, quoted strings, multiline blocks, or nested collections.

## YAML Specifications

- [YAML 1.0](https://yaml.org/spec/1.0/) (2004-01-29)
- [YAML 1.1](https://yaml.org/spec/1.1/) (2005-01-18)
- [YAML 1.1: merge](https://yaml.org/type/merge.html) (2005-01-18)
- [YAML 1.2.0](https://yaml.org/spec/1.2.0/) (2009-07-21)
- [YAML 1.2.1](https://yaml.org/spec/1.2.1/) (2009-10-01)
- [YAML 1.2.2](https://yaml.org/spec/1.2.2/) (2021-10-01)
- [Specification Changes](https://yaml.org/spec/1.2.2/ext/changes/)
