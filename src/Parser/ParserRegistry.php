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
use Aeliot\YamlToken\Parser\SubParser\Block\BlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\CompactBlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\CompactBlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\IndentedBlockValueParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyValueCoupleParser;
use Aeliot\YamlToken\Parser\SubParser\Block\SequenceEntryParser;
use Aeliot\YamlToken\Parser\SubParser\DirectiveParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowEntryParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingPairParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\MergeInstructionParser;
use Aeliot\YamlToken\Parser\SubParser\NodePropertiesParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\BlockScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\MultilinePlainScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\SimpleScalarParser;

final class ParserRegistry
{
    private ?BlockMappingParser $blockMappingParser = null;
    private ?BlockScalarParser $blockScalarParser = null;
    private ?BlockSequenceParser $blockSequenceParser = null;
    private ?\Closure $collectValueProperties = null;
    private ?CompactBlockMappingParser $compactBlockMappingParser = null;
    private ?CompactBlockSequenceParser $compactBlockSequenceParser = null;
    private ?DirectiveParser $directiveParser = null;
    private ?FlowEntryParser $flowEntryParser = null;
    private ?FlowMappingPairParser $flowMappingPairParser = null;
    private ?FlowMappingParser $flowMappingParser = null;
    private ?FlowSequenceParser $flowSequenceParser = null;
    private ?IndentedBlockValueParser $indentedBlockValueParser = null;
    private ?\Closure $isFlowCollectionFollowedByBlockValueIndicatorOnSameLine = null;
    private ?\Closure $isKeyValueCoupleStart = null;
    private ?\Closure $isKeyValueCoupleStartAllowingNodeProperties = null;
    private ?\Closure $isNodePropertiesFollowedByImplicitKeyFromOffset = null;
    private ?\Closure $isScalarFollowedByValueIndicator = null;
    private ?KeyParser $keyParser = null;
    private ?KeyValueCoupleParser $keyValueCoupleParser = null;
    private ?MergeInstructionParser $mergeInstructionParser = null;
    private ?MultilinePlainScalarParser $multilinePlainScalarParser = null;
    private ?NodePropertiesParser $nodePropertiesParser = null;
    private ?\Closure $parseBlockMappingValue = null;
    private ?\Closure $parseBlockSequenceValue = null;
    private ?\Closure $parseCompactBlockMapping = null;
    private ?\Closure $parseCompactBlockSequence = null;
    private ?\Closure $parseMergeInstructionAtCurrentPosition = null;
    private ?\Closure $parseValue = null;
    private ?SequenceEntryParser $sequenceEntryParser = null;
    private ?SimpleScalarParser $simpleScalarParser = null;

    public function __construct(
        private readonly ParserAssembler $assembler,
    ) {
    }

    public function getBlockMappingParser(): BlockMappingParser
    {
        return $this->blockMappingParser ??= $this->assembler->createBlockMappingParser(
            $this,
            $this->isKeyValueCoupleStart ?? throw new \LogicException('Block parser bridge not set'),
            $this->isKeyValueCoupleStartAllowingNodeProperties ?? throw new \LogicException('Block parser bridge not set'),
            $this->parseMergeInstructionAtCurrentPosition ?? throw new \LogicException('Block parser bridge not set'),
        );
    }

    public function getBlockScalarParser(): BlockScalarParser
    {
        return $this->blockScalarParser ??= $this->assembler->createBlockScalarParser($this);
    }

    public function getBlockSequenceParser(): BlockSequenceParser
    {
        return $this->blockSequenceParser ??= $this->assembler->createBlockSequenceParser($this);
    }

    public function getCompactBlockMappingParser(): CompactBlockMappingParser
    {
        return $this->compactBlockMappingParser ??= $this->assembler->createCompactBlockMappingParser(
            $this,
            $this->isKeyValueCoupleStartAllowingNodeProperties ?? throw new \LogicException('Block parser bridge not set'),
        );
    }

    public function getCompactBlockSequenceParser(): CompactBlockSequenceParser
    {
        return $this->compactBlockSequenceParser ??= $this->assembler->createCompactBlockSequenceParser($this);
    }

