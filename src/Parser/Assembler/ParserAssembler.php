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

use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyValueCoupleParser;
use Aeliot\YamlToken\Parser\SubParser\Block\SequenceEntryParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowEntryParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingPairParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Flow\FlowSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\BlockScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\MultilinePlainScalarParser;
use Aeliot\YamlToken\Parser\SubParser\Scalar\SimpleScalarParser;

final class ParserAssembler
{
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private IndentationHelper $indentationHelper,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
    ) {
    }

    public function createBlockMappingParser(
        ParserRegistry $registry,
        \Closure $isKeyValueCoupleStart,
        \Closure $isKeyValueCoupleStartAllowingNodeProperties,
        \Closure $parseMergeInstructionAtCurrentPosition,
    ): BlockMappingParser {
        return new BlockMappingParser(
            $this->consumer,
            $this->errorHelper,
            $this->indentationHelper,
            $isKeyValueCoupleStart,
            $isKeyValueCoupleStartAllowingNodeProperties,
            $this->lookAheadHelper,
            $parseMergeInstructionAtCurrentPosition,
            $registry,
        );
    }

    public function createBlockScalarParser(ParserRegistry $registry): BlockScalarParser
    {
        return new BlockScalarParser($this->consumer, $this->errorHelper, $this->nodeFactory);
    }

    public function createBlockSequenceParser(ParserRegistry $registry): BlockSequenceParser
    {
        return new BlockSequenceParser(
            $this->consumer,
            $this->errorHelper,
            $this->indentationHelper,
            $this->lookAheadHelper,
            $registry,
        );
    }

    public function createKeyParser(
        ParserRegistry $registry,
        \Closure $parseBlockMappingValue,
        \Closure $parseBlockSequenceValue,
        \Closure $parseCompactBlockSequence,
    ): KeyParser {
        return new KeyParser(
            $this->errorHelper,
            $this->lookAheadHelper,
            $this->multilineContinuationHelper,
            $parseBlockMappingValue,
            $parseBlockSequenceValue,
            $parseCompactBlockSequence,
            $registry,
        );
    }

    public function createKeyValueCoupleParser(
        ParserRegistry $registry,
        \Closure $parseValue,
    ): KeyValueCoupleParser {
        return new KeyValueCoupleParser(
            $this->anchorPostProcessor,
            $this->consumer,
            $this->errorHelper,
            $this->lookAheadHelper,
            $parseValue,
            $registry,
        );
    }

    public function createSequenceEntryParser(
        ParserRegistry $registry,
        \Closure $isFlowCollectionFollowedByBlockValueIndicatorOnSameLine,
        \Closure $isScalarFollowedByValueIndicator,
        \Closure $parseCompactBlockMapping,
        \Closure $parseCompactBlockSequence,
        \Closure $parseValue,
    ): SequenceEntryParser {
        return new SequenceEntryParser(
            $this->errorHelper,
            $isFlowCollectionFollowedByBlockValueIndicatorOnSameLine,
            $isScalarFollowedByValueIndicator,
            $this->nodeFactory,
            $parseCompactBlockMapping,
            $parseCompactBlockSequence,
            $parseValue,
        );
    }

    public function createFlowEntryParser(ParserRegistry $registry): FlowEntryParser
    {
        return new FlowEntryParser($this->anchorPostProcessor, $registry);
    }

    public function createFlowMappingPairParser(): FlowMappingPairParser
    {
        return new FlowMappingPairParser($this->anchorPostProcessor, $this->consumer);
    }

    public function createFlowMappingParser(ParserRegistry $registry): FlowMappingParser
    {
        return new FlowMappingParser($this->consumer, $this->errorHelper, $this->nodeFactory, $registry);
    }

    public function createFlowSequenceParser(ParserRegistry $registry): FlowSequenceParser
    {
        return new FlowSequenceParser($this->consumer, $this->errorHelper, $this->nodeFactory, $registry);
    }

    public function createMultilinePlainScalarParser(ParserRegistry $registry): MultilinePlainScalarParser
    {
        return new MultilinePlainScalarParser($this->errorHelper, $this->multilineContinuationHelper, $this->nodeFactory, $registry);
    }

    public function createSimpleScalarParser(ParserRegistry $registry): SimpleScalarParser
    {
        return new SimpleScalarParser($this->nodeFactory);
    }

    public function getAnchorPostProcessor(): AnchorPostProcessor
    {
        return $this->anchorPostProcessor;
    }

    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    public function getErrorHelper(): ErrorHelper
    {
        return $this->errorHelper;
    }

    public function getIndentationHelper(): IndentationHelper
    {
        return $this->indentationHelper;
    }

    public function getLookAheadHelper(): LookAheadHelper
    {
        return $this->lookAheadHelper;
    }

    public function getMultilineContinuationHelper(): MultilineContinuationHelper
    {
        return $this->multilineContinuationHelper;
    }

    public function getNodeFactory(): NodeFactory
    {
        return $this->nodeFactory;
    }
}
