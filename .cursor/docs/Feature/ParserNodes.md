# Parser Nodes

The parser builds a tree of `Node` objects. Every node implements the `Node` interface
(`addChild`, `getChildren`, `getParent`) and extends `AbstractNode` unless noted.

`AbstractNode` provides a mutable children list with `addChild()`, `removeChild()`,
`getChildren()`, and `setParent()`.

See [Parser](Parser.md) for the overall parse flow and sub-parser catalog.

## Base Classes

| Class | Role |
|-------|------|
| `AbstractNode` | Mutable children list; parent link. |
| `SyntaxNode` *(abstract)* | Wraps a single structural `Token`. Implements `TokenHolderInterface` (`getToken()`). |
| `ScalarNode` *(abstract)* | Wraps a single scalar `Token`. Implements `TokenHolderInterface` (`getToken()`). |
| `BlockScalarNode` *(abstract)* | Base for literal and folded block scalar nodes. Extends `ScalarNode`. |
| `FlowNode` *(abstract)* | Base for flow collection nodes. Extends `AbstractNode`. |

## Interfaces

| Interface | Purpose |
|-----------|---------|
| `TokenHolderInterface` | `getToken(): Token` — node wraps exactly one token. |
| `NodePropertiesHolderInterface` | `getProperties(): ?NodePropertiesNode`, `getAnchor(): ?AnchorNode`, `getTag(): ?TagNode`. Implemented by `KeyNode` and `ValueNode`. |
| `NodePropertyInterface` | Marker for nodes that are node properties (`AnchorNode`, `TagNode`). |

## Scalar Nodes

All extend `ScalarNode` (constructor accepts `Token`; no additional methods).

| Class | Token type |
|-------|------------|
| `PlainScalarNode` | `PLAIN_SCALAR` |
| `SingleQuotedScalarNode` | `SINGLE_QUOTED_SCALAR` |
| `DoubleQuotedScalarNode` | `DOUBLE_QUOTED_SCALAR` |
| `LiteralBlockScalarNode` | `LITERAL_BLOCK_SCALAR` |
| `FoldedBlockScalarNode` | `FOLDED_BLOCK_SCALAR` |

## Syntax (Leaf) Nodes

All extend `SyntaxNode` (constructor accepts `Token`; no additional methods unless noted).

| Class | Token type / purpose |
|-------|----------------------|
| `IndentationNode` | `INDENTATION` |
| `NewLineNode` | `NEWLINE` |
| `WhitespaceNode` | `WHITESPACE` |
| `CommentNode` | `COMMENT` |
| `ByteOrderNode` | `BYTE_ORDER_MARK` (BOM). Extends `AbstractNode`, implements `TokenHolderInterface`. |
| `DocumentStartNode` | `DOCUMENT_START` (`---`) |
| `DocumentEndNode` | `DOCUMENT_END` (`...`) |
| `ValueIndicatorNode` | `VALUE_INDICATOR` (`:`) |
| `ExplicitKeyIndicatorNode` | `EXPLICIT_KEY_INDICATOR` (`?`) |
| `SequenceEntryNode` | `SEQUENCE_ENTRY` (`-`) |
| `FlowEntryNode` | `FLOW_ENTRY` (`,`) |
| `FlowSequenceStartNode` | `FLOW_SEQUENCE_START` (`[`). Extends `FlowSequenceBoundNode`. |
| `FlowSequenceEndNode` | `FLOW_SEQUENCE_END` (`]`). Extends `FlowSequenceBoundNode`. |
| `FlowMappingStartNode` | `FLOW_MAPPING_START` (`{`). Extends `FlowMappingBoundNode`. |
| `FlowMappingEndNode` | `FLOW_MAPPING_END` (`}`). Extends `FlowMappingBoundNode`. |
| `BlockScalarIndicatorNode` | `FOLDED_BLOCK_SCALAR_INDICATOR` or `LITERAL_BLOCK_SCALAR_INDICATOR` (`>` / `\|`) |
| `BlockScalarChompingIndicatorNode` | `BLOCK_SCALAR_CHOMPING_INDICATOR` (`+` / `-`) |
| `BlockScalarIndentationIndicatorNode` | `BLOCK_SCALAR_INDENTATION_INDICATOR` (digit) |
| `MergeIndicatorNode` | `MERGE_INDICATOR` (`<<`) |
| `YamlDirectiveNode` | `YAML_DIRECTIVE` (`%YAML`) |
| `YamlVersionNode` | `YAML_VERSION` (version string) |
| `TagDirectiveNode` | `TAG_DIRECTIVE` (`%TAG`) |
| `TagHandleNode` | `TAG_HANDLE`. `getHandle(): string` returns the handle text. |
| `TagDirectivePrefixNode` | `DIRECTIVE_TAG_PREFIX`. `getPrefix(): string` returns the prefix text. |
| `DirectiveNode` | Generic unrecognized directive line (`DIRECTIVE` token). |

