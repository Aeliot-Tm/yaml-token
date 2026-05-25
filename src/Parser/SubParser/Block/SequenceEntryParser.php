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

namespace Aeliot\YamlToken\Parser\SubParser\Block;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\KeyIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Parser\SubParser\Consumer;

final readonly class SequenceEntryParser
{
    public function __construct(
        private Consumer $consumer,
        private FlowStructureIdentifier $flowStructureIdentifier,
        private KeyIdentifier $keyIdentifier,
        private NodePropertyIdentifier $nodePropertyIdentifier,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * Parses one block sequence entry: consumes the SEQUENCE_ENTRY indicator
     * with any trailing whitespace, then parses the entry value, and appends
     * all resulting nodes to $target.
     *
     * $indentLen is the column (0-based) of the '-' indicator, which defines
     * the indentation context for the nested content per YAML 1.2.2 §8.2.1.
     */
    public function parseSequenceEntry(ParseContext $parseContext, Node $target, int $indentLen): void
    {
        $compactIndent = $indentLen + $this->consumeSequenceEntryIndicatorAndSpaces($parseContext, $target);
        $target->addChild($this->parseSequenceEntryValue($parseContext, IndentContext::createForBlock($indentLen), $compactIndent));
    }

    /**
     * Consumes one SEQUENCE_ENTRY token followed by any number of
     * directly adjacent WHITESPACE tokens. Returns the total length
     * in characters (always >= 1). Per YAML 1.2.2 §8.2.1 this
     * combined length is considered part of the indentation of the
     * nested (compact) block collection.
     */
    private function consumeSequenceEntryIndicatorAndSpaces(ParseContext $parseContext, Node $target): int
    {
        return $this->consumer->grab($parseContext->tokens, $target, TokenType::SEQUENCE_ENTRY)
            + $this->consumer->collectWhitespace($parseContext->tokens, $target);
    }

    /**
     * YAML 1.2.2 §8.2.1 rule [185] s-l+block-indented(n,c): decides between
     *  - a compact in-line block mapping (rule [195] ns-l-compact-mapping),
     *    when the entry content starts with an implicit YAML key;
     *  - a compact in-line block sequence (rule [186] ns-l-compact-sequence),
     *    when the entry content starts with another '-' on the same line
     *    (Example 8.15);
     *  - a generic block / flow / scalar node (delegated to ValueParser::parseValue()).
     *
     * $compactIndent is the column of the entry's first content character,
     * i.e. (indent of '-') + length('-') + length of WHITESPACE tokens
     * that follow '-'. Per §8.2.1 this length defines the indentation
     * of the nested compact collection.
     */
    private function parseSequenceEntryValue(ParseContext $parseContext, IndentContext $parentIndent, int $compactIndent): ValueNode
    {
        $token = $parseContext->tokens->current();
        $nodePropertiesFollowedByValueIndicator = null !== $token
            && $this->nodePropertyIdentifier->isNodePropertyToken($token)
            && $this->nodePropertyIdentifier->isNodePropertiesFollowedByImplicitKeyFromOffset($parseContext, 0);

        if (
            $this->keyIdentifier->isScalarFollowedByValueIndicator($parseContext)
            || TokenType::EXPLICIT_KEY_INDICATOR === $token?->type
            || TokenType::VALUE_INDICATOR === $token?->type
            || $nodePropertiesFollowedByValueIndicator
        ) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->registry->getCompactBlockMappingParser()->parseCompactBlockMapping($parseContext, $compactIndent));

            return $valueNode;
        }

        if (TokenType::SEQUENCE_ENTRY === $parseContext->tokens->current()?->type) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($parseContext, $compactIndent));

            return $valueNode;
        }

        $flowOpen = $parseContext->tokens->current();
        if (
            \in_array($flowOpen?->type, [TokenType::FLOW_SEQUENCE_START, TokenType::FLOW_MAPPING_START], true)
            && $this->flowStructureIdentifier->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($parseContext, 0)
        ) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->registry->getCompactBlockMappingParser()->parseCompactBlockMapping($parseContext, $compactIndent));

            return $valueNode;
        }

        return $this->registry->getValueParser()->parseValue($parseContext, $parentIndent);
    }
}
