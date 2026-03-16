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
