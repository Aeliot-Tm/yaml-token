# Parser Architecture

## Overview

The parser turns a lexer [`TokenStream`](../../../src/Token/TokenStream.php) into a tree of
[`Node`](../../../src/Node/Node.php) objects. Work is split across:

- a thin [`Parser`](../../../src/Parser/Parser.php) façade;
- one **sub-parser class per YAML construct** under `src/Parser/SubParser/`;
- shared **helpers** (token consumption, indentation, look-ahead, node creation);
- a **registry** that wires sub-parsers together and resolves circular dependencies.

Sub-parsers delegate to each other through ordinary PHP calls and
[`ParserRegistry`](../../../src/Parser/ParserRegistry.php) lookups. YAML parsing
semantics (round-trip, collections, anchors, etc.) are documented in
[Parser](../Feature/Parser.md).

## Parse flow

Each `parse()` / `parseStream()` invocation follows the same pipeline:

```text
ParserBuilder::createParser()
  → Parser(ParserRegistry)
       → ParserAssembler (shared helpers, created once)

Parser::parse(input)
  → Lexer::tokenize(input)
  → Parser::parseStream(TokenStream)
       → new ParseContext(TokenStreamInterface, AnchorsRegistry, ParseState)
       → StreamParser::parseStream(ctx)
            → optional ByteOrderNode
            → DocumentParser::parseDocuments(ctx, stream)
                 → directives (%YAML, %TAG)
                 → bare-document root content (mappings, sequences, scalars)
            → StreamNode
```

Inside a document, most content paths eventually reach
[`ValueParser::parseValue()`](../../../src/Parser/SubParser/ValueParser.php), which
collects node properties, inspects the next token, and dispatches to the matching
sub-parser (block collection, flow collection, scalar, alias, etc.).

### Example: flow sequence value

```text
ValueParser::parseValue(ctx, parentIndentLen)
  ├── NodePropertiesParser::collectValueProperties(ctx, valueNode)
  ├── token is FLOW_SEQUENCE_START
  └── FlowSequenceParser::parse(ctx)
        ├── consume `[`
        ├── loop until `]`:
        │     FlowEntryParser::parse(ctx)
        │       └── ValueParser::parseValue(ctx, FLOW_COLLECTION_VALUE_PARENT)
        │             └── SimpleScalarParser::parse(ctx)  → ScalarNode in ValueNode
        │     optional `,` + layout tokens on FlowSequenceNode
        └── return FlowSequenceNode
```

### Example: block mapping after `:`

```text
ValueParser::parseValue(ctx, parentIndentLen)
  ├── NEWLINE at current token
  └── IndentedBlockValueParser::parseIndentedBlockValue(ctx, valueNode, parentIndentLen)
        ├── consume opening layout onto ValueNode
        ├── peek indent; dispatch by token / BlockStructureIdentifier
        └── BlockMappingParser::parseBlockMappingValue(ctx, indentLen)
              └── loop: KeyValueCoupleParser → KeyParser + ValueParser
```

## Wiring

[`ParserBuilder`](../../../src/Parser/ParserBuilder.php) is the production entry point.
It creates shared helpers once, passes them to
[`ParserAssembler`](../../../src/Parser/Assembler/ParserAssembler.php), and returns
`new Parser(new ParserRegistry($assembler))`.

[`ParserRegistry`](../../../src/Parser/ParserRegistry.php) lazy-creates sub-parsers:
each typed getter (`getValueParser()`, `getBlockMappingParser()`, …) calls the
matching `ParserAssembler::create*Parser($this)` on first use and caches the
instance. Sub-parsers hold `ParserRegistry`, not concrete peer references, so
cycles such as `ValueParser ↔ BlockMappingParser` resolve safely at parse time.

[`ParserAssembler`](../../../src/Parser/Assembler/ParserAssembler.php) owns helper
instances and structure identifiers (also lazy via assembler getters). One
`create*Parser(ParserRegistry)` factory exists per sub-parser.

## Runtime state: ParseContext

[`ParseContext`](../../../src/Parser/ParseContext.php) is created per `parseStream()`
call and passed into every sub-parser method. It holds all mutable parse-time state:

