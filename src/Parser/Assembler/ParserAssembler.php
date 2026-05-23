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
use Aeliot\YamlToken\Parser\Helper\Identifier\BlockStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\KeyIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\BlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\CompactBlockMappingParser;
use Aeliot\YamlToken\Parser\SubParser\Block\CompactBlockSequenceParser;
use Aeliot\YamlToken\Parser\SubParser\Block\IndentedBlockValueParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyParser;
use Aeliot\YamlToken\Parser\SubParser\Block\KeyValueCoupleParser;
use Aeliot\YamlToken\Parser\SubParser\Block\SequenceEntryParser;
use Aeliot\YamlToken\Parser\SubParser\DirectiveParser;
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
use Aeliot\YamlToken\Parser\SubParser\ValueParser;

final class ParserAssembler
{
    private ?BlockStructureIdentifier $blockStructureIdentifier = null;
    private ?FlowStructureIdentifier $flowStructureIdentifier = null;
    private ?KeyIdentifier $keyIdentifier = null;
    private ?NodePropertyIdentifier $nodePropertyIdentifier = null;

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

    public function createBlockMappingParser(ParserRegistry $registry): BlockMappingParser
    {
        return new BlockMappingParser(
            $this->getBlockStructureIdentifier(),
            $this->consumer,
            $this->errorHelper,
            $this->indentationHelper,
            $this->lookAheadHelper,
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

    public function createCompactBlockMappingParser(ParserRegistry $registry): CompactBlockMappingParser
    {
        return new CompactBlockMappingParser(
            $this->getBlockStructureIdentifier(),
            $this->consumer,
            $this->lookAheadHelper,
            $registry,
        );
    }

    public function createCompactBlockSequenceParser(ParserRegistry $registry): CompactBlockSequenceParser
    {
        return new CompactBlockSequenceParser(
            $this->consumer,
            $this->lookAheadHelper,
            $registry,
        );
    }

    public function createDirectiveParser(): DirectiveParser
    {
        return new DirectiveParser($this->consumer, $this->errorHelper, $this->nodeFactory);
    }

    public function createDocumentParser(ParserRegistry $registry): DocumentParser
    {
        return new DocumentParser(
            $this->getBlockStructureIdentifier(),
            $this->errorHelper,
            $this->getFlowStructureIdentifier(),
            $this->getNodePropertyIdentifier(),
            $registry,
        );
    }

    public function createFlowEntryParser(ParserRegistry $registry): FlowEntryParser
    {
        return new FlowEntryParser(
            $this->anchorPostProcessor,
            $this->getFlowStructureIdentifier(),
            $this->getKeyIdentifier(),
            $registry,
        );
    }

    public function createFlowMappingPairParser(ParserRegistry $registry): FlowMappingPairParser
    {
        return new FlowMappingPairParser($this->anchorPostProcessor, $this->consumer, $registry);
    }

    public function createFlowMappingParser(ParserRegistry $registry): FlowMappingParser
    {
        return new FlowMappingParser($this->consumer, $this->errorHelper, $this->nodeFactory, $registry);
    }

    public function createFlowSequenceParser(ParserRegistry $registry): FlowSequenceParser
    {
        return new FlowSequenceParser($this->consumer, $this->errorHelper, $this->nodeFactory, $registry);
    }

    public function createIndentedBlockValueParser(ParserRegistry $registry): IndentedBlockValueParser
    {
        return new IndentedBlockValueParser(
            $this->consumer,
            $this->errorHelper,
            $this->lookAheadHelper,
            $this->multilineContinuationHelper,
            $this->nodeFactory,
            $this->getNodePropertyIdentifier(),
            $registry,
        );
    }

    public function createKeyParser(ParserRegistry $registry): KeyParser
    {
        return new KeyParser(
            $this->errorHelper,
            $this->lookAheadHelper,
            $this->multilineContinuationHelper,
            $registry,
        );
    }

    public function createKeyValueCoupleParser(ParserRegistry $registry): KeyValueCoupleParser
    {
        return new KeyValueCoupleParser(
            $this->anchorPostProcessor,
            $this->consumer,
            $this->errorHelper,
            $this->lookAheadHelper,
            $registry,
        );
    }

    public function createMergeInstructionParser(\Closure $parseValue): MergeInstructionParser
    {
        return new MergeInstructionParser($this->consumer, $this->errorHelper, $this->nodeFactory, $parseValue);
    }

    public function createNodePropertiesParser(): NodePropertiesParser
    {
        return new NodePropertiesParser($this->errorHelper);
    }

    public function createSequenceEntryParser(
        \Closure $parseCompactBlockMapping,
        \Closure $parseCompactBlockSequence,
        \Closure $parseValue,
    ): SequenceEntryParser {
        return new SequenceEntryParser(
            $this->errorHelper,
            $this->getFlowStructureIdentifier(),
            $this->getKeyIdentifier(),
            $this->nodeFactory,
            $parseCompactBlockMapping,
            $parseCompactBlockSequence,
            $parseValue,
        );
    }

    public function createMultilinePlainScalarParser(ParserRegistry $registry): MultilinePlainScalarParser
    {
        return new MultilinePlainScalarParser($this->errorHelper, $this->multilineContinuationHelper, $this->nodeFactory, $registry);
    }

    public function createSimpleScalarParser(ParserRegistry $registry): SimpleScalarParser
    {
        return new SimpleScalarParser($this->nodeFactory);
    }

    public function createStreamParser(ParserRegistry $registry): StreamParser
    {
        return new StreamParser($registry);
    }

    public function createValueParser(ParserRegistry $registry): ValueParser
    {
        return new ValueParser($this->consumer, $this->errorHelper, $this->multilineContinuationHelper, $this->nodeFactory, $registry);
    }

    public function getAnchorPostProcessor(): AnchorPostProcessor
    {
        return $this->anchorPostProcessor;
    }

    public function getBlockStructureIdentifier(): BlockStructureIdentifier
    {
        return $this->blockStructureIdentifier ??= new BlockStructureIdentifier(
            $this->getFlowStructureIdentifier(),
            $this->multilineContinuationHelper,
            $this->getNodePropertyIdentifier(),
        );
    }

    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    public function getErrorHelper(): ErrorHelper
    {
        return $this->errorHelper;
    }

    public function getFlowStructureIdentifier(): FlowStructureIdentifier
    {
        return $this->flowStructureIdentifier ??= new FlowStructureIdentifier();
    }

    public function getIndentationHelper(): IndentationHelper
    {
        return $this->indentationHelper;
    }

    public function getKeyIdentifier(): KeyIdentifier
    {
        return $this->keyIdentifier ??= new KeyIdentifier();
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

    public function getNodePropertyIdentifier(): NodePropertyIdentifier
    {
        return $this->nodePropertyIdentifier ??= new NodePropertyIdentifier(
            $this->getFlowStructureIdentifier(),
        );
    }
}
