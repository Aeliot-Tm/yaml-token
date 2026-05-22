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

use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Assembler\ParserAssembler;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Flow\FlowHost;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;

final class ParserBuilder
{
    public function createParser(): Parser
    {
        $assembler = $this->createAssembler();
        $parserRegistry = new ParserRegistry($assembler);

        $this->populateBlockParserBridge($parserRegistry, $assembler);
        $this->populateDocumentParserBridge($parserRegistry, $assembler);
        $this->populateFlowHost($parserRegistry, $assembler);

        return new Parser($parserRegistry);
    }

    private function createAssembler(): ParserAssembler
    {
        $anchorPostProcessor = new AnchorPostProcessor();
        $errorHelper = new ErrorHelper();
        $indentationHelper = new IndentationHelper($errorHelper);
        $multilineContinuationHelper = new MultilineContinuationHelper();
        $nodeFactory = new NodeFactory();
        $consumer = new Consumer($nodeFactory);
        $lookAheadHelper = new LookAheadHelper($consumer);

        return new ParserAssembler(
            $anchorPostProcessor,
            $consumer,
            $errorHelper,
            $indentationHelper,
            $lookAheadHelper,
            $multilineContinuationHelper,
            $nodeFactory,
        );
    }

    private function populateBlockParserBridge(ParserRegistry $registry, ParserAssembler $assembler): void
    {
        $registry->setBlockParserBridge(
            function (Harvester $h, ValueNode $v) use ($registry): void {
                $registry->getNodePropertiesParser()->collectValueProperties($h, $v);
            },
            fn (Harvester $h, int $offset): bool => $assembler->getFlowStructureIdentifier()->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($h, $offset),
            fn (Harvester $h): bool => $assembler->getBlockStructureIdentifier()->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $assembler->getBlockStructureIdentifier()->isKeyValueCoupleStartAllowingNodeProperties($h),
            fn (Harvester $h, int $offset): bool => $assembler->getNodePropertyIdentifier()->isNodePropertiesFollowedByImplicitKeyFromOffset($h, $offset),
            fn (Harvester $h, bool $allowFlowSeparation = false): bool => $assembler->getKeyIdentifier()->isScalarFollowedByValueIndicator($h, $allowFlowSeparation),
            fn (Harvester $h, int $indent): BlockMappingNode => $registry->getBlockMappingParser()->parseBlockMappingValue($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $registry->getBlockSequenceParser()->parseBlockSequenceValue($h, $indent),
            fn (Harvester $h, int $indent): BlockMappingNode => $registry->getCompactBlockMappingParser()->parseCompactBlockMapping($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($h, $indent),
            fn (Harvester $h): MergeInstructionNode => $registry->getMergeInstructionParser()->parseMergeInstructionAtCurrentPosition($h),
            fn (Harvester $h, int $parentIndentLen): ValueNode => $registry->getValueParser()->parseValue($h, $parentIndentLen),
        );
    }

    private function populateDocumentParserBridge(ParserRegistry $registry, ParserAssembler $assembler): void
    {
        $registry->setDocumentParserBridge(
            fn (Harvester $h): bool => $assembler->getBlockStructureIdentifier()->isBlockScalarStartAtDocumentRoot($h),
            fn (Harvester $h): bool => $assembler->getFlowStructureIdentifier()->isFlowMappingStart($h),
            fn (Harvester $h): bool => $assembler->getFlowStructureIdentifier()->isFlowSequenceStart($h),
            fn (Harvester $h): bool => $assembler->getBlockStructureIdentifier()->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $assembler->getNodePropertyIdentifier()->isNodePropertyAtDocumentRoot($h),
            fn (Harvester $h): bool => $assembler->getBlockStructureIdentifier()->isSequenceStart($h),
        );
    }

    private function populateFlowHost(ParserRegistry $registry, ParserAssembler $assembler): void
    {
        $registry->setFlowHost(new FlowHost(
            fn (Harvester $h): KeyNode => $registry->getKeyParser()->getKeyNode($h),
            fn (Harvester $h): bool => $assembler->getFlowStructureIdentifier()->isFlowMultilinePlainKeyStart($h),
            fn (Harvester $h): bool => $assembler->getKeyIdentifier()->isScalarFollowedByValueIndicator($h, true),
            fn (Harvester $h): ValueNode => $registry->getValueParser()->parseValue($h, EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value),
            fn (Harvester $h): MergeInstructionNode => $registry->getMergeInstructionParser()->parseMergeInstructionAtCurrentPosition($h),
        ));
    }
}