| Member | Type | Role |
|--------|------|------|
| `tokens` | `TokenStreamInterface` | Cursor over the lexer stream |
| `anchorsRegistry` | `AnchorsRegistry` | Named anchors for alias resolution |
| `state` | `ParseState` | Block-indent steps |

`ParseContext` does not reference `StreamNode` or any sub-parser.

Block vs flow vs bare-document-root discrimination in value parsing is carried by
the `$parentIndentLen` argument to `ValueParser::parseValue()` and by
[`EspecialIndent`](../../../src/Parser/Enum/EspecialIndent.php) sentinels (see below),
not by the context stack.

## Sub-parsers

All sub-parsers implement the marker
[`SubParserInterface`](../../../src/Parser/Contract/SubParserInterface.php). Each
class defines its own `parse()` (or similarly named) signature.

### Structural

| Class | Responsibility |
|-------|----------------|
| [`StreamParser`](../../../src/Parser/SubParser/StreamParser.php) | BOM handling; drives document iteration |
| [`DocumentParser`](../../../src/Parser/SubParser/DocumentParser.php) | One document: directives + root content |
| [`ValueParser`](../../../src/Parser/SubParser/ValueParser.php) | Universal value entry: properties, dispatch by next token |
| [`DirectiveParser`](../../../src/Parser/SubParser/DirectiveParser.php) | `%YAML` and `%TAG` directives |
| [`MergeInstructionParser`](../../../src/Parser/SubParser/MergeInstructionParser.php) | `<<: *alias` merge keys |
| [`NodePropertiesParser`](../../../src/Parser/SubParser/NodePropertiesParser.php) | `&anchor` / `!tag` before a key or value |

### Block

| Class | Responsibility |
|-------|----------------|
| [`BlockMappingParser`](../../../src/Parser/SubParser/Block/BlockMappingParser.php) | Key-value couples at one indent level |
| [`BlockSequenceParser`](../../../src/Parser/SubParser/Block/BlockSequenceParser.php) | `- entry` items at one indent level |
| [`CompactBlockMappingParser`](../../../src/Parser/SubParser/Block/CompactBlockMappingParser.php) | Compact mapping after `- ` |
| [`CompactBlockSequenceParser`](../../../src/Parser/SubParser/Block/CompactBlockSequenceParser.php) | Compact nested sequence |
| [`KeyParser`](../../../src/Parser/SubParser/Block/KeyParser.php) | One key: explicit `?`, implicit, multiline plain, block scalar |
| [`KeyValueCoupleParser`](../../../src/Parser/SubParser/Block/KeyValueCoupleParser.php) | One `key: value` pair |
| [`SequenceEntryParser`](../../../src/Parser/SubParser/Block/SequenceEntryParser.php) | One `- value` sequence entry |
| [`IndentedBlockValueParser`](../../../src/Parser/SubParser/Block/IndentedBlockValueParser.php) | Value after `:` with newline and indent |

### Flow

| Class | Responsibility |
|-------|----------------|
| [`FlowSequenceParser`](../../../src/Parser/SubParser/Flow/FlowSequenceParser.php) | `[ … ]` |
| [`FlowMappingParser`](../../../src/Parser/SubParser/Flow/FlowMappingParser.php) | `{ … }` |
| [`FlowEntryParser`](../../../src/Parser/SubParser/Flow/FlowEntryParser.php) | One flow-sequence element (node or pair) |
| [`FlowMappingPairParser`](../../../src/Parser/SubParser/Flow/FlowMappingPairParser.php) | One `key: value` inside `{ … }` |

### Scalar

| Class | Responsibility |
|-------|----------------|
| [`SimpleScalarParser`](../../../src/Parser/SubParser/Scalar/SimpleScalarParser.php) | Single plain, single-quoted, or double-quoted scalar token |
| [`MultilinePlainScalarParser`](../../../src/Parser/SubParser/Scalar/MultilinePlainScalarParser.php) | Multiline plain scalar continuation lines (appends chunks to an existing multiline node) |
| [`BlockScalarParser`](../../../src/Parser/SubParser/Scalar/BlockScalarParser.php) | Block scalars (`\|` / `>`) as mapping keys and values |

## Helpers

