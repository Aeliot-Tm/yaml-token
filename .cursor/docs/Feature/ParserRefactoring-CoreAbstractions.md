# Parser Refactoring: Core Abstractions

Parent: [Parser Refactoring](ParserRefactoring.md)

## SubParserInterface

Marker interface for all sub-parsers. Concrete parsers define their own
`parse()` signatures because parameter sets differ (e.g. `$parentIndentLen`
for block parsers, nothing extra for flow parsers).

```php
namespace Parser\Contract;

interface SubParserInterface {}
```

## ParseContext

Replaces `Harvester`. Pure runtime state passed to every `parse()` call. Does
**not** hold a reference to `FlowHost` or `StreamNode`.

Includes a `$depth` counter for
[recursion depth protection](ParserRefactoring-Decisions.md#recursion-depth-protection)
and a [context stack](ParserRefactoring-Decisions.md#context-stack-replaces-sentinel-constants)
that tracks the current parsing context (block / flow / bare-document-root).

```php
namespace Parser;

final class ParseContext
{
    public int $depth = 0;
    /** @var ContextFrame[] */
    private array $contextStack = [];

    public function __construct(
        public readonly TokenStreamProxy $tokens,
        public readonly AnchorsRegistry  $anchors,
        public readonly ParseState       $state,
    ) {}

    public function pushContext(ContextFrame $frame): void { ... }
    public function popContext(): void { ... }
    public function getCurrentContext(): ContextFrame { ... }
}
```

## StructureType

Enum of parsable YAML constructs — the key used by `ParserRegistry::getByType()`
and returned by `OngoingStructureIdentifier`.

```php
namespace Parser\Enum;

enum StructureType: string
{
    case BlockMapping          = 'block_mapping';
    case BlockSequence         = 'block_sequence';
    case CompactBlockMapping   = 'compact_block_mapping';
    case CompactBlockSequence  = 'compact_block_sequence';
    case FlowSequence          = 'flow_sequence';
    case FlowMapping           = 'flow_mapping';
    case PlainScalar           = 'plain_scalar';
    case SingleQuotedScalar    = 'single_quoted_scalar';
    case DoubleQuotedScalar    = 'double_quoted_scalar';
    case MultilinePlainScalar  = 'multiline_plain_scalar';
    case LiteralBlockScalar    = 'literal_block_scalar';
    case FoldedBlockScalar     = 'folded_block_scalar';
    case Alias                 = 'alias';
    case MergeInstruction      = 'merge_instruction';
    case Document              = 'document';
    case Directive             = 'directive';
    case Empty                 = 'empty';
}
```

## ParserRegistry

Lazy container with self-injection. Receives `ParserAssembler` in the
constructor. On first access to a sub-parser the registry asks the assembler
to create it (passing `$this`), then caches the instance. Subsequent calls
return the cached object.

This resolves circular dependencies without setter injection: no sub-parser
constructor requires other sub-parsers to already exist — only
`ParserRegistry`, which is fully constructed before any sub-parser is created.

See [Decision: Lazy Resolution](ParserRefactoring-Decisions.md#lazy-resolution-via-registry).

```php
namespace Parser;

final class ParserRegistry
{
    /** @var array<class-string, SubParserInterface> */
    private array $cache = [];

    public function __construct(
        private readonly ParserAssembler $assembler,
    ) {}

    /** Typed accessors — when the caller knows exactly what it needs. */
    public function getStreamParser(): StreamParser
    {
        return $this->cache[StreamParser::class]
            ??= $this->assembler->createStreamParser($this);
    }

    public function getBlockMappingParser(): BlockMappingParser
    {
        return $this->cache[BlockMappingParser::class]
            ??= $this->assembler->createBlockMappingParser($this);
    }

    public function getFlowSequenceParser(): FlowSequenceParser
    {
        return $this->cache[FlowSequenceParser::class]
            ??= $this->assembler->createFlowSequenceParser($this);
    }

    public function getValueParser(): ValueParser
    {
        return $this->cache[ValueParser::class]
            ??= $this->assembler->createValueParser($this);
    }

    // ... one typed getter per sub-parser

    /** Dynamic lookup — when the type is resolved at runtime by the identifier. */
    public function getByType(StructureType $type): SubParserInterface { ... }
}
```

## ParserAssembler

Single assembler class. Shared stateless helpers are created eagerly in the
constructor. Each `create*Parser(ParserRegistry)` method builds one sub-parser,
injecting the registry and the relevant helpers. If the assembler grows too
large later, it can be split — but the lazy registry design makes the split
trivial and not required upfront.

See [Decision: Single Assembler](ParserRefactoring-Decisions.md#single-assembler).

```php
namespace Parser\Assembler;

final class ParserAssembler
{
    private readonly NodeFactory $nodeFactory;
    private readonly Consumer $consumer;
    private readonly LookAheadHelper $lookAhead;
    private readonly IndentationHelper $indentation;
    private readonly ErrorHelper $errorHelper;
    // ...

    public function __construct()
    {
        $this->nodeFactory = new NodeFactory();
        $this->consumer    = new Consumer($this->nodeFactory);
        $this->lookAhead   = new LookAheadHelper();
        $this->indentation = new IndentationHelper();
        $this->errorHelper = new ErrorHelper();
        // ...
    }

    public function createBlockMappingParser(ParserRegistry $registry): BlockMappingParser
    {
        return new BlockMappingParser($registry, $this->consumer, $this->indentation, ...);
    }

    public function createFlowSequenceParser(ParserRegistry $registry): FlowSequenceParser
    {
        return new FlowSequenceParser($registry, $this->nodeFactory, $this->consumer, ...);
    }

    // ... one create* method per sub-parser
}
```
