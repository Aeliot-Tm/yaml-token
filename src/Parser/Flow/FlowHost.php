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
use Aeliot\YamlToken\Parser\Dto\Harvester;

/**
 * Temporary bridge: provides flow sub-parsers with access to {@see \Aeliot\YamlToken\Parser\Parser}
 * private methods that have not yet been extracted into sub-parsers.
 *
 * Will be removed once all bridged methods are extracted (Commits 15+).
 */
final class FlowHost
{
    /**
     * @param \Closure(Harvester): KeyNode $getFlowEntryKeyNode
     * @param \Closure(Harvester): bool $isFlowMultilinePlainKeyStart
     * @param \Closure(Harvester): bool $isScalarFollowedByValueIndicatorInFlow
     * @param \Closure(Harvester): ValueNode $parseFlowContextValue
     * @param \Closure(Harvester): MergeInstructionNode $parseMergeInstructionAtCurrentPosition
     */
    public function __construct(
        private readonly \Closure $getFlowEntryKeyNode,
        private readonly \Closure $isFlowMultilinePlainKeyStart,
        private readonly \Closure $isScalarFollowedByValueIndicatorInFlow,
        private readonly \Closure $parseFlowContextValue,
        private readonly \Closure $parseMergeInstructionAtCurrentPosition,
    ) {
    }

    public function getFlowEntryKeyNode(Harvester $harvester): KeyNode
    {
        return ($this->getFlowEntryKeyNode)($harvester);
    }

    public function isFlowMultilinePlainKeyStart(Harvester $harvester): bool
    {
        return ($this->isFlowMultilinePlainKeyStart)($harvester);
    }

    public function isScalarFollowedByValueIndicatorInFlow(Harvester $harvester): bool
    {
        return ($this->isScalarFollowedByValueIndicatorInFlow)($harvester);
    }

    public function parseFlowContextValue(Harvester $harvester): ValueNode
    {
        return ($this->parseFlowContextValue)($harvester);
    }

    public function parseMergeInstructionAtCurrentPosition(Harvester $harvester): MergeInstructionNode
    {
        return ($this->parseMergeInstructionAtCurrentPosition)($harvester);
    }
}
