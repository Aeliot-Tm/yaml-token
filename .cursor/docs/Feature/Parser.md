# Parser

## Goal

The parser converts a `TokenStreamInterface` produced by the lexer into a tree of `Node` objects:
stream, documents, block/flow collections, scalars, anchors, aliases, directives, and layout tokens.

See [Parser Nodes](ParserNodes.md) for the complete node hierarchy reference.

## Entry Points

`ParserBuilder::createParser()` is the production factory. It creates shared helpers once,
wires them through `ParserAssembler`, and returns `new Parser(new ParserRegistry($assembler))`.

```php
$parser = (new ParserBuilder())->createParser();
$stream = $parser->parse($yamlString);         // tokenizes internally
$stream = $parser->parseStream($tokenStream);  // uses a pre-tokenized stream
```

## Internal Architecture

Parsing is split into:

- **Sub-parsers** — one class per YAML construct under `src/Parser/SubParser/`
- **Helpers** — token consumption, indentation, look-ahead, node creation, structure identification
- **Registry** — `ParserRegistry` lazy-initializes sub-parsers; resolves circular references
- **Assembler** — `ParserAssembler` owns shared helpers and provides `create*()` factories

Sub-parsers hold a `ParserRegistry` reference; they never hold direct references to peers.
This avoids circular constructor dependencies (e.g. `ValueParser ↔ BlockMappingParser`).

## Runtime Context

Each `parseStream()` call creates a `ParseContext` that is passed to every sub-parser:

| Field | Type | Role |
|-------|------|------|
| `tokens` | `TokenStreamInterface` | Cursor over the lexer token stream |
| `anchorsRegistry` | `AnchorsRegistry` | Named anchors registered during parsing |
| `state` | `ParseState` | Global indent-step tracking |

`IndentContext` is passed per-call to `ValueParser::parseValue()` to carry indentation scope:

| Factory | Meaning |
|---------|---------|
| `IndentContext::createForBlock(int $indent)` | Real block indent (≥ 0) |
| `IndentContext::createForBareDocument()` | Bare document root (YAML 1.2.2 rule [211]) |
| `IndentContext::createForFlow()` | Value inside a flow collection |

## Parse Flow

```
Parser::parse(string $input)
  → Lexer::tokenize($input)
  → Parser::parseStream(TokenStream)
       → new ParseContext(tokens, AnchorsRegistry, ParseState)
       → StreamParser::parseStream(ctx)
            → optional ByteOrderNode
            → DocumentParser::parseDocuments(ctx, stream)
                 → directives (%YAML, %TAG)
                 → document markers (---, ...)
                 → root content: scalars, aliases, mappings, sequences, flow
            → StreamNode
```

Inside each document, all content paths converge on `ValueParser::parseValue()`:

1. `NodePropertiesParser` collects `&anchor` / `!tag`.
2. Anchor is registered in `AnchorsRegistry`.
3. Whitespace/comments are consumed onto the `ValueNode`.
4. Dispatch by the next token type:

| Token | Sub-parser |
|-------|-----------|
| `FOLDED_BLOCK_SCALAR_INDICATOR` / `LITERAL_BLOCK_SCALAR_INDICATOR` | `BlockScalarValueConsumer` |
| `NEWLINE` in flow context | collect whitespace/comments, recurse |
| `NEWLINE` in block context | `IndentedBlockValueParser` |
| scalar tokens | `SimpleScalarParser` or `MultilinePlainScalarParser` |
| `ALIAS` | `AliasResolver` |
| `SEQUENCE_ENTRY` | `CompactBlockSequenceParser` |
| `FLOW_SEQUENCE_START` | `FlowSequenceParser` |
| `FLOW_MAPPING_START` | `FlowMappingParser` |

## Sub-parsers

### Structural

| Class | Responsibility |
|-------|----------------|
| `StreamParser` | BOM handling; drives document iteration |
| `DocumentParser` | One document: directives, markers (`---`, `...`), root content dispatch |
| `ValueParser` | Universal value entry: properties, newline/scalar/alias/collection dispatch |
| `NodePropertiesParser` | `&anchor` and `!tag` before a key or value |
| `MergeInstructionParser` | `<< : *alias` merge key |
| `TagDirectiveParser` | `%TAG` directive |
| `YamlDirectiveParser` | `%YAML` directive |

### Block

| Class | Responsibility |
|-------|----------------|
| `BlockMappingParser` | Key-value couples at one indent level |
| `BlockSequenceParser` | `- entry` items at one indent level |
| `CompactBlockMappingParser` | Compact mapping nested after `- ` |
| `CompactBlockSequenceParser` | Compact nested sequence after `- ` |
| `KeyParser` | One key: dispatches to explicit or implicit key parser |
| `ExplicitKeyParser` | Explicit key with `?` indicator |
| `ImplicitKeyParser` | Implicit key (scalar, alias, or flow collection as key) |
| `KeyValueCoupleParser` | One `key: value` pair |
| `SequenceEntryParser` | One `- value` sequence entry |
| `IndentedBlockValueParser` | Value after `:` when content follows on a new line |

### Flow

