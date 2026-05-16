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
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Driver\BuilderInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\BuilderResultInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Completed;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Delegate;
use Aeliot\YamlToken\Parser\Driver\Frame;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Flow\FlowHost;

/**
 * One flow-sequence entry: flow-node or ns-flow-pair (YAML 1.2.2 §7.4.1).
 */
final class FlowEntryBuilder implements BuilderInterface
{
    public function __construct(
        private readonly FlowHost $host,
    ) {
    }

    public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface
    {
        return $this->finishPostOperand($harvester, $child);
    }

    public function step(Harvester $harvester, Frame $self): BuilderResultInterface
    {
        if ($this->isLegacyFlowPairEntryStart($harvester)) {
            return $this->parseLegacyFlowPair($harvester);
        }

        $token = $harvester->tokens->current();
        if (TokenType::FLOW_SEQUENCE_START === $token?->type) {
            $inner = new FlowSequenceNode();
            $inner->addChild($this->host->createSyntaxTokenNode($token));
            $harvester->tokens->advance();

            return new Delegate(new Frame(
                new FlowSequenceBuilder($this->host),
                $inner,
            ));
        }

        if (TokenType::FLOW_MAPPING_START === $token?->type) {
            return $this->finishPostOperand($harvester, $this->host->parseFlowMapping($harvester));
        }

        return new Delegate(new Frame(
            new FlowOperandBuilder($this->host),
            new ValueNode(),
        ));
    }

    private function completeOperandAsValue(Node $operand): BuilderResultInterface
    {
        if ($operand instanceof ValueNode) {
            return new Completed($operand);
        }

        $valueNode = new ValueNode();
        $valueNode->addChild($operand);

        return new Completed($valueNode);
    }

    private function finishPostOperand(Harvester $harvester, Node $operand): BuilderResultInterface
    {
        if (!$this->peekFlowPairColon($harvester)) {
            return $this->completeOperandAsValue($operand);
        }

        $couple = new KeyValueCoupleNode();
        $keyNode = new KeyNode();
        $this->promoteOperandToKey($operand, $keyNode);
        $couple->setKey($keyNode);

        if (!$this->host->tryConsumeFlowMappingValueIndicator($harvester, $couple)) {
            throw new UnexpectedStateException('Expected VALUE_INDICATOR after flow complex key');
        }

        if ($this->isAtFlowSequenceEntryBoundary($harvester)) {
            $couple->setValue(new ValueNode());
        } else {
            $couple->setValue($this->host->parseFlowContextValue($harvester));
        }

        $this->host->postProcessKeyValueCouple($harvester, $couple);

        return $this->completeOperandAsValue($couple);
    }

    /**
     * YAML 1.2.2 §7.4.1: a flow-pair value may be empty (e-node, rule [149] / [153]).
     * Peeks through WHITESPACE/COMMENT/NEWLINE for the next entry / collection close
     * so layout between {@code :} and the boundary stays attached to the surrounding
     * {@see FlowSequenceBuilder} (rule [80] s-l-comments inside flow context).
     */
    private function isAtFlowSequenceEntryBoundary(Harvester $harvester): bool
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

            return \in_array($peeked->type, [TokenType::FLOW_ENTRY, TokenType::FLOW_SEQUENCE_END], true);
        }
    }

    private function isLegacyFlowPairEntryStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::EXPLICIT_KEY_INDICATOR === $token?->type) {
            return true;
        }
        if (TokenType::VALUE_INDICATOR === $token?->type) {
            return true;
        }

        return $this->host->isScalarFollowedByValueIndicatorInFlow($harvester);
    }

    private function parseLegacyFlowPair(Harvester $harvester): BuilderResultInterface
    {
        $couple = new KeyValueCoupleNode();
        $couple->setKey($this->host->getFlowEntryKeyNode($harvester));
        $this->host->appendFlowKeyMultilinePlainScalarContinuations($harvester, $couple->getKey());

        $this->host->tryConsumeFlowMappingValueIndicator($harvester, $couple);

        if ($this->isAtFlowSequenceEntryBoundary($harvester)) {
            $couple->setValue(new ValueNode());
        } else {
            $couple->setValue($this->host->parseFlowContextValue($harvester));
        }

        $this->host->postProcessKeyValueCouple($harvester, $couple);

        return $this->completeOperandAsValue($couple);
    }

    private function peekFlowPairColon(Harvester $harvester): bool
    {
        $offset = 0;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }
            if (
                TokenType::WHITESPACE === $peeked->type
                || TokenType::COMMENT === $peeked->type
                || TokenType::NEWLINE === $peeked->type
            ) {
                ++$offset;
                continue;
            }

            return TokenType::VALUE_INDICATOR === $peeked->type;
        }
    }

    private function promoteOperandToKey(Node $operand, KeyNode $keyNode): void
    {
        if ($operand instanceof FlowSequenceNode || $operand instanceof FlowMappingNode) {
            $keyNode->setName($operand);

            return;
        }

        if (!$operand instanceof ValueNode) {
            throw new UnexpectedStateException(\sprintf('Unexpected operand for flow pair key: %s', $operand::class));
        }

        $valueNode = $operand;
        if (null !== ($properties = $valueNode->getProperties())) {
            $keyNode->setProperties($properties);
        }
        if (null !== ($flowMapping = $valueNode->getFlowMapping())) {
            $keyNode->setName($flowMapping);
        } elseif (null !== ($flowSequence = $valueNode->getFlowSequence())) {
            $keyNode->setName($flowSequence);
        } elseif (null !== ($scalar = $valueNode->getScalar())) {
            $keyNode->setName($scalar);
        } elseif (null !== ($multiline = $valueNode->getMultilinePlainScalar())) {
            $keyNode->setName($multiline);
        } elseif (null !== ($alias = $valueNode->getAlias())) {
            $keyNode->setName($alias);
        }
    }
}