## Property Nodes

| Class | Key methods |
|-------|-------------|
| `AnchorNode` | `getName(): string` (strips leading `&`), `getToken()`, `getDeclarationCouple(): ?KeyValueCoupleNode`, `setDeclarationCouple(KeyValueCoupleNode)`. Implements `NodePropertyInterface`, `TokenHolderInterface`. |
| `AliasNode` | `getName(): string` (strips leading `*`), `getToken()`, `getAnchor(): ?AnchorNode`, `setAnchor(AnchorNode)`. Implements `TokenHolderInterface`. |
| `TagNode` | `getToken()`. Implements `NodePropertyInterface`, `TokenHolderInterface`. |

## Composite Nodes

### StreamNode

Root of the parse tree (YAML rule l-yaml-stream). Children: optional `ByteOrderNode`, then `DocumentNode` instances.

### DocumentNode

One YAML document (l-any-document). Children are added in parse order: directives, document markers, root content, layout.

### BlockMappingNode

Block mapping (indented key-value couples).

| Method | Returns |
|--------|---------|
| `getEntries()` | `list<KeyValueCoupleNode>` — filters `MergeInstructionNode` and layout children. |

Children may also include `MergeInstructionNode` instances for `<<` merge keys.

### BlockSequenceNode

Block sequence (indented `- entry` items).

| Method | Returns |
|--------|---------|
| `getEntries()` | `list<BlockSequenceEntryNode>` |

### BlockSequenceEntryNode

One block sequence entry. Children: optional `IndentationNode`, `SequenceEntryNode`, `ValueNode`, layout.

| Method | Returns |
|--------|---------|
| `getValue()` | `?ValueNode` |

### FlowMappingNode

Flow mapping `{ … }`. Extends `FlowNode`.

| Method | Returns |
|--------|---------|
| `getEntries()` | `list<KeyValueCoupleNode>` — filters layout and `MergeInstructionNode`. |

### FlowSequenceNode

Flow sequence `[ … ]`. Extends `FlowNode`.

| Method | Returns |
|--------|---------|
| `getEntries()` | `list<ValueNode>` |

### KeyValueCoupleNode

One key-value pair in block or flow context.

| Method | Returns |
|--------|---------|
| `getIndentation()` | `?IndentationNode` — leading indentation (set via `setIndentation()`). |
| `getKey()` | `?KeyNode` |
| `getValueIndicator()` | `?ValueIndicatorNode` — the `:` token node. |
| `getValue()` | `?ValueNode` |
| `getMergeInstruction()` | `?MergeInstructionNode` — present for `<<` entries. |

`addChild()` enforces single assignment of each typed field; calling `setIndentation()` is the only
way to attach an `IndentationNode` (leading indentation belongs to the couple, not its children).

### KeyNode

The key side of a key-value pair. Implements `NodePropertiesHolderInterface`.

| Method | Returns |
|--------|---------|
| `getExplicitKeyIndicatorNode()` | `?ExplicitKeyIndicatorNode` — present for `?` keys. |
| `getName()` | `?Node` — key content: `ScalarNode`, `MultilinePlainScalarNode`, `FlowMappingNode`, `FlowSequenceNode`, or `BlockScalarEntryNode`. |
| `setName(Node)` | Assigns the key name; throws on second call. |
| `getProperties()` | `?NodePropertiesNode` |
| `getAnchor()` | `?AnchorNode` (shortcut via `getProperties()`). |
| `getTag()` | `?TagNode` (shortcut via `getProperties()`). |
| `isEmpty()` | `bool` — `true` when no name was set. |

