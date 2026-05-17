# Parser Refactoring: Sub-Parser Composition

## Motivation

`Parser.php` has grown to ~3 000 lines / ~74 methods. It is a God-class that
owns all block-parsing logic directly and reaches into flow builders only
through the `FlowHost` closure bridge. The `FlowHost` callback mechanism
(11 closures wrapping `private` methods of `Parser`) obscures control flow
more than it helps. The class is hard to navigate, test in isolation, and extend.

## Design Principles

1. **One parser per YAML construct** — each class handles a single grammar
   production (e.g. flow sequence, block mapping, plain scalar).
2. **Direct delegation** — parsers call each other through the PHP call stack,
   not through a Driver / Frame state machine or closure bridge.
3. **Dynamic dispatch via registry** — when the next construct is unknown at
   compile time, a `ParserRegistry` + `OngoingStructureIdentifier` pair
   resolves the type at runtime and returns the appropriate sub-parser.
4. **Lazy resolution via registry** — sub-parsers receive `ParserRegistry` in
   their constructors; the registry creates each sub-parser on first access
   (via `ParserAssembler`) and caches it. This naturally resolves circular
   dependencies (e.g. `ValueParser ↔ BlockMappingParser`) without setter
   injection or two-phase wiring.
5. **Gradual migration** — refactor one group at a time, keeping tests green
   after every step.

See [Design Decisions](ParserRefactoring-Decisions.md) for rationale behind
each principle.

## Related Documents

- [Core Abstractions](ParserRefactoring-CoreAbstractions.md) — `ParseContext`,
  `ParserRegistry`, `ParserAssembler`, `StructureType`, `SubParserInterface`
  with code examples.
- [Sub-Parser Catalog](ParserRefactoring-SubParsers.md) — full list of
  sub-parsers (structural, block, flow, scalar) and helper classes with mapping
  to current `Parser.php` methods.
- [Design Decisions](ParserRefactoring-Decisions.md) — key architectural
  decisions and their rationale (lazy resolution, single assembler, recursion
  depth protection).

## Control-Flow Example

```
ValueParser::parse(ctx, parentIndentLen)
  │
  ├── NodePropertiesParser::parse(ctx)         // &anchor !tag if present
  │
  ├── identifier->identifyBlockValue(ctx, …)   // look-ahead → StructureType::FlowSequence
  │
  └── registry->getFlowSequenceParser()->parse(ctx)
        │
        ├── consume `[`
        ├── loop:
        │   ├── FlowEntryParser::parse(ctx)
        │   │   ├── identifier->identifyFlowValue(ctx) → PlainScalar
        │   │   └── registry->getByType(PlainScalar)->parse(ctx)
        │   │       └── return ScalarNode
        │   └── return ValueNode
        │
        │   consume `,`
        │
        │   FlowEntryParser::parse(ctx)
        │   ├── identifier->identifyFlowValue(ctx) → FlowMapping
        │   └── registry->getFlowMappingParser()->parse(ctx)
        │       └── … recursive delegation …
        │
        ├── consume `]`
        └── return FlowSequenceNode
```

## What Gets Removed

- **`FlowHost`** — entirely; the closure bridge is no longer needed.
- **`Driver`**, **`Frame`**, **`BuilderInterface`**, **`BuilderResult/*`** — the
  stack-machine runtime is replaced by direct PHP call-stack delegation.
- **`Builder/*`** (`FlowSequenceBuilder`, etc.) — replaced by `SubParser/Flow/*`.
- **`Harvester`** — replaced by `ParseContext`.

## File Layout

```
src/Parser/
├── Parser.php                          # Thin façade: Lexer → ParseContext → StreamParser
├── ParseContext.php
├── ParserRegistry.php
│
├── Contract/
│   └── SubParserInterface.php
│
├── Enum/
│   └── StructureType.php
│
├── SubParser/
│   ├── StreamParser.php
│   ├── DocumentParser.php
│   ├── DirectiveParser.php
│   ├── ValueParser.php
│   ├── NodePropertiesParser.php
│   ├── MergeInstructionParser.php
│   │
│   ├── Block/
│   │   ├── BlockMappingParser.php
│   │   ├── BlockSequenceParser.php
│   │   ├── CompactBlockMappingParser.php
│   │   ├── CompactBlockSequenceParser.php
│   │   ├── KeyParser.php
│   │   ├── KeyValueCoupleParser.php
│   │   ├── SequenceEntryParser.php
│   │   └── IndentedBlockValueParser.php
│   │
│   ├── Flow/
│   │   ├── FlowSequenceParser.php
│   │   ├── FlowMappingParser.php
│   │   ├── FlowEntryParser.php
│   │   └── FlowMappingPairParser.php
│   │
│   └── Scalar/
│       ├── PlainScalarParser.php
│       ├── QuotedScalarParser.php
│       ├── MultilinePlainScalarParser.php
│       └── BlockScalarParser.php
│
├── Helper/
│   ├── Identifier/
│   │   ├── OngoingStructureIdentifier.php  # Facade
│   │   ├── BlockStructureIdentifier.php
│   │   ├── FlowStructureIdentifier.php
│   │   ├── NodePropertyIdentifier.php
│   │   └── KeyIdentifier.php
│   ├── NodeFactory.php
│   ├── Consumer.php
│   ├── LookAheadHelper.php
│   ├── IndentationHelper.php
│   ├── MultilineContinuationHelper.php
│   ├── ErrorHelper.php
│   └── AnchorPostProcessor.php
│
├── Assembler/
│   └── ParserAssembler.php
│
├── Dto/
│   ├── AnchorsRegistry.php             # kept
│   ├── ParseState.php                  # kept
│   └── TokenStreamProxy.php            # kept
│
└── Exception/                          # kept as-is
```

## Migration Strategy

Refactor incrementally, keeping all tests green after every step:

1. **Infrastructure** — `ParseContext`, `ParserRegistry`, `ParserAssembler`,
   `SubParserInterface`, `StructureType`, `NodeFactory`, `ErrorHelper`. The
   registry + assembler pair is the backbone — once they exist, sub-parsers
   can be migrated in any order.
2. **Helpers** — `LookAheadHelper`, `IndentationHelper`, evolve `Consumer`
   (switch from `FlowHost` to `NodeFactory`), `MultilineContinuationHelper`.
3. **Scalar parsers** — simplest, fewest dependencies.
4. **Flow parsers** — replace `Builder/*` + `Driver` + `FlowHost` with direct
   `FlowSequenceParser` etc.
5. **Block parsers** — largest group.
6. **Structural parsers** — `DocumentParser`, `StreamParser`.
7. **`OngoingStructureIdentifier`** — migrate all `is*` predicates.
8. **Slim `Parser.php`** — reduce to façade:
   `parse()` → `new ParserRegistry(new ParserAssembler())` → `registry->getStreamParser()->parse(ctx)`.
