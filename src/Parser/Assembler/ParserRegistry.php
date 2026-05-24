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

namespace Aeliot\YamlToken\Parser\Assembler;

use Aeliot\YamlToken\Parser\Helper\FlowMultilinePlainScalarHelper;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\CompactBlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\CompactBlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\IndentedBlockValueParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyValueCoupleParser;
use Aeliot\YamlToken\Parser\SubParser\Block\SequenceEntryParser;
use Aeliot\YamlToken\Parser\SubParser\DocumentParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowEntryParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingPairParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\MergeInstructionParser;
use Aeliot\YamlToken\Parser\SubParser\NodePropertiesParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\BlockScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\MultilinePlainScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\SimpleScalarParser;
use Aeliot\YamlToken\Parser\SubParser\StreamParser;
use Aeliot\YamlToken\Parser\SubParser\TagDirectiveParser;
use Aeliot\YamlToken\Parser\SubParser\ValueParser;
use Aeliot\YamlToken\Parser\SubParser\YamlDirectiveParser;

final class ParserRegistry
{
    private ?BlockMappingParser $blockMappingParser = null;
    private ?BlockScalarParser $blockScalarParser = null;
    private ?BlockSequenceParser $blockSequenceParser = null;
    private ?CompactBlockMappingParser $compactBlockMappingParser = null;
    private ?CompactBlockSequenceParser $compactBlockSequenceParser = null;
    private ?DocumentParser $documentParser = null;
    private ?FlowEntryParser $flowEntryParser = null;
    private ?FlowMappingPairParser $flowMappingPairParser = null;
    private ?FlowMappingParser $flowMappingParser = null;
    private ?FlowMultilinePlainScalarHelper $flowMultilinePlainScalarHelper = null;
    private ?FlowSequenceParser $flowSequenceParser = null;
    private ?IndentedBlockValueParser $indentedBlockValueParser = null;
    private ?KeyParser $keyParser = null;
    private ?KeyValueCoupleParser $keyValueCoupleParser = null;
    private ?MergeInstructionParser $mergeInstructionParser = null;
    private ?MultilinePlainScalarParser $multilinePlainScalarParser = null;
    private ?NodePropertiesParser $nodePropertiesParser = null;
    private ?SequenceEntryParser $sequenceEntryParser = null;
    private ?SimpleScalarParser $simpleScalarParser = null;
    private ?StreamParser $streamParser = null;
    private ?TagDirectiveParser $tagDirectiveParser = null;
    private ?ValueParser $valueParser = null;
    private ?YamlDirectiveParser $yamlDirectiveParser = null;

    public function __construct(
        private readonly ParserAssembler $assembler,
    ) {
    }

    public function getBlockMappingParser(): BlockMappingParser
    {
        return $this->blockMappingParser ??= $this->assembler->createBlockMappingParser($this);
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
        return $this->compactBlockMappingParser ??= $this->assembler->createCompactBlockMappingParser($this);
    }

    public function getCompactBlockSequenceParser(): CompactBlockSequenceParser
    {
        return $this->compactBlockSequenceParser ??= $this->assembler->createCompactBlockSequenceParser($this);
    }

    public function getDocumentParser(): DocumentParser
    {
        return $this->documentParser ??= $this->assembler->createDocumentParser($this);
    }

    public function getFlowEntryParser(): FlowEntryParser
    {
        return $this->flowEntryParser ??= $this->assembler->createFlowEntryParser($this);
    }

    public function getFlowMappingPairParser(): FlowMappingPairParser
    {
        return $this->flowMappingPairParser ??= $this->assembler->createFlowMappingPairParser($this);
    }

    public function getFlowMappingParser(): FlowMappingParser
    {
        return $this->flowMappingParser ??= $this->assembler->createFlowMappingParser($this);
    }

    public function getFlowMultilinePlainScalarHelper(): FlowMultilinePlainScalarHelper
    {
        return $this->flowMultilinePlainScalarHelper ??= $this->assembler->createFlowMultilinePlainScalarHelper();
    }

    public function getFlowSequenceParser(): FlowSequenceParser
    {
        return $this->flowSequenceParser ??= $this->assembler->createFlowSequenceParser($this);
    }

    public function getIndentedBlockValueParser(): IndentedBlockValueParser
    {
        return $this->indentedBlockValueParser ??= $this->assembler->createIndentedBlockValueParser($this);
    }

    public function getKeyParser(): KeyParser
    {
        return $this->keyParser ??= $this->assembler->createKeyParser($this);
    }

    public function getKeyValueCoupleParser(): KeyValueCoupleParser
    {
        return $this->keyValueCoupleParser ??= $this->assembler->createKeyValueCoupleParser($this);
    }

    public function getMergeInstructionParser(): MergeInstructionParser
    {
        return $this->mergeInstructionParser ??= $this->assembler->createMergeInstructionParser($this);
    }

    public function getMultilinePlainScalarParser(): MultilinePlainScalarParser
    {
        return $this->multilinePlainScalarParser ??= $this->assembler->createMultilinePlainScalarParser();
    }

    public function getNodePropertiesParser(): NodePropertiesParser
    {
        return $this->nodePropertiesParser ??= $this->assembler->createNodePropertiesParser();
    }

    public function getSequenceEntryParser(): SequenceEntryParser
    {
        return $this->sequenceEntryParser ??= $this->assembler->createSequenceEntryParser($this);
    }

    public function getSimpleScalarParser(): SimpleScalarParser
    {
        return $this->simpleScalarParser ??= $this->assembler->createSimpleScalarParser($this);
    }

    public function getStreamParser(): StreamParser
    {
        return $this->streamParser ??= $this->assembler->createStreamParser($this);
    }

    public function getTagDirectiveParser(): TagDirectiveParser
    {
        return $this->tagDirectiveParser ??= $this->assembler->createTagDirectiveParser();
    }

    public function getValueParser(): ValueParser
    {
        return $this->valueParser ??= $this->assembler->createValueParser($this);
    }

    public function getYamlDirectiveParser(): YamlDirectiveParser
    {
        return $this->yamlDirectiveParser ??= $this->assembler->createYamlDirectiveParser();
    }
}
