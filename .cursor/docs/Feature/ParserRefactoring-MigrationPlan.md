# Parser Refactoring: Migration Plan

Parent: [Parser Refactoring](ParserRefactoring.md)

## Overview

Incremental refactoring of the ~2970-line `Parser.php` God-class into a
sub-parser composition architecture. Each commit keeps tests green, existing
tests are never edited, new tests are minimal.

Several infrastructure classes already exist:
- `ParseContext`, `ContextFrame`, `ParsingContext`
- `SubParserInterface`, `StructureType`

What gets removed by the end:
- `FlowHost` (closure bridge), `Driver`/`Frame`/`BuilderResult/*` (state machine),
  `Builder/*` (flow builders), `Harvester` (replaced by `ParseContext`)

---

## Phase 1: Helpers & Infrastructure

### Commit 1 — NodeFactory

- Create `src/Parser/Helper/NodeFactory.php` with `createSimpleNode(Token): Node`
  and `createScalarNode(Token): ScalarNode`.
- Logic extracted from `Parser::createSimpleNode` (line ~904) and
  `Parser::createScalarNode` (line ~886).
- `Parser.php`: replace bodies of private methods with delegation to
  `$this->nodeFactory`.

### Commit 2 — Evolve Consumer

- Inject `NodeFactory` into `Consumer` constructor.
- Change method signatures: `Harvester $harvester` parameter becomes
  `TokenStreamProxy $tokens`.
- Replace `$harvester->flowHost->createSimpleNode()` with
  `$this->nodeFactory->createSimpleNode()`.
- Update all Consumer call sites in `Parser.php` to pass `$harvester->tokens`.
- Update `FlowHost` closures (`collectSpaceAndComments`,
  `collectSpaceCommentEnds`) to pass `$harvester->tokens`.

### Commit 3 — ErrorHelper

- Create `src/Parser/Helper/ErrorHelper.php`.
- Extract `Parser::appendTokenLocation` (line ~263) and
  `Parser::wrapParseStateIndentationException` (line ~2966).
- `Parser.php`: delegate to `$this->errorHelper`.

### Commit 4 — IndentationHelper

- Create `src/Parser/Helper/IndentationHelper.php`.
- Extract `Parser::assertIndentLenIsValid` (line ~274) and
  `Parser::registerIndentStepIfNeeded` (line ~2745).
- These wrap `ParseState` methods with error-context formatting via
  `ErrorHelper`.
- `Parser.php`: delegate to `$this->indentationHelper`.

### Commit 5 — LookAheadHelper

- Create `src/Parser/Helper/LookAheadHelper.php`.
- Extract `Parser::peekFirstSignificantBlockHead` (line ~2700),
  `Parser::isInsignificantIndentationLine` (line ~1291),
  `Parser::collectInsignificantIndentationLines` (line ~383).
- `Parser.php`: delegate to `$this->lookAheadHelper`.

### Commit 6 — MultilineContinuationHelper

- Create `src/Parser/Helper/MultilineContinuationHelper.php`.
- Extract `Parser::isIndentedMultilinePlainContinuationAt` (line ~1257),
  `Parser::isBareDocumentFlushMultilinePlainContinuationAt` (line ~1079),
  `Parser::isMultilinePlainContinuationAhead` (line ~1353).
- `Parser.php`: delegate to `$this->multilineContinuationHelper`.

### Commit 7 — AnchorPostProcessor

- Create `src/Parser/Helper/AnchorPostProcessor.php`.
- Extract `Parser::postProcessKeyValueCouple` (line ~2731) and
  `Parser::collecAnchorsRecursive` (line ~361).
- Fix typo: rename `collecAnchorsRecursive` to `collectAnchorsRecursive` in
  the new class.
- `Parser.php`: delegate to `$this->anchorPostProcessor`.

### Commit 8 — ParserAssembler + ParserRegistry + ParseContext bridge

- Create `src/Parser/Assembler/ParserAssembler.php` — creates helpers eagerly
  in constructor, `create*Parser(ParserRegistry)` factory methods added in
  later commits.
- Create `src/Parser/ParserRegistry.php` — typed getters per sub-parser (stubs
  initially), `getByType(StructureType)` dispatcher.
- In `Parser.php` constructor: create `ParserRegistry` via
  `new ParserRegistry(new ParserAssembler())`.
