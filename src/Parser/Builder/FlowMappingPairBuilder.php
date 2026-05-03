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

namespace Aeliot\YamlToken\Parser\Builder;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Driver\BuilderInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\BuilderResultInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Completed;
use Aeliot\YamlToken\Parser\Driver\Frame;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Flow\FlowHost;

/**
 * Single c-flow-map-entry / ns-flow-map-implicit-entry (YAML 1.2.2 §7.4.2).
 *
 * Builds key via {@see FlowHost::getFlowEntryKeyNode()}, then optionally consumes ':' and
 * delegates value parsing through {@see FlowHost::parseFlowContextValue()}.
 */
final class FlowMappingPairBuilder implements BuilderInterface
{
    public function __construct(
        private readonly FlowHost $host,
    ) {
    }

    public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface
    {
        throw new UnexpectedStateException('FlowMappingPairBuilder does not delegate');
    }

    public function step(Harvester $harvester, Frame $self): BuilderResultInterface
    {
        $couple = $self->node;
        if (!$couple instanceof KeyValueCoupleNode) {
            throw new UnexpectedStateException('FlowMappingPairBuilder frame node must be KeyValueCoupleNode');
        }

        $couple->setKey($this->host->getFlowEntryKeyNode($harvester));
        $this->host->appendFlowKeyMultilinePlainScalarContinuations($harvester, $couple->getKey());

        if ($this->host->tryConsumeFlowMappingValueIndicator($harvester, $couple)) {
            if ($this->isAtFlowMappingEntryBoundary($harvester)) {
                $couple->setValue(new ValueNode());
            } else {
                $couple->setValue($this->host->parseFlowContextValue($harvester));
            }
        }

        $this->host->postProcessKeyValueCouple($harvester, $couple);

        return new Completed($couple);
    }

    /**
     * YAML 1.2.2 §7.4.2: a flow-mapping value may be empty (e-node, rule [148]).
     * Peeks through WHITESPACE/COMMENT/NEWLINE for the next entry / collection close
     * so layout between {@code :} and the boundary stays attached to the surrounding
     * {@see FlowMappingBuilder} (rule [80] s-l-comments inside flow context).
     */
    private function isAtFlowMappingEntryBoundary(Harvester $harvester): bool
    {
        $offset = 0;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return true;
            }
            if (
                TokenType::WHITESPACE === $peeked->type
                || TokenType::COMMENT === $peeked->type
                || TokenType::NEWLINE === $peeked->type
            ) {
                ++$offset;
                continue;
            }

            return \in_array($peeked->type, [TokenType::FLOW_ENTRY, TokenType::FLOW_MAPPING_END], true);
        }
    }
}