    public function getDirectiveParser(): DirectiveParser
    {
        return $this->directiveParser ??= $this->assembler->createDirectiveParser();
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

    public function getIndentedBlockValueParser(): IndentedBlockValueParser
    {
        return $this->indentedBlockValueParser ??= $this->assembler->createIndentedBlockValueParser(
            $this,
            $this->collectValueProperties ?? throw new \LogicException('Block parser bridge not set'),
            $this->isNodePropertiesFollowedByImplicitKeyFromOffset ?? throw new \LogicException('Block parser bridge not set'),
        );
    }

    public function getKeyParser(): KeyParser
    {
        return $this->keyParser ??= $this->assembler->createKeyParser(
            $this,
            $this->parseBlockMappingValue ?? throw new \LogicException('Block mapping parser bridge not set'),
            $this->parseBlockSequenceValue ?? throw new \LogicException('Block sequence parser bridge not set'),
            $this->parseCompactBlockSequence ?? throw new \LogicException('Block compact parser bridge not set'),
        );
    }

    public function getKeyValueCoupleParser(): KeyValueCoupleParser
    {
        return $this->keyValueCoupleParser ??= $this->assembler->createKeyValueCoupleParser(
            $this,
            $this->parseValue ?? throw new \LogicException('Block parser bridge not set'),
        );
    }

    public function getMergeInstructionParser(): MergeInstructionParser
    {
        return $this->mergeInstructionParser ??= $this->assembler->createMergeInstructionParser(
            $this->parseValue ?? throw new \LogicException('Block parser bridge not set'),
        );
    }

    public function getMultilinePlainScalarParser(): MultilinePlainScalarParser
    {
        return $this->multilinePlainScalarParser ??= $this->assembler->createMultilinePlainScalarParser($this);
    }

    public function getNodePropertiesParser(): NodePropertiesParser
    {
        return $this->nodePropertiesParser ??= $this->assembler->createNodePropertiesParser();
    }

    public function getSequenceEntryParser(): SequenceEntryParser
    {
        return $this->sequenceEntryParser ??= $this->assembler->createSequenceEntryParser(
            $this,
            $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine ?? throw new \LogicException('Block parser bridge not set'),
            $this->isScalarFollowedByValueIndicator ?? throw new \LogicException('Block parser bridge not set'),
            $this->parseCompactBlockMapping ?? throw new \LogicException('Block parser bridge not set'),
            $this->parseCompactBlockSequence ?? throw new \LogicException('Block parser bridge not set'),
            $this->parseValue ?? throw new \LogicException('Block parser bridge not set'),
        );
    }

    public function getSimpleScalarParser(): SimpleScalarParser
    {
        return $this->simpleScalarParser ??= $this->assembler->createSimpleScalarParser($this);
    }

    public function setBlockParserBridge(
        \Closure $collectValueProperties,
        \Closure $isFlowCollectionFollowedByBlockValueIndicatorOnSameLine,
        \Closure $isKeyValueCoupleStart,
        \Closure $isKeyValueCoupleStartAllowingNodeProperties,
        \Closure $isNodePropertiesFollowedByImplicitKeyFromOffset,
        \Closure $isScalarFollowedByValueIndicator,
        \Closure $parseBlockMappingValue,
        \Closure $parseBlockSequenceValue,
        \Closure $parseCompactBlockMapping,
        \Closure $parseCompactBlockSequence,
        \Closure $parseMergeInstructionAtCurrentPosition,
        \Closure $parseValue,
    ): void {
        $this->collectValueProperties = $collectValueProperties;
        $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine = $isFlowCollectionFollowedByBlockValueIndicatorOnSameLine;
        $this->isKeyValueCoupleStart = $isKeyValueCoupleStart;
        $this->isKeyValueCoupleStartAllowingNodeProperties = $isKeyValueCoupleStartAllowingNodeProperties;
        $this->isNodePropertiesFollowedByImplicitKeyFromOffset = $isNodePropertiesFollowedByImplicitKeyFromOffset;
        $this->isScalarFollowedByValueIndicator = $isScalarFollowedByValueIndicator;
        $this->parseBlockMappingValue = $parseBlockMappingValue;
        $this->parseBlockSequenceValue = $parseBlockSequenceValue;
        $this->parseCompactBlockMapping = $parseCompactBlockMapping;
        $this->parseCompactBlockSequence = $parseCompactBlockSequence;
        $this->parseMergeInstructionAtCurrentPosition = $parseMergeInstructionAtCurrentPosition;
        $this->parseValue = $parseValue;
    }
}
