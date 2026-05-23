# Parser Refactoring: Core Abstractions

Parent: [Parser Refactoring](ParserRefactoring.md)

## SubParserInterface

Marker interface for all sub-parsers. Concrete parsers define their own
`parse()` signatures because parameter sets differ (e.g. `$parentIndentLen`
for block values, nothing extra for flow collections).

```php
namespace Aeliot\YamlToken\Parser\Contract;

interface SubParserInterface {}
```

## ParseContext

Replaces `Harvester`. Pure runtime state passed to every sub-parser call. Does
**not** hold a reference to `StreamNode`.

Includes a `$depth` counter for
[recursion depth protection](ParserRefactoring-Decisions.md#recursion-depth-protection)
and a [context stack](ParserRefactoring-Decisions.md#context-stack-replaces-sentinel-constants)
(`ContextFrame` + `ParsingContext` enum: Block / Flow / BareDocumentRoot).

```php
namespace Aeliot\YamlToken\Parser;

final class ParseContext
{
    public int $depth = 0;

    public function __construct(
        public readonly TokenStreamProxy $tokens,
        public readonly AnchorsRegistry $anchorsRegistry,
        public readonly ParseState $state,
    ) {}

    public function pushContext(ContextFrame $frame): void { ... }
    public function popContext(): void { ... }
    public function getCurrentContext(): ContextFrame { ... }
}
```

## StructureType

Enum of parsable YAML constructs. Used by `ParserRegistry::getByType()` for
dynamic scalar dispatch; most delegation uses typed registry getters instead.

```php
namespace Aeliot\YamlToken\Parser\Enum;

enum StructureType: string
{
    case BlockMapping          = 'block_mapping';
    case BlockSequence         = 'block_sequence';
    // … flow, scalar, alias, directive, empty, etc.
}
```

## ParserRegistry

Lazy container. Receives `ParserAssembler` in the constructor. On first access
to a sub-parser the registry asks the assembler to create it (passing `$this`),
then caches the instance in typed nullable properties.

```php
final class ParserRegistry
{
    private ?ValueParser $valueParser = null;
    // … one nullable property per sub-parser

    public function getValueParser(): ValueParser
    {
        return $this->valueParser ??= $this->assembler->createValueParser($this);
    }

    public function getByType(StructureType $type): SubParserInterface
    {
        return match ($type) {
            StructureType::PLAIN_SCALAR,
            StructureType::SINGLE_QUOTED_SCALAR,
            StructureType::DOUBLE_QUOTED_SCALAR => $this->getSimpleScalarParser(),
            default => throw new \LogicException(...),
        };
    }
}
```

See [Decision: Lazy Resolution](ParserRefactoring-Decisions.md#lazy-resolution-via-registry).

## ParserAssembler

Single assembler class. Shared stateless helpers and structure identifiers are
created lazily via getter methods on the assembler. Each `create*Parser(ParserRegistry)`
method builds one sub-parser, injecting the registry and relevant helpers.

```php
namespace Aeliot\YamlToken\Parser\Assembler;

final class ParserAssembler
{
    public function __construct(
        private readonly AnchorPostProcessor $anchorPostProcessor,
        private readonly Consumer $consumer,
        private readonly ErrorHelper $errorHelper,
        // …
    ) {}

    public function createValueParser(ParserRegistry $registry): ValueParser
    {
        return new ValueParser($this->consumer, $this->errorHelper, ..., $registry);
    }
}
```

## ParserBuilder

Production entry point that wires helpers, assembler, registry, and `Parser`:

```php
final class ParserBuilder
{
    public function createParser(): Parser
    {
        return new Parser(new ParserRegistry($this->createAssembler()));
    }
}
```

Tests and application code typically use `ParserBuilder` rather than constructing
`ParserRegistry` / `ParserAssembler` manually.

## Parser façade

```php
final class Parser
{
    public function __construct(private ParserRegistry $parserRegistry) {}

    public function parseStream(TokenStream $tokens): StreamNode
    {
        $parseContext = new ParseContext(
            new TokenStreamProxy($tokens),
            new AnchorsRegistry(),
            new ParseState(),
        );

        return $this->parserRegistry->getStreamParser()->parseStream($parseContext);
    }
}
```