- In `Parser::parseStream()`: create `ParseContext` from same
  `TokenStreamProxy`, `AnchorsRegistry`, `ParseState` instances as `Harvester`
  — both coexist during migration.
- One new test: verify `ParserRegistry` lazy-creates and caches sub-parsers
  (when at least one sub-parser exists).

---

## Phase 2: Scalar Sub-Parsers

### Commit 9 — PlainScalarParser + QuotedScalarParser

- Create `src/Parser/SubParser/Scalar/PlainScalarParser.php` and
  `QuotedScalarParser.php`.
- These are leaf parsers: receive `ParseContext`, create a scalar node from the
  current token, advance.
- Logic extracted from `Parser::parseValuePrimaryPayload` (line ~2484) — the
  plain/quoted scalar branches.
- Register in `ParserAssembler`; add typed getters to `ParserRegistry`.
- `Parser::parseValuePrimaryPayload`: delegate scalar branches to sub-parsers
  via `$ctx`.

### Commit 10 — BlockScalarParser

- Create `src/Parser/SubParser/Scalar/BlockScalarParser.php`.
- Extract `Parser::consumeBlockScalarKeyName` (line ~556),
  `Parser::consumeIndentedBlockScalarValue` (line ~721),
  `Parser::consumeIndentedBlockTaggedScalarValue` (line ~785), and supporting
  methods (`consumeExplicitKeyMultilinePlainScalar`,
  `consumeExplicitKeyMultilinePlainScalarLine`,
  `tryConsumeExplicitKeyMultilinePlainScalarLine`).
- Depends on: `NodeFactory`, `Consumer`, `IndentationHelper`,
  `LookAheadHelper`.
- Register and wire.

### Commit 11 — MultilinePlainScalarParser

- Create `src/Parser/SubParser/Scalar/MultilinePlainScalarParser.php`.
- Extract `Parser::appendMultilinePlainScalarContinuations` (line ~138) and
  related: `buildExplicitBlockKeyMultilinePlainScalarName` (line ~288),
  `buildFlowKeyMultilinePlainScalarName` (line ~309), `buildScalarKeyName`
  (line ~328).
- Also: `tryConsumeFlowKeyMultilinePlainScalarLine` (line ~2872),
  `tryConsumeFlowValueMultilinePlainScalarLine` (line ~2909).
- Depends on: `NodeFactory`, `Consumer`, `MultilineContinuationHelper`,
  `LookAheadHelper`.
- Register and wire.

---

## Phase 3: Flow Sub-Parsers

### Commit 12 — Create flow sub-parsers

- Create `src/Parser/SubParser/Flow/FlowSequenceParser.php` — replaces
  `FlowSequenceBuilder` + `Parser::runFlowSequenceDriver`.
- Create `src/Parser/SubParser/Flow/FlowMappingParser.php` — replaces
  `FlowMappingBuilder` + `Parser::runFlowMappingDriver`.
- Create `src/Parser/SubParser/Flow/FlowEntryParser.php` — replaces
  `FlowEntryBuilder`.
- Create `src/Parser/SubParser/Flow/FlowMappingPairParser.php` — replaces
  `FlowMappingPairBuilder`.
- Also: `Parser::tryConsumeFlowMappingValueIndicator` (line ~2949) becomes a
  private method in `FlowMappingPairParser`.
- Port logic from Builder state-machine style (`step()`/`onChildCompleted()`)
  to direct recursive `parse()` calls.
- All flow sub-parsers use `ParseContext` + `ParserRegistry` for delegation;
  depend on helpers.
- Register all in `ParserAssembler`; add typed getters to `ParserRegistry`.

### Commit 13 — Wire flow sub-parsers into Parser.php

- `Parser::runFlowSequenceDriver` and `Parser::runFlowMappingDriver`: delegate
  to registry's flow sub-parsers using `$ctx`.
- `Parser::parseFlowContextValue`: delegate to `ValueParser` via registry (or
  inline as a thin wrapper).
- Verify all flow-collection tests pass (including `FlowCollectionsTest`,
  `FixtureParserMappingTest` on flow fixtures).

### Commit 14 — Remove old flow infrastructure

