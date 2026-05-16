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

namespace Aeliot\YamlToken\Parser\Flow;

use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Token\Token;

/**
 * Bridges flow-collection builders to {@see \Aeliot\YamlToken\Parser\Parser} private methods via closures.
 */
final class FlowHost
{
    /**
     * @param \Closure(Harvester, Node): void $collectSpaceAndComments
     * @param \Closure(Token): SyntaxTokenNode $createSyntaxTokenNode
     * @param \Closure(Harvester): KeyNode $getFlowEntryKeyNode
     * @param \Closure(Harvester): bool $isScalarFollowedByValueIndicatorInFlow
     * @param \Closure(Harvester): ValueNode $parseFlowContextValue
     * @param \Closure(Harvester): FlowMappingNode $parseFlowMapping
     * @param \Closure(Harvester): MergeInstructionNode $parseMergeInstructionAtCurrentPosition
     * @param \Closure(Harvester, KeyValueCoupleNode): void $postProcessKeyValueCouple
     * @param \Closure(Harvester, KeyValueCoupleNode): bool $tryConsumeFlowMappingValueIndicator
     */
    public function __construct(
        private readonly \Closure $collectSpaceAndComments,
        private readonly \Closure $createSyntaxTokenNode,
        private readonly \Closure $getFlowEntryKeyNode,
        private readonly \Closure $isScalarFollowedByValueIndicatorInFlow,
        private readonly \Closure $parseFlowContextValue,
        private readonly \Closure $parseFlowMapping,
        private readonly \Closure $parseMergeInstructionAtCurrentPosition,
        private readonly \Closure $postProcessKeyValueCouple,
        private readonly \Closure $tryConsumeFlowMappingValueIndicator,
    ) {
    }

    public function collectSpaceAndComments(Harvester $harvester, Node $root): void
    {
        ($this->collectSpaceAndComments)($harvester, $root);
    }

    public function createSyntaxTokenNode(Token $token): SyntaxTokenNode
    {
        return ($this->createSyntaxTokenNode)($token);
    }

    public function getFlowEntryKeyNode(Harvester $harvester): KeyNode
    {
        return ($this->getFlowEntryKeyNode)($harvester);
    }

    public function isScalarFollowedByValueIndicatorInFlow(Harvester $harvester): bool
    {
        return ($this->isScalarFollowedByValueIndicatorInFlow)($harvester);
    }

    public function parseFlowContextValue(Harvester $harvester): ValueNode
    {
        return ($this->parseFlowContextValue)($harvester);
    }

    public function parseFlowMapping(Harvester $harvester): FlowMappingNode
    {
        return ($this->parseFlowMapping)($harvester);
    }

    public function parseMergeInstructionAtCurrentPosition(Harvester $harvester): MergeInstructionNode
    {
        return ($this->parseMergeInstructionAtCurrentPosition)($harvester);
    }

    public function postProcessKeyValueCouple(Harvester $harvester, KeyValueCoupleNode $couple): void
    {
        ($this->postProcessKeyValueCouple)($harvester, $couple);
    }

    public function tryConsumeFlowMappingValueIndicator(Harvester $harvester, KeyValueCoupleNode $couple): bool
    {
        return ($this->tryConsumeFlowMappingValueIndicator)($harvester, $couple);
    }
}
