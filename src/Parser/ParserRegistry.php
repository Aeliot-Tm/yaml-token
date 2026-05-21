<?php

declare(strict_types=1);

/*
 * This file is part of the YAML Token project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Parser\Assembler\ParserAssembler;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\StructureType;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowEntryParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingPairParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\BlockScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\MultilinePlainScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\SimpleScalarParser;

final class ParserRegistry
{
    private ?BlockScalarParser $blockScalarParser = null;
    private ?FlowEntryParser $flowEntryParser = null;
    private ?FlowMappingPairParser $flowMappingPairParser = null;
    private ?FlowMappingParser $flowMappingParser = null;
    private ?FlowSequenceParser $flowSequenceParser = null;
    private ?MultilinePlainScalarParser $multilinePlainScalarParser = null;
    private ?SimpleScalarParser $simpleScalarParser = null;

    public function __construct(
        private readonly ParserAssembler $assembler,
    ) {
    }

    public function getBlockScalarParser(): BlockScalarParser
    {
        return $this->blockScalarParser ??= $this->assembler->createBlockScalarParser($this);
    }

    public function getByType(StructureType $type): SubParserInterface
    {
        return match ($type) {
            StructureType::DOUBLE_QUOTED_SCALAR,
            StructureType::PLAIN_SCALAR,
            StructureType::SINGLE_QUOTED_SCALAR => $this->getSimpleScalarParser(),
            default => throw new \LogicException(\sprintf('No sub-parser registered for structure type "%s"', $type->value)),
        };
    }

    public function getFlowEntryParser(): FlowEntryParser
    {
        return $this->flowEntryParser ??= $this->assembler->createFlowEntryParser($this);
    }

    public function getFlowMappingPairParser(): FlowMappingPairParser
    {
        return $this->flowMappingPairParser ??= $this->assembler->createFlowMappingPairParser();
    }

    public function getFlowMappingParser(): FlowMappingParser
    {
        return $this->flowMappingParser ??= $this->assembler->createFlowMappingParser($this);
    }

    public function getFlowSequenceParser(): FlowSequenceParser
    {
        return $this->flowSequenceParser ??= $this->assembler->createFlowSequenceParser($this);
    }

    public function getMultilinePlainScalarParser(): MultilinePlainScalarParser
    {
        return $this->multilinePlainScalarParser ??= $this->assembler->createMultilinePlainScalarParser($this);
    }

    public function getSimpleScalarParser(): SimpleScalarParser
    {
        return $this->simpleScalarParser ??= $this->assembler->createSimpleScalarParser($this);
    }
}