| Class | Responsibility |
|-------|----------------|
| `FlowMappingParser` | `{ … }` mapping |
| `FlowSequenceParser` | `[ … ]` sequence |
| `FlowCollectionParser` | Shared flow collection loop (brackets, entries, separators) |
| `FlowEntryParser` | One sequence element (value or flow pair) |
| `FlowMappingPairParser` | One `key: value` pair inside `{ … }` |
| `FlowPairValueConsumer` | Value side of a flow pair |
| `FlowValueIndicatorConsumer` | `:` inside flow context |
| `FlowMultilinePlainScalarConsumer` | Plain scalar continuation lines in flow context |
| `FlowMultilinePlainScalarKeyParser` | Flow multiline plain scalar as a mapping key |

### Scalar

| Class | Responsibility |
|-------|----------------|
| `SimpleScalarParser` | Single-token scalar (plain, single-quoted, double-quoted) |
| `MultilinePlainScalarParser` | Plain scalar spanning multiple lines in block context |
| `BlockScalarFirstFragmentConsumer` | Block scalar header line + first scalar fragment |
| `BlockScalarKeyNameConsumer` | Block scalar as a mapping key name |
| `BlockScalarValueConsumer` | Block scalar as a value (after `\|` or `>`) |

## Helpers

| Class | Purpose |
|-------|---------|
| `Consumer` | Collect layout tokens (whitespace, comments, newlines) into a parent node |
| `NodeFactory` | Create typed nodes from tokens |
| `ErrorHelper` | Append `line:column` to error messages |
| `LookAheadHelper` | Peek at the first significant block head; collect insignificant lines |
| `MultilineContinuationHelper` | Detect plain scalar continuation lines |
| `AnchorPostProcessor` | Walk the key subtree and register anchors on `KeyValueCoupleNode` |
| `AliasResolver` | Resolve `*alias` tokens to their `AnchorNode` |
| `BlockCollectionLoopHelper` | Advance past blank/comment lines to the next block entry |
| `PeekOffsetHelper` | Skip whitespace tokens in peek operations |

### Structure Identifiers

| Class | Purpose |
|-------|---------|
| `BlockStructureIdentifier` | Detect block mapping/sequence starts and key-value couple starts |
| `FlowStructureIdentifier` | Detect flow collection starts; flow-collection-as-implicit-key |
| `NodePropertyIdentifier` | Detect anchor/tag token positions |
| `KeyIdentifier` | Detect scalar followed by `:` (implicit key) |
| `SequenceIdentifier` | Detect `- ` sequence entry |

## Key Behaviors

### Round-trip Preservation

All layout tokens (whitespace, newlines, comments, indentation) are kept in the node tree.
Emitting a parsed stream reproduces the original input byte-for-byte.
The parser never synthesizes tokens that did not appear in the input.

### Empty Values

An empty YAML value is represented as a `ValueNode` with no payload.
`ValueNode::isEmpty()` returns `true`. The node itself is never `null` when `:` was present.

### Anchors and Aliases

- Anchors on values are registered in `AnchorsRegistry` immediately when `ValueNode` is built.
- After each `KeyValueCoupleNode` is assembled, `AnchorPostProcessor` recursively walks the key
  subtree and registers all anchors found there (stopping at nested couples).
- Each `AnchorNode` stores a reference to its declaring `KeyValueCoupleNode` via `getDeclarationCouple()`.
- `AliasNode` holds a direct reference to the resolved `AnchorNode` via `getAnchor()`.

### Block Scalars

A block scalar (`|` / `>`) is assembled as `BlockScalarEntryNode`:
- `BlockScalarOptionsNode` child: type indicator (`BlockScalarIndicatorNode`), optional
  chomping indicator (`+`/`-`), optional indentation indicator (digit).
- Layout tokens: newlines and optional indentation after the header.
- Payload: `LiteralBlockScalarNode` or `FoldedBlockScalarNode`.

When the stream ends before the newline that follows the header, the entry is returned
with only the options child and no scalar payload.

### Multiline Plain Scalars

Multiple consecutive `PLAIN_SCALAR` tokens spanning lines are grouped into a `MultilinePlainScalarNode`.
In block context the continuation line must be more indented than the parent indent.
At bare document root a continuation may start at column 1 if the line is not an implicit key.

### Merge Keys

`<< : *alias` is represented as a `MergeInstructionNode` child of `BlockMappingNode`
or `FlowMappingNode`. `MergeInstructionNode` contains `AliasNode` instances.

## Exceptions

All parser exceptions are in `src/Parser/Exception/` and implement `ParserExceptionInterface`:

| Class | Condition |
|-------|-----------|
| `AnchorUndefinedException` | Alias references an undeclared anchor |
| `IndentationInvalidException` | Indentation value is invalid (e.g. non-positive) |
| `IndentationOverrideException` | Indent step already registered |
| `IndentationUndefinedException` | Indent step not yet defined |
| `UnexpectedEndException` | Token stream ended prematurely |
| `UnexpectedNodeException` | Unexpected node type encountered |
| `UnexpectedStateException` | Internal parser state error |
| `UnexpectedTokenException` | Unexpected token type |
