# Parser Refactoring: Sub-Parser & Helper Catalog

Parent: [Parser Refactoring](ParserRefactoring.md)

## Sub-Parsers

### Structural

| Class | Replaces | Responsibility |
|-------|----------|----------------|
| `StreamParser` | `Parser::parseStream` | BOM + document iteration |
| `DocumentParser` | `Parser::parseDocuments` (per-document body) | Directives + root content of one document |
| `ValueParser` | `Parser::parseValue` + `parseValuePrimaryPayload` | Universal entry: identify type → delegate |
| `DirectiveParser` | `Parser::parseYamlDirective`, `parseTagDirective` | `%YAML` / `%TAG` |
| `MergeInstructionParser` | `Parser::parseMergeInstructionAtCurrentPosition`, `collectMergeAliases` | `<<: *alias`; `collectMergeAliases` as private tree-walking method |
| `NodePropertiesParser` | `Parser::collectKeyProperties`, `collectValueProperties` | Anchor + tag before a value |

### Block

| Class | Replaces | Responsibility |
|-------|----------|----------------|
| `BlockMappingParser` | `Parser::parseBlockMappingValue` | Iterate key-value couples at one indent level |
| `BlockSequenceParser` | `Parser::parseBlockSequenceValue` | Iterate `- entry` items at one indent level |
| `CompactBlockMappingParser` | `Parser::parseCompactBlockMapping` | Compact mapping after `- ` |
| `CompactBlockSequenceParser` | `Parser::parseCompactBlockSequence` | Compact sequence |
| `KeyParser` | `Parser::getKeyNode` | One key: explicit `?` / implicit / flow multiline plain / block scalar key |
| `KeyValueCoupleParser` | `Parser::parseKeyValueCoupleAtCurrentPosition` | One `key: value` pair; delegates key parsing to `KeyParser` |
| `SequenceEntryParser` | `Parser::parseSequenceEntryValue` | One `- value` entry |
| `IndentedBlockValueParser` | `Parser::parseIndentedBlockValue` | Value after `:` with newline + indent |

### Flow

| Class | Replaces | Responsibility |
|-------|----------|----------------|
| `FlowSequenceParser` | `FlowSequenceBuilder` + `runFlowSequenceDriver` | `[…]` iteration |
| `FlowMappingParser` | `FlowMappingBuilder` + `runFlowMappingDriver` | `{…}` iteration |
| `FlowEntryParser` | `FlowEntryBuilder` | One element of a flow collection |
| `FlowMappingPairParser` | `FlowMappingPairBuilder` | One `key: value` in `{…}` |

### Scalar

| Class | Replaces | Responsibility |
|-------|----------|----------------|
| `PlainScalarParser` | part of `parseValuePrimaryPayload` | Plain scalar token |
| `QuotedScalarParser` | part of `parseValuePrimaryPayload` | `'…'` / `"…"` |
| `MultilinePlainScalarParser` | `appendMultilinePlainScalarContinuations` + predicates | Multiline plain (YAML §7.3.3) |
| `BlockScalarParser` | `consumeBlockScalar*`, `consumeIndentedBlockScalarValue` | `\|` / `>` block scalars |

## Helpers

### Structure Identification

`OngoingStructureIdentifier` is a **facade** with high-level methods
(`identifyBlockValue`, `identifyFlowValue`, `identifyDocumentRootContent`)
that delegates to four specialized identifiers:

| Class | Current methods from `Parser.php` | Purpose |
|-------|-----------------------------------|---------|
| `OngoingStructureIdentifier` | — | Facade: routes `identify*()` calls to specialized identifiers below |
| `BlockStructureIdentifier` | `isSequenceStart`, `isKeyValueCoupleStart`, `isKeyValueCoupleStartAllowingNodeProperties`, `isBlockScalarStartAtDocumentRoot` | Block-context construct identification |
| `FlowStructureIdentifier` | `isFlowMappingStart`, `isFlowSequenceStart`, `isFlowMultilinePlainKeyStart`, `isFlowCollectionFollowedByBlockValueIndicatorOnSameLine` | Flow-context construct identification |
| `NodePropertyIdentifier` | `isNodePropertyToken`, `isNodePropertiesOnlyLine`, `isNodePropertyAtDocumentRoot`, `isNodePropertiesFollowedByImplicitYamlKeyOnSameLine`, `isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine`, `isNodePropertiesFollowedByImplicitKeyFromOffset` | Node property (anchor/tag) analysis |
| `KeyIdentifier` | `isScalarFollowedByValueIndicator`, `isImplicitYamlKeyOnContinuationLine` | Implicit/explicit key recognition |

### Other Helpers

| Class | Current methods | Purpose |
|-------|-----------------|---------|
| `NodeFactory` | `createSimpleNode`, `createScalarNode` | Token → Node mapping (replaces `FlowHost::createSimpleNode`) |
| `Consumer` | Already exists; evolves | Token collection by types; depends on `NodeFactory` instead of `FlowHost` |
| `LookAheadHelper` | `peekFirstSignificantBlockHead`, `isInsignificantIndentationLine` | General-purpose peek utilities |
| `IndentationHelper` | `assertIndentLenIsValid`, `registerIndentStepIfNeeded` | Indent validation / registration |
| `MultilineContinuationHelper` | `isIndentedMultilinePlainContinuationAt`, `isBareDocumentFlushMultilinePlainContinuationAt` | Multiline plain scalar continuation predicates |
| `ErrorHelper` | `appendTokenLocation`, `wrapParseStateIndentationException` | Error message formatting |
| `AnchorPostProcessor` | `postProcessKeyValueCouple`, `collecAnchorsRecursive` | Anchor registration + couple wiring after key-value pair is built; injected into `KeyValueCoupleParser` and `FlowMappingPairParser` |