- Delete `src/Parser/Builder/*.php` (5 files).
- Delete `src/Parser/Driver/` (Driver.php, Frame.php, BuilderInterface.php,
  BuilderResult/*.php — 7 files).
- Delete `src/Parser/Flow/FlowHost.php`.
- Remove `FlowHost` property from `Harvester`.
- Remove `Parser::createFlowHost` method and all flow closures.
- Remove `FlowHost`-related imports.
- Delete `tests/unit/Parser/Driver/DriverTest.php` and
  `tests/helper/Parser/Driver/Test*Builder.php` (driver-specific test
  infrastructure, no longer applicable).

---

## Phase 4: Block Sub-Parsers

### Commit 15 — KeyParser

- Create `src/Parser/SubParser/Block/KeyParser.php`.
- Extract `Parser::getKeyNode` (line ~926, ~150 lines) — the most complex
  single method.
- Depends on: `NodeFactory`, `Consumer`, `MultilinePlainScalarParser` (via
  registry), `BlockScalarParser` (via registry).
- Register and wire; `Parser.php` delegates `getKeyNode` calls.

### Commit 16 — KeyValueCoupleParser + SequenceEntryParser

- Create `src/Parser/SubParser/Block/KeyValueCoupleParser.php` — extract
  `Parser::parseKeyValueCoupleAtCurrentPosition` (line ~2223).
- Create `src/Parser/SubParser/Block/SequenceEntryParser.php` — extract
  `Parser::parseSequenceEntryValue` (line ~2337) and
  `Parser::consumeSequenceEntryIndicatorAndSpaces` (line ~839).
- Both depend on: `KeyParser`, `AnchorPostProcessor`, `Consumer`,
  `NodeFactory`.
- Register and wire.

### Commit 17 — BlockMappingParser + BlockSequenceParser

- Create `src/Parser/SubParser/Block/BlockMappingParser.php` — extract
  `Parser::parseBlockMappingValue` (line ~1652).
- Create `src/Parser/SubParser/Block/BlockSequenceParser.php` — extract
  `Parser::parseBlockSequenceValue` (line ~1721).
- Both iterate couples/entries at one indent level using
  `KeyValueCoupleParser`/`SequenceEntryParser`.
- Register and wire.

### Commit 18 — Remaining block sub-parsers

- Create `src/Parser/SubParser/Block/CompactBlockMappingParser.php` — extract
  `Parser::parseCompactBlockMapping` (line ~1799).
- Create `src/Parser/SubParser/Block/CompactBlockSequenceParser.php` — extract
  `Parser::parseCompactBlockSequence` (line ~1842).
- Create `src/Parser/SubParser/Block/IndentedBlockValueParser.php` — extract
  `Parser::parseIndentedBlockValue` (line ~2065, ~160 lines).
- Register and wire.

---

## Phase 5: Structural Sub-Parsers

### Commit 19 — NodePropertiesParser + MergeInstructionParser + DirectiveParser

- Create `src/Parser/SubParser/NodePropertiesParser.php` — extract
  `Parser::collectKeyProperties` (line ~393),
  `Parser::collectValueProperties` (line ~487).
- Create `src/Parser/SubParser/MergeInstructionParser.php` — extract
  `Parser::parseMergeInstructionAtCurrentPosition` (line ~2293),
  `Parser::collectMergeAliases` (line ~449).
- Create `src/Parser/SubParser/DirectiveParser.php` — extract
  `Parser::parseYamlDirective` (line ~2633),
  `Parser::parseTagDirective` (line ~2393).
- Register and wire.

### Commit 20 — ValueParser

- Create `src/Parser/SubParser/ValueParser.php` — extract
  `Parser::parseValue` (line ~2449) and `Parser::parseValuePrimaryPayload`
  (line ~2484).
- This is the central dispatcher: identifies the next construct type, delegates
  to the appropriate sub-parser via `ParserRegistry::getByType()`.
- Uses context stack from `ParseContext` instead of sentinel constants
  (`\Aeliot\YamlToken\Parser\Enum\EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT`,
  `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::FLOW_COLLECTION_VALUE_PARENT`).
- Register and wire.

### Commit 21 — DocumentParser + StreamParser

- Create `src/Parser/SubParser/DocumentParser.php` — extract
  `Parser::parseDocuments` (line ~1883, ~175 lines),
  `Parser::consumeDocumentEndLineSuffix` (line ~637),
  `Parser::tryAddDocumentToStream` (line ~2807).
- Create `src/Parser/SubParser/StreamParser.php` — the top-level sub-parser;
  BOM handling + document iteration.
- `DocumentParser` pushes `ContextFrame(BareDocumentRoot)` for document
  content.
- Register and wire.

---

## Phase 6: Structure Identifiers

### Commit 22 — Identifier classes

- Create `src/Parser/Helper/Identifier/BlockStructureIdentifier.php` — extract:
  `isSequenceStart`, `isKeyValueCoupleStart`,
  `isKeyValueCoupleStartAllowingNodeProperties`,
  `isBlockScalarStartAtDocumentRoot`.
- Create `src/Parser/Helper/Identifier/FlowStructureIdentifier.php` — extract:
  `isFlowMappingStart`, `isFlowSequenceStart`,
  `isFlowMultilinePlainKeyStart`,
  `isFlowCollectionFollowedByBlockValueIndicatorOnSameLine`.
- Create `src/Parser/Helper/Identifier/NodePropertyIdentifier.php` — extract:
  `isNodePropertyToken`, `isNodePropertiesOnlyLine`,
  `isNodePropertyAtDocumentRoot` and related
  `isNodePropertiesFollowedBy*` methods.
- Create `src/Parser/Helper/Identifier/KeyIdentifier.php` — extract:
  `isScalarFollowedByValueIndicator`,
  `isImplicitYamlKeyOnContinuationLine`.
- Create `src/Parser/Helper/Identifier/OngoingStructureIdentifier.php` — facade
  routing `identifyBlockValue`, `identifyFlowValue`,
  `identifyDocumentRootContent` to specialized identifiers above.
- Inject identifiers into sub-parsers that use them; remove `is*` methods from
  sub-parsers (or from `Parser.php` if still there).

---

## Phase 7: Final Cleanup

### Commit 23 — Slim Parser.php to facade

- Remove all remaining private methods from `Parser.php`.
- Remove `Harvester` creation and property — `ParseContext` is the sole
  runtime state.
- Remove sentinel constants 
  (`\Aeliot\YamlToken\Parser\Enum\EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT`,
  `\Aeliot\YamlToken\Parser\Enum\EspecialIndent::FLOW_COLLECTION_VALUE_PARENT`).
- Final `Parser.php` shape:

```php
final class Parser
{
    private readonly ParserRegistry $registry;

    public function __construct()
    {
        $this->registry = new ParserRegistry(new ParserAssembler());
    }

    public function parse(string $input): StreamNode
    {
        $tokens = (new Lexer())->tokenize($input);
        return $this->parseStream($tokens);
    }

    public function parseStream(TokenStream $tokenStream): StreamNode
    {
        $ctx = new ParseContext(
            new TokenStreamProxy($tokenStream),
            new AnchorsRegistry(),
            new ParseState(),
        );
        return $this->registry->getStreamParser()->parse($ctx);
    }
}
```

### Commit 24 — Remove Harvester + dead code

- Delete `src/Parser/Dto/Harvester.php`.
- Remove any dead imports, unused helper methods, or unreachable code paths.
- Run `cs-fix` and `phpstan` for final cleanup.

### Commit 25 — Update documentation

- Update [Parser feature doc](Parser.md): remove Driver/Builder/FlowHost
  description, document sub-parser architecture.
- Update [Parser Driver Architecture doc](../Architecture/ParserDriver.md):
  mark as superseded or rewrite.

---

## Cross-Cutting Concerns

- **Tests**: after every commit, run `composer test-all`. Never edit existing
  tests. Delete driver-specific tests only in Commit 14 (when Driver is
  removed).
- **cs-fix + phpstan**: run `composer cs-fix -- --show-progress=none` and
  `composer phpstan` after each commit.
- **ParseContext bridge**: from Commit 8 onward, `Parser::parseStream()`
  creates both `Harvester` and `ParseContext` sharing the same
  `TokenStreamProxy`/`AnchorsRegistry`/`ParseState` instances. Old code paths
  use `Harvester`, new sub-parsers use `ParseContext`. Both see the same
  mutable state.
- **Lazy registry**: circular dependencies between sub-parsers (e.g.
  `ValueParser <-> BlockMappingParser`) are resolved by lazy creation in
  `ParserRegistry`. Sub-parsers store `ParserRegistry`, not concrete peers.
- **Recursion depth protection**: sub-parsers that perform recursive delegation
  increment `$ctx->depth` on entry and decrement in `finally`. Threshold:
  `MAX_DEPTH = 256`.
