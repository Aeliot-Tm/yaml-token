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

use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\ParseContext;

final class FlowHost
{
    /**
     * @param \Closure(ParseContext): KeyNode $getFlowEntryKeyNode
     * @param \Closure(ParseContext): bool $isFlowMultilinePlainKeyStart
     * @param \Closure(ParseContext): bool $isScalarFollowedByValueIndicatorInFlow
     * @param \Closure(ParseContext): ValueNode $parseFlowContextValue
     * @param \Closure(ParseContext): MergeInstructionNode $parseMergeInstructionAtCurrentPosition
     */
    public function __construct(
        private readonly \Closure $getFlowEntryKeyNode,
        private readonly \Closure $isFlowMultilinePlainKeyStart,
        private readonly \Closure $isScalarFollowedByValueIndicatorInFlow,
        private readonly \Closure $parseFlowContextValue,
        private readonly \Closure $parseMergeInstructionAtCurrentPosition,
    ) {
    }

    public function getFlowEntryKeyNode(ParseContext $harvester): KeyNode
    {
        return ($this->getFlowEntryKeyNode)($harvester);
    }

    public function isFlowMultilinePlainKeyStart(ParseContext $harvester): bool
    {
        return ($this->isFlowMultilinePlainKeyStart)($harvester);
    }

    public function isScalarFollowedByValueIndicatorInFlow(ParseContext $harvester): bool
    {
        return ($this->isScalarFollowedByValueIndicatorInFlow)($harvester);
    }

    public function parseFlowContextValue(ParseContext $harvester): ValueNode
    {
        return ($this->parseFlowContextValue)($harvester);
    }

    public function parseMergeInstructionAtCurrentPosition(ParseContext $harvester): MergeInstructionNode
    {
        return ($this->parseMergeInstructionAtCurrentPosition)($harvester);
    }
}
