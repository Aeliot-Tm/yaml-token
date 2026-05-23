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
use Aeliot\YamlToken\Parser\Helper\AliasResolver;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\BlockCollectionLoopHelper;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\FlowCollectionHelper;
use Aeliot\YamlToken\Parser\Helper\FlowMultilinePlainScalarHelper;
use Aeliot\YamlToken\Parser\Helper\FlowValueIndicatorConsumer;
use Aeliot\YamlToken\Parser\Helper\Identifier\BlockStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\KeyIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\SequenceIdentifier;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Parser\ParserRegistry;
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

final class ParserAssembler
{
    private ?AliasResolver $aliasResolver = null;
    private ?BlockCollectionLoopHelper $blockCollectionLoopHelper = null;
    private ?BlockStructureIdentifier $blockStructureIdentifier = null;
    private ?FlowCollectionHelper $flowCollectionHelper = null;
    private ?FlowStructureIdentifier $flowStructureIdentifier = null;
    private ?FlowValueIndicatorConsumer $flowValueIndicatorConsumer = null;
    private ?KeyIdentifier $keyIdentifier = null;
    private ?NodePropertyIdentifier $nodePropertyIdentifier = null;
    private ?SequenceIdentifier $sequenceIdentifier = null;

    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private IndentationHelper $indentationHelper,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    public function createBlockMappingParser(ParserRegistry $registry): BlockMappingParser
    {
        return new BlockMappingParser(
            $this->getBlockCollectionLoopHelper(),
            $this->getBlockStructureIdentifier(),
            $this->errorHelper,
            $registry,
        );
    }

    public function createBlockScalarParser(ParserRegistry $registry): BlockScalarParser
    {
        return new BlockScalarParser(
            $this->consumer,
            $this->errorHelper,
            $registry->getMultilinePlainScalarParser(),
            $this->nodeFactory,
            $this->peekOffsetHelper,
        );
    }

    public function createBlockSequenceParser(ParserRegistry $registry): BlockSequenceParser
    {
        return new BlockSequenceParser(
            $this->getBlockCollectionLoopHelper(),
            $this->errorHelper,
            $this->getSequenceIdentifier(),
            $registry,
        );
    }

    public function createCompactBlockMappingParser(ParserRegistry $registry): CompactBlockMappingParser
    {
        return new CompactBlockMappingParser(
            $this->getBlockCollectionLoopHelper(),
            $this->getBlockStructureIdentifier(),
            $registry,
        );
    }

