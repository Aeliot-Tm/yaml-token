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
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\KeyIdentifier;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Parser\SubParser\ValueParser;
use Aeliot\YamlToken\Token\Token;

final readonly class SequenceEntryParser implements SubParserInterface
{
    public function __construct(
        private ErrorHelper $errorHelper,
        private FlowStructureIdentifier $flowStructureIdentifier,
        private KeyIdentifier $keyIdentifier,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * Consumes one SEQUENCE_ENTRY token followed by any number of
     * directly adjacent WHITESPACE tokens. Returns the total length
     * in characters (always >= 1). Per YAML 1.2.2 §8.2.1 this
     * combined length is considered part of the indentation of the
     * nested (compact) block collection.
     */
    public function consumeSequenceEntryIndicatorAndSpaces(ParseContext $parseContext, Node $target): int
    {
        $token = $parseContext->tokens->current();
        if (TokenType::SEQUENCE_ENTRY !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('SEQUENCE_ENTRY expected, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $target->addChild($this->nodeFactory->createSimpleNode($token));
        $parseContext->tokens->advance();
        $consumed = \strlen($token->text);

        while (true) {
            $next = $parseContext->tokens->current();
            if (TokenType::WHITESPACE !== $next?->type) {
                break;
            }
            $target->addChild(new WhitespaceNode($next));
            $consumed += \strlen($next->text);
            $parseContext->tokens->advance();
        }

        return $consumed;
    }

    /**
     * YAML 1.2.2 §8.2.1 rule [185] s-l+block-indented(n,c): decides between
     *  - a compact in-line block mapping (rule [195] ns-l-compact-mapping),
     *    when the entry content starts with an implicit YAML key;
     *  - a compact in-line block sequence (rule [186] ns-l-compact-sequence),
     *    when the entry content starts with another '-' on the same line
     *    (Example 8.15);
     *  - a generic block / flow / scalar node (delegated to {@see ValueParser::parseValue()}).
     *
     * $compactIndent is the column of the entry's first content character,
     * i.e. (indent of '-') + length('-') + length of WHITESPACE tokens
     * that follow '-'. Per §8.2.1 this length defines the indentation
     * of the nested compact collection.
     */
    public function parseSequenceEntryValue(ParseContext $parseContext, int $parentIndentLen, int $compactIndent): ValueNode
    {
        $token = $parseContext->tokens->current();
        $nodePropertiesFollowedByValueIndicator = false;
        if (null !== $token && $this->isNodePropertyToken($token)) {
            $offset = 0;
            while (true) {
                $peeked = $parseContext->tokens->peek($offset);
                if (null === $peeked || TokenType::NEWLINE === $peeked->type) {
                    break;
                }
                if (TokenType::VALUE_INDICATOR === $peeked->type) {
                    $nodePropertiesFollowedByValueIndicator = true;

                    break;
                }
                if ($this->isNodePropertyToken($peeked) || TokenType::WHITESPACE === $peeked->type) {
                    ++$offset;

                    continue;
                }

                break;
            }
        }

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

        return $this->registry->getValueParser()->parseValue($parseContext, $parentIndentLen);
    }

    private function isNodePropertyToken(?Token $token): bool
    {
        if (null === $token) {
            return false;
        }

        return \in_array($token->type, [
            TokenType::ANCHOR,
            TokenType::TAG,
        ], true);
    }
}