| Class | Purpose |
|-------|---------|
| [`NodeFactory`](../../../src/Parser/Helper/NodeFactory.php) | Map structural and scalar tokens to typed nodes |
| [`Consumer`](../../../src/Parser/Consumer.php) | Collect layout tokens, comments, and spaces by type |
| [`ErrorHelper`](../../../src/Parser/Helper/ErrorHelper.php) | Append line/column to error messages |
| [`IndentationHelper`](../../../src/Parser/Helper/IndentationHelper.php) | Validate and register indent steps |
| [`LookAheadHelper`](../../../src/Parser/Helper/LookAheadHelper.php) | Peek significant block heads; skip insignificant lines |
| [`BlockMultilinePlainScalarHelper`](../../../src/Parser/Helper/BlockMultilinePlainScalarHelper.php) | Build plain-scalar key names for block-context keys (explicit `?` and implicit) |
| [`FlowMultilinePlainScalarHelper`](../../../src/Parser/Helper/FlowMultilinePlainScalarHelper.php) | Build plain-scalar key and value names for flow-context keys |
| [`MultilineContinuationHelper`](../../../src/Parser/Helper/MultilineContinuationHelper.php) | Predicates for multiline plain scalar continuations |
| [`AnchorPostProcessor`](../../../src/Parser/Helper/AnchorPostProcessor.php) | Register anchors on key/value couples after they are built |

### Structure identifiers

Look-ahead predicates live under [`src/Parser/Helper/Identifier/`](../../../src/Parser/Helper/Identifier).
Sub-parsers receive the identifiers they need via constructor injection:

| Class | Purpose |
|-------|---------|
| [`BlockStructureIdentifier`](../../../src/Parser/Helper/Identifier/BlockStructureIdentifier.php) | Block mapping/sequence starts; implicit block keys |
| [`FlowStructureIdentifier`](../../../src/Parser/Helper/Identifier/FlowStructureIdentifier.php) | Flow collection starts; JSON-style flow keys |
| [`NodePropertyIdentifier`](../../../src/Parser/Helper/Identifier/NodePropertyIdentifier.php) | Anchor/tag-only lines and follow-on patterns |
| [`KeyIdentifier`](../../../src/Parser/Helper/Identifier/KeyIdentifier.php) | Scalar followed by `:`; implicit keys on continuation lines |

## Parent indent sentinels

`ValueParser::parseValue(ParseContext $ctx, int $parentIndentLen)` uses
`$parentIndentLen` both as a real block indent (≥ 0) and, via
[`EspecialIndent`](../../../src/Parser/Enum/EspecialIndent.php), as context markers:

| Sentinel | Value | Meaning |
|----------|-------|---------|
| `BARE_DOCUMENT_BLOCK_PARENT` | -1 | Bare document root (YAML 1.2.2 rule [211]) |
| `FLOW_COLLECTION_VALUE_PARENT` | -2 | Value inside a flow collection or merge RHS |

Flow continuation lines use `WHITESPACE`, not `INDENTATION`. The flow sentinel
routes newline-prefixed values through flow-aware paths instead of
`IndentedBlockValueParser` at indent 0.

## Token stream

Sub-parsers read and consume tokens only through `ParseContext::tokens`
([`TokenStreamInterface`](../../../src/Token/TokenStreamInterface.php)). Error positions are formatted
via [`ErrorHelper`](../../../src/Parser/Helper/ErrorHelper.php); see
[Showing of problematic position](../Feature/ShowingProblematicPosition.md).

## Source layout

```text
src/Parser/
├── Parser.php
├── ParserBuilder.php
├── ParseContext.php
├── ParserRegistry.php
├── Assembler/ParserAssembler.php
├── Contract/SubParserInterface.php
├── Consumer.php
├── Dto/               AnchorsRegistry, ParseState
├── Enum/              EspecialIndent, ParsingContext
├── Exception/
├── Helper/            NodeFactory, Consumer helpers, Identifier/*
└── SubParser/         Stream, Document, Value, Block/*, Flow/*, Scalar/*
```

## Extending the parser

1. Add a class implementing `SubParserInterface` under the appropriate `SubParser/` subdirectory.
2. Add `create*Parser()` to `ParserAssembler` and a typed getter to `ParserRegistry`.
3. Delegate from an existing sub-parser (usually `ValueParser` or a block/flow parser) via the registry.
4. Add or extend a fixture and regenerate expectations with
   `docker compose exec php-cli composer parser-expectations` after intentional behaviour changes.