    public function createCompactBlockSequenceParser(ParserRegistry $registry): CompactBlockSequenceParser
    {
        return new CompactBlockSequenceParser(
            $this->getBlockCollectionLoopHelper(),
            $this->getSequenceIdentifier(),
            $registry,
        );
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
            $this->getFlowValueIndicatorConsumer(),
            $this->getKeyIdentifier(),
            $registry,
        );
    }

    public function createFlowMappingPairParser(ParserRegistry $registry): FlowMappingPairParser
    {
        return new FlowMappingPairParser(
            $this->anchorPostProcessor,
            $this->getFlowStructureIdentifier(),
            $this->getFlowValueIndicatorConsumer(),
            $registry,
        );
    }

    public function createFlowMappingParser(ParserRegistry $registry): FlowMappingParser
    {
        return new FlowMappingParser($this->getFlowCollectionHelper(), $registry);
    }

    public function createFlowMultilinePlainScalarHelper(): FlowMultilinePlainScalarHelper
    {
        return new FlowMultilinePlainScalarHelper($this->nodeFactory, $this->peekOffsetHelper);
    }

    public function createFlowSequenceParser(ParserRegistry $registry): FlowSequenceParser
    {
        return new FlowSequenceParser($this->getFlowCollectionHelper(), $registry);
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
            $this->getAliasResolver(),
            $this->errorHelper,
            $this->lookAheadHelper,
            $this->multilineContinuationHelper,
            $registry->getNodePropertiesParser(),
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

    public function createMergeInstructionParser(ParserRegistry $registry): MergeInstructionParser
    {
        return new MergeInstructionParser($this->consumer, $this->errorHelper, $this->nodeFactory, $registry);
    }

    public function createNodePropertiesParser(): NodePropertiesParser
    {
        return new NodePropertiesParser($this->errorHelper);
    }

    public function createSequenceEntryParser(ParserRegistry $registry): SequenceEntryParser
    {
        return new SequenceEntryParser(
            $this->errorHelper,
            $this->getFlowStructureIdentifier(),
            $this->getKeyIdentifier(),
            $this->nodeFactory,
            $this->getNodePropertyIdentifier(),
            $registry,
        );
    }

    public function createMultilinePlainScalarParser(ParserRegistry $registry): MultilinePlainScalarParser
    {
        return new MultilinePlainScalarParser($this->errorHelper, $this->multilineContinuationHelper, $this->nodeFactory, $this->peekOffsetHelper, $registry);
    }

    public function createSimpleScalarParser(ParserRegistry $registry): SimpleScalarParser
    {
        return new SimpleScalarParser($this->nodeFactory);
    }

    public function createStreamParser(ParserRegistry $registry): StreamParser
    {
        return new StreamParser($registry);
    }

    public function createTagDirectiveParser(): TagDirectiveParser
    {
        return new TagDirectiveParser($this->consumer, $this->errorHelper, $this->nodeFactory);
    }

    public function createValueParser(ParserRegistry $registry): ValueParser
    {
        return new ValueParser($this->getAliasResolver(), $this->consumer, $this->errorHelper, $this->multilineContinuationHelper, $this->nodeFactory, $registry);
    }

    public function createYamlDirectiveParser(): YamlDirectiveParser
    {
        return new YamlDirectiveParser($this->consumer, $this->errorHelper, $this->nodeFactory);
    }

    public function getAliasResolver(): AliasResolver
    {
        return $this->aliasResolver ??= new AliasResolver($this->errorHelper);
    }

    public function getBlockCollectionLoopHelper(): BlockCollectionLoopHelper
    {
        return $this->blockCollectionLoopHelper ??= new BlockCollectionLoopHelper(
            $this->consumer,
            $this->indentationHelper,
            $this->lookAheadHelper,
        );
    }

    public function getBlockStructureIdentifier(): BlockStructureIdentifier
    {
        return $this->blockStructureIdentifier ??= new BlockStructureIdentifier(
            $this->getFlowStructureIdentifier(),
            $this->multilineContinuationHelper,
            $this->getNodePropertyIdentifier(),
            $this->getSequenceIdentifier(),
        );
    }

    public function getFlowCollectionHelper(): FlowCollectionHelper
    {
        return $this->flowCollectionHelper ??= new FlowCollectionHelper($this->consumer, $this->errorHelper, $this->nodeFactory);
    }

    public function getFlowStructureIdentifier(): FlowStructureIdentifier
    {
        return $this->flowStructureIdentifier ??= new FlowStructureIdentifier($this->peekOffsetHelper);
    }

    public function getFlowValueIndicatorConsumer(): FlowValueIndicatorConsumer
    {
        return $this->flowValueIndicatorConsumer ??= new FlowValueIndicatorConsumer($this->consumer);
    }

    public function getKeyIdentifier(): KeyIdentifier
    {
        return $this->keyIdentifier ??= new KeyIdentifier();
    }

    public function getNodePropertyIdentifier(): NodePropertyIdentifier
    {
        return $this->nodePropertyIdentifier ??= new NodePropertyIdentifier(
            $this->getFlowStructureIdentifier(),
        );
    }

    public function getSequenceIdentifier(): SequenceIdentifier
    {
        return $this->sequenceIdentifier ??= new SequenceIdentifier();
    }
}
