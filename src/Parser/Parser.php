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

use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Flow\FlowHost;
use Aeliot\YamlToken\Parser\Helper\Identifier\BlockStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\KeyIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Token\TokenStream;

final class Parser
{
    public function __construct(
        private BlockStructureIdentifier $blockStructureIdentifier,
        private FlowStructureIdentifier $flowStructureIdentifier,
        private KeyIdentifier $keyIdentifier,
        private NodePropertyIdentifier $nodePropertyIdentifier,
        private ParserRegistry $parserRegistry,
    ) {
        $this->parserRegistry->setBlockParserBridge(
            function (Harvester $h, ValueNode $v): void {
                $this->parserRegistry->getNodePropertiesParser()->collectValueProperties($h, $v);
            },
            fn (Harvester $h, int $offset): bool => $this->flowStructureIdentifier->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($h, $offset),
            fn (Harvester $h): bool => $this->blockStructureIdentifier->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $this->blockStructureIdentifier->isKeyValueCoupleStartAllowingNodeProperties($h),
            fn (Harvester $h, int $offset): bool => $this->nodePropertyIdentifier->isNodePropertiesFollowedByImplicitKeyFromOffset($h, $offset),
            fn (Harvester $h, bool $allowFlowSeparation = false): bool => $this->keyIdentifier->isScalarFollowedByValueIndicator($h, $allowFlowSeparation),
            fn (Harvester $h, int $indent): BlockMappingNode => $this->parserRegistry->getBlockMappingParser()->parseBlockMappingValue($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $this->parserRegistry->getBlockSequenceParser()->parseBlockSequenceValue($h, $indent),
            fn (Harvester $h, int $indent): BlockMappingNode => $this->parserRegistry->getCompactBlockMappingParser()->parseCompactBlockMapping($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $this->parserRegistry->getCompactBlockSequenceParser()->parseCompactBlockSequence($h, $indent),
            fn (Harvester $h): MergeInstructionNode => $this->parserRegistry
                ->getMergeInstructionParser()
                ->parseMergeInstructionAtCurrentPosition($h),
            fn (Harvester $h, int $parentIndentLen): ValueNode => $this->parserRegistry->getValueParser()->parseValue($h, $parentIndentLen),
        );

        $this->parserRegistry->setDocumentParserBridge(
            fn (Harvester $h): bool => $this->blockStructureIdentifier->isBlockScalarStartAtDocumentRoot($h),
            fn (Harvester $h): bool => $this->flowStructureIdentifier->isFlowMappingStart($h),
            fn (Harvester $h): bool => $this->flowStructureIdentifier->isFlowSequenceStart($h),
            fn (Harvester $h): bool => $this->blockStructureIdentifier->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $this->nodePropertyIdentifier->isNodePropertyAtDocumentRoot($h),
            fn (Harvester $h): bool => $this->blockStructureIdentifier->isSequenceStart($h),
        );
    }

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    public function parseStream(TokenStream $tokens): StreamNode
    {
        $harvester = new Harvester(new TokenStreamProxy($tokens));
        $harvester->flowHost = $this->createFlowHost();
        $harvester->anchorsRegistry = new AnchorsRegistry();
        $harvester->state = new ParseState();
        $harvester->parseContext = new ParseContext($harvester->tokens, $harvester->anchorsRegistry, $harvester->state);

        return $this->parserRegistry->getStreamParser()->parseStream($harvester);
    }

    private function createFlowHost(): FlowHost
    {
        return new FlowHost(
            fn (Harvester $h): KeyNode => $this->parserRegistry->getKeyParser()->getKeyNode($h),
            fn (Harvester $h): bool => $this->flowStructureIdentifier->isFlowMultilinePlainKeyStart($h),
            fn (Harvester $h): bool => $this->keyIdentifier->isScalarFollowedByValueIndicator($h, true),
            fn (Harvester $h): ValueNode => $this->parserRegistry->getValueParser()->parseValue($h, EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value),
            fn (Harvester $h): MergeInstructionNode => $this->parserRegistry
                ->getMergeInstructionParser()
                ->parseMergeInstructionAtCurrentPosition($h),
        );
    }
}
