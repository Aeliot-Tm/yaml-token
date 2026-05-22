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

namespace Aeliot\YamlToken\Parser\SubParser\Flow;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class FlowEntryParser implements SubParserInterface
{
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $harvester): Node
    {
        if ($this->isLegacyFlowPairEntryStart($harvester)) {
            return $this->parseLegacyFlowPair($harvester);
        }

        $token = $harvester->tokens->current();

        if (TokenType::FLOW_SEQUENCE_START === $token?->type) {
            return $this->finishPostOperand(
                $harvester,
                $this->registry->getFlowSequenceParser()->parse($harvester),
            );
        }

        if (TokenType::FLOW_MAPPING_START === $token?->type) {
            return $this->finishPostOperand(
                $harvester,
                $this->registry->getFlowMappingParser()->parse($harvester),
            );
        }

        return $this->finishPostOperand(
            $harvester,
            $this->registry->getFlowHost()->parseFlowContextValue($harvester),
        );
    }

    private function completeOperandAsValue(Node $operand): ValueNode
    {
        if ($operand instanceof ValueNode) {
            return $operand;
        }

        $valueNode = new ValueNode();
        $valueNode->addChild($operand);

        return $valueNode;
    }

    private function finishPostOperand(ParseContext $harvester, Node $operand): ValueNode
    {
        if (!$this->peekFlowPairColon($harvester)) {
            return $this->completeOperandAsValue($operand);
        }

        $couple = new KeyValueCoupleNode();
        $keyNode = new KeyNode();
        $this->promoteOperandToKey($operand, $keyNode);
        $couple->addChild($keyNode);

        if (!$this->registry->getFlowMappingPairParser()->tryConsumeFlowMappingValueIndicator($harvester, $couple)) {
            throw new UnexpectedStateException('Expected VALUE_INDICATOR after flow complex key');
        }

        if ($this->isAtFlowSequenceEntryBoundary($harvester)) {
            $couple->addChild(new ValueNode());
        } else {
            $couple->addChild($this->registry->getFlowHost()->parseFlowContextValue($harvester));
        }

        $this->anchorPostProcessor->postProcessKeyValueCouple($harvester->anchorsRegistry, $couple);

        return $this->completeOperandAsValue($couple);
    }

    private function isAtFlowSequenceEntryBoundary(ParseContext $harvester): bool
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

    private function isLegacyFlowPairEntryStart(ParseContext $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::EXPLICIT_KEY_INDICATOR === $token?->type) {
            return true;
        }
        if (TokenType::VALUE_INDICATOR === $token?->type) {
            return true;
        }

        return $this->registry->getFlowHost()->isScalarFollowedByValueIndicatorInFlow($harvester)
            || $this->registry->getFlowHost()->isFlowMultilinePlainKeyStart($harvester);
    }

    private function parseLegacyFlowPair(ParseContext $harvester): ValueNode
    {
        $couple = new KeyValueCoupleNode();
        $couple->addChild($this->registry->getFlowHost()->getFlowEntryKeyNode($harvester));

        $this->registry->getFlowMappingPairParser()->tryConsumeFlowMappingValueIndicator($harvester, $couple);

        if ($this->isAtFlowSequenceEntryBoundary($harvester)) {
            $couple->addChild(new ValueNode());
        } else {
            $couple->addChild($this->registry->getFlowHost()->parseFlowContextValue($harvester));
        }

        $this->anchorPostProcessor->postProcessKeyValueCouple($harvester->anchorsRegistry, $couple);

        return $this->completeOperandAsValue($couple);
    }

    private function peekFlowPairColon(ParseContext $harvester): bool
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
            $keyNode->addChild($properties);
        }
        $payload = $valueNode->getPayload();
        if (
            $payload instanceof AliasNode
            || $payload instanceof FlowMappingNode
            || $payload instanceof FlowSequenceNode
            || $payload instanceof MultilinePlainScalarNode
            || $payload instanceof ScalarNode
        ) {
            $keyNode->setName($payload);
        }
    }
}
