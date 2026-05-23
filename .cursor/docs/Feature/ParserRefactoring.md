# Parser Refactoring: Sub-Parser Composition

## Status

**Completed** on branch `refactor-parser`. The former ~3 000-line `Parser.php`
God-class, the **Driver / Frame / Builder** flow runtime, **`FlowHost`** closure
bridge, and **`Harvester`** DTO were replaced by sub-parser composition described
below. User-facing behaviour and fixture expectations are unchanged.

See [Parser](Parser.md) for parsing semantics and [Parser Architecture](../Architecture/ParserDriver.md)
for the current component layout.

## Motivation

The monolithic `Parser.php` owned all block-parsing logic and reached flow parsing
only through an 11-closure `FlowHost` bridge. That made control flow hard to
follow, isolated testing difficult, and extension risky.

## Design Principles

1. **One parser per YAML construct** — each class handles a single grammar
   production (e.g. flow sequence, block mapping, plain scalar).
2. **Direct delegation** — parsers call each other through the PHP call stack,
   not through a Driver / Frame state machine or closure bridge.
3. **Structure identifiers** — look-ahead predicates live in
   `Helper/Identifier/*` classes and are injected into the sub-parsers that need them.
4. **Lazy resolution via registry** — sub-parsers receive `ParserRegistry` in
   their constructors; the registry creates each sub-parser on first access
   (via `ParserAssembler`) and caches it. This resolves circular dependencies
   (e.g. `ValueParser ↔ BlockMappingParser`) without setter injection.
5. **Incremental migration** — the refactor landed in small steps; see
   [Migration Plan](ParserRefactoring-MigrationPlan.md) for the historical sequence.

See [Design Decisions](ParserRefactoring-Decisions.md) for rationale behind
each principle.

## Related Documents

- [Core Abstractions](ParserRefactoring-CoreAbstractions.md) — `ParseContext`,
  `ParserRegistry`, `ParserAssembler`, `ParserBuilder`, `StructureType`,
  `SubParserInterface`.
- [Sub-Parser Catalog](ParserRefactoring-SubParsers.md) — sub-parsers, helpers,
  and mapping from former `Parser.php` methods.
- [Design Decisions](ParserRefactoring-Decisions.md) — lazy resolution, single
  assembler, recursion depth protection, context stack.
- [Migration Plan](ParserRefactoring-MigrationPlan.md) — phased commit plan
  (historical; all phases complete).

## Control-Flow Example

```text
ValueParser::parseValue(ctx, parentIndentLen)
  │
  ├── NodePropertiesParser::collectValueProperties(ctx, valueNode)
  │
  ├── token → block scalar / NEWLINE / scalar / alias / flow start …
  │
  └── registry->getFlowSequenceParser()->parse(ctx)
        │
        ├── consume `[`
        ├── loop:
        │   ├── FlowEntryParser::parse(ctx)
        │   │   └── ValueParser::parseValue(ctx, FLOW_COLLECTION_VALUE_PARENT)
        │   │       └── SimpleScalarParser::parse(ctx) → ScalarNode
        │   └── return ValueNode
        │
        │   consume `,`
        │
        │   FlowEntryParser::parse(ctx)
        │   └── registry->getFlowMappingParser()->parse(ctx)
        │       └── … recursive delegation …
        │
        ├── consume `]`
        └── return FlowSequenceNode
```

## Removed Components

- **`FlowHost`** — closure bridge to private `Parser` helpers.
- **`Driver`**, **`Frame`**, **`BuilderInterface`**, **`BuilderResult/*`** —
  stack-machine runtime for flow collections.
- **`Builder/*`** — replaced by `SubParser/Flow/*`.
- **`Harvester`** — replaced by `ParseContext`.

## File Layout

```text
src/Parser/
├── Parser.php                          # Thin façade
├── ParserBuilder.php                   # Production wiring
├── ParseContext.php
├── ParserRegistry.php
│
├── Contract/
│   └── SubParserInterface.php
│
├── Enum/
│   ├── EspecialIndent.php
│   ├── ParsingContext.php
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
│   ├── Block/          (8 parsers)
│   ├── Flow/           (4 parsers)
│   └── Scalar/         (SimpleScalarParser, MultilinePlainScalarParser, BlockScalarParser)
│
├── Helper/
│   ├── Identifier/     (Block, Flow, Key, NodeProperty — no facade class)
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
│   ├── AnchorsRegistry.php
│   ├── ContextFrame.php
│   ├── ParseState.php
│   └── TokenStreamProxy.php
│
└── Exception/
```
