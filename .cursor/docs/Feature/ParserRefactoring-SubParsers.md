# Parser Refactoring: Sub-Parser & Helper Catalog

Parent: [Parser Refactoring](ParserRefactoring.md)

## Sub-Parsers

### Structural

| Class | Former location | Responsibility |
|-------|-----------------|----------------|
| `StreamParser` | `Parser::parseStream` body | BOM + document iteration |
| `DocumentParser` | `Parser::parseDocuments` | Directives + root content of one document |
| `ValueParser` | `Parser::parseValue`, `parseValuePrimaryPayload` | Universal value entry and dispatch |
| `DirectiveParser` | `Parser::parseYamlDirective`, `parseTagDirective` | `%YAML` / `%TAG` |
| `MergeInstructionParser` | `Parser::parseMergeInstructionAtCurrentPosition`, `collectMergeAliases` | `<<: *alias` |
| `NodePropertiesParser` | `Parser::collectKeyProperties`, `collectValueProperties` | Anchor + tag before a node |

### Block

| Class | Former location | Responsibility |
|-------|-----------------|----------------|
| `BlockMappingParser` | `Parser::parseBlockMappingValue` | Key-value couples at one indent level |
| `BlockSequenceParser` | `Parser::parseBlockSequenceValue` | `- entry` items at one indent level |
| `CompactBlockMappingParser` | `Parser::parseCompactBlockMapping` | Compact mapping after `- ` |
| `CompactBlockSequenceParser` | `Parser::parseCompactBlockSequence` | Compact sequence |
| `KeyParser` | `Parser::getKeyNode` | One key (explicit `?`, implicit, multiline plain, block scalar) |
| `KeyValueCoupleParser` | `Parser::parseKeyValueCoupleAtCurrentPosition` | One `key: value` pair |
| `SequenceEntryParser` | `Parser::parseSequenceEntryValue` | One `- value` entry |
| `IndentedBlockValueParser` | `Parser::parseIndentedBlockValue` | Value after `:` with newline + indent |

### Flow

| Class | Former location | Responsibility |
|-------|-----------------|----------------|
| `FlowSequenceParser` | `FlowSequenceBuilder`, `runFlowSequenceDriver` | `[…]` iteration |
| `FlowMappingParser` | `FlowMappingBuilder`, `runFlowMappingDriver` | `{…}` iteration |
| `FlowEntryParser` | `FlowEntryBuilder` | One flow-sequence element |
| `FlowMappingPairParser` | `FlowMappingPairBuilder` | One `key: value` in `{…}` |

### Scalar

| Class | Former location | Responsibility |
|-------|-----------------|----------------|
| `SimpleScalarParser` | plain/quoted branches of `parseValuePrimaryPayload` | Single plain, single-quoted, or double-quoted scalar token |
| `MultilinePlainScalarParser` | `appendMultilinePlainScalarContinuations` + flow/block key builders | Multiline plain (YAML §7.3.3) |
| `BlockScalarParser` | `consumeBlockScalar*`, block scalar key paths | `\|` / `>` block scalars as keys |

## Helpers

### Structure identification

Look-ahead predicates were extracted from `Parser.php` into four identifier classes
under `Helper/Identifier/`. Sub-parsers receive the identifiers they need directly
(there is no separate facade class):

| Class | Former `Parser.php` methods | Purpose |
|-------|------------------------------|---------|
| `BlockStructureIdentifier` | `isSequenceStart`, `isKeyValueCoupleStart`, `isKeyValueCoupleStartAllowingNodeProperties`, `isBlockScalarStartAtDocumentRoot` | Block-context construct identification |
| `FlowStructureIdentifier` | `isFlowMappingStart`, `isFlowSequenceStart`, `isFlowMultilinePlainKeyStart`, `isFlowCollectionFollowedByBlockValueIndicatorOnSameLine` | Flow-context construct identification |
| `NodePropertyIdentifier` | `isNodePropertyToken`, `isNodePropertiesOnlyLine`, `isNodePropertyAtDocumentRoot`, `isNodePropertiesFollowedBy*` | Anchor/tag line analysis |
| `KeyIdentifier` | `isScalarFollowedByValueIndicator`, `isImplicitYamlKeyOnContinuationLine` | Implicit/explicit key recognition |

### Other helpers

| Class | Former methods | Purpose |
|-------|----------------|---------|
| `NodeFactory` | `createSimpleNode`, `createScalarNode` | Token → node mapping |
| `Consumer` | (existing; evolved) | Token collection by types; uses `NodeFactory` |
| `LookAheadHelper` | `peekFirstSignificantBlockHead`, `isInsignificantIndentationLine`, `collectInsignificantIndentationLines` | General-purpose peek utilities |
| `IndentationHelper` | `assertIndentLenIsValid`, `registerIndentStepIfNeeded` | Indent validation / registration |
| `MultilineContinuationHelper` | `isIndentedMultilinePlainContinuationAt`, `isBareDocumentFlushMultilinePlainContinuationAt`, `isMultilinePlainContinuationAhead` | Multiline plain continuation predicates |
| `ErrorHelper` | `appendTokenLocation`, `wrapParseStateIndentationException` | Error message formatting |
| `AnchorPostProcessor` | `postProcessKeyValueCouple`, `collectAnchorsRecursive` | Anchor registration after key-value pairs |
