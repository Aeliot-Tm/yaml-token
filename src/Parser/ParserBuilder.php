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
            function (ParseContext $parseContext, ValueNode $v) use ($registry): void {
                $registry->getNodePropertiesParser()->collectValueProperties($parseContext, $v);
            },
            fn (ParseContext $parseContext, int $offset): bool => $assembler->getFlowStructureIdentifier()->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($parseContext, $offset),
            fn (ParseContext $parseContext): bool => $assembler->getBlockStructureIdentifier()->isKeyValueCoupleStart($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getBlockStructureIdentifier()->isKeyValueCoupleStartAllowingNodeProperties($parseContext),
            fn (ParseContext $parseContext, int $offset): bool => $assembler->getNodePropertyIdentifier()->isNodePropertiesFollowedByImplicitKeyFromOffset($parseContext, $offset),
            fn (ParseContext $parseContext, bool $allowFlowSeparation = false): bool => $assembler->getKeyIdentifier()->isScalarFollowedByValueIndicator($parseContext, $allowFlowSeparation),
            fn (ParseContext $parseContext, int $indent): BlockMappingNode => $registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, $indent),
            fn (ParseContext $parseContext, int $indent): BlockSequenceNode => $registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, $indent),
            fn (ParseContext $parseContext, int $indent): BlockMappingNode => $registry->getCompactBlockMappingParser()->parseCompactBlockMapping($parseContext, $indent),
            fn (ParseContext $parseContext, int $indent): BlockSequenceNode => $registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($parseContext, $indent),
            fn (ParseContext $parseContext): MergeInstructionNode => $registry->getMergeInstructionParser()->parseMergeInstructionAtCurrentPosition($parseContext),
            fn (ParseContext $parseContext, int $parentIndentLen): ValueNode => $registry->getValueParser()->parseValue($parseContext, $parentIndentLen),
        );
    }

    private function populateDocumentParserBridge(ParserRegistry $registry, ParserAssembler $assembler): void
    {
        $registry->setDocumentParserBridge(
            fn (ParseContext $parseContext): bool => $assembler->getBlockStructureIdentifier()->isBlockScalarStartAtDocumentRoot($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getFlowStructureIdentifier()->isFlowMappingStart($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getFlowStructureIdentifier()->isFlowSequenceStart($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getBlockStructureIdentifier()->isKeyValueCoupleStart($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getNodePropertyIdentifier()->isNodePropertyAtDocumentRoot($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getBlockStructureIdentifier()->isSequenceStart($parseContext),
        );
    }

    private function populateFlowHost(ParserRegistry $registry, ParserAssembler $assembler): void
    {
        $registry->setFlowHost(new FlowHost(
            fn (ParseContext $parseContext): KeyNode => $registry->getKeyParser()->getKeyNode($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getFlowStructureIdentifier()->isFlowMultilinePlainKeyStart($parseContext),
            fn (ParseContext $parseContext): bool => $assembler->getKeyIdentifier()->isScalarFollowedByValueIndicator($parseContext, true),
            fn (ParseContext $parseContext): ValueNode => $registry->getValueParser()->parseValue($parseContext, EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value),
            fn (ParseContext $parseContext): MergeInstructionNode => $registry->getMergeInstructionParser()->parseMergeInstructionAtCurrentPosition($parseContext),
        ));
    }
}