### ValueNode

The value side of a key-value pair, or a standalone document value. Implements `NodePropertiesHolderInterface`.

| Method | Returns |
|--------|---------|
| `getPayload()` | `?Node` — the actual content (see payload types below). |
| `getProperties()` | `?NodePropertiesNode` |
| `getAnchor()` | `?AnchorNode` (shortcut via `getProperties()`). |
| `getTag()` | `?TagNode` (shortcut via `getProperties()`). |
| `isEmpty()` | `bool` — `true` when payload is `null`. |
| `isAlias()` | `bool` |
| `isBlockMapping()` | `bool` |
| `isBlockScalarEntry()` | `bool` |
| `isBlockSequence()` | `bool` |
| `isFlowMapping()` | `bool` |
| `isFlowSequence()` | `bool` |
| `isKeyValueCouple()` | `bool` |
| `isMultilinePlainScalar()` | `bool` |
| `isScalar()` | `bool` |

Possible payload types for `getPayload()`:

| Payload type | Condition |
|--------------|-----------|
| `AliasNode` | `*alias` |
| `ScalarNode` subclass | Single-token scalar |
| `MultilinePlainScalarNode` | Plain scalar across lines |
| `BlockMappingNode` | Nested block mapping |
| `BlockSequenceNode` | Nested block sequence |
| `BlockScalarEntryNode` | `\|` or `>` block scalar |
| `FlowMappingNode` | `{ … }` |
| `FlowSequenceNode` | `[ … ]` |
| `KeyValueCoupleNode` | Flow pair inside a sequence |
| `null` | Empty value |

### NodePropertiesNode

Groups `&anchor` and `!tag` before a key or value.

| Method | Returns |
|--------|---------|
| `getAnchor()` | `?AnchorNode` |
| `getTag()` | `?TagNode` |
| `getProperty(string $class)` | `?NodePropertyInterface` — accepts `AnchorNode::class` or `TagNode::class`. |

`addChild()` enforces at most one anchor and one tag.

### BlockScalarEntryNode

Wrapper for a block scalar (`|` / `>`).

| Method | Returns |
|--------|---------|
| `getOptions()` | `?BlockScalarOptionsNode` — header line. |
| `getPayload()` | `?BlockScalarNode` — `LiteralBlockScalarNode` or `FoldedBlockScalarNode`. |

Children in parse order: `BlockScalarOptionsNode`, `NewLineNode`(s), optional `IndentationNode`, scalar node.
Payload is `null` when the stream was truncated before the header newline.

### BlockScalarOptionsNode

The block scalar header indicators.

| Method | Returns |
|--------|---------|
| `getTypeIndicator()` | `?BlockScalarIndicatorNode` — `>` or `\|`. |
| `getChompingIndicator()` | `?BlockScalarChompingIndicatorNode` — `+` or `-`. |
| `getIndentationIndicator()` | `?BlockScalarIndentationIndicatorNode` — explicit digit. |
| `isFolded()` | `bool` |
| `isLiteral()` | `bool` |

### MultilinePlainScalarNode

Groups multiple `PLAIN_SCALAR` token fragments from consecutive lines.
Children: alternating `PlainScalarNode` and layout nodes (`NewLineNode`, `IndentationNode`, `WhitespaceNode`).

### MergeInstructionNode

Represents a `<< : *alias` merge key entry.

| Method | Returns |
|--------|---------|
| `addAlias(AliasNode)` | Appends an alias. |
| `getAliases()` | `list<AliasNode>` |

### YamlVersionDefinitionNode

`%YAML version` directive.

| Method | Returns |
|--------|---------|
| `getIndicatorNode()` | `?YamlDirectiveNode` |
| `getVersionNode()` | `?YamlVersionNode` |

### TagDefinitionNode

`%TAG handle prefix` directive.

| Method | Returns |
|--------|---------|
| `getIndicatorNode()` | `?TagDirectiveNode` |
| `getHandleNode()` | `?TagHandleNode` |
| `getPrefixNode()` | `?TagDirectivePrefixNode` |
| `getHandle()` | `?string` — shortcut via `getHandleNode()`. |
| `getPrefix()` | `string` — shortcut via `getPrefixNode()`. |
