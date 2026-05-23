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

namespace Aeliot\YamlToken\Parser\SubParser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Token\Token;

final readonly class ValueParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * @param int $parentIndentLen Key-line indent length (spaces),
     *                             {@see EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value} at bare document root (YAML 1.2.2 rule [211]),
     *                             or {@see EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value} for flow / merge RHS values.
     */
    public function parseValue(ParseContext $parseContext, int $parentIndentLen): ValueNode
    {
        $valueNode = new ValueNode();

        $this->registry->getNodePropertiesParser()->collectValueProperties($parseContext, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $parseContext->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }

        $this->consumer->collectSpaceAndComments($parseContext->tokens, $valueNode);

        $token = $parseContext->tokens->current();
        if (
            null !== $token
            && TokenType::NEWLINE === $token->type
            && EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen
        ) {
            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $valueNode);
        }

        $this->parseValuePrimaryPayload($parseContext, $valueNode, $parentIndentLen);

        // Trailing s-separate / s-l-comments before ',', ']', or '}' belong to the enclosing
        // FlowSequenceBuilder / FlowMappingBuilder (YAML 1.2.2 §6.3, §7.1), not this ValueNode.
        if (EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value !== $parentIndentLen) {
            $this->consumer->collectSpaceAndComments($parseContext->tokens, $valueNode);
        }

        return $valueNode;
    }

    /**
     * YAML 1.2.2 §7.2 e-node / §7.4: in flow contexts, scalar content may be empty right
     * after c-ns-properties (tag/anchor) — the next ',' / '}' / ']' terminates the entry.
     */
    private function isFlowEmptyValueTerminator(Token $token, int $parentIndentLen): bool
    {
        return EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen
            && \in_array($token->type, [
                TokenType::FLOW_ENTRY,
                TokenType::FLOW_MAPPING_END,
                TokenType::FLOW_SEQUENCE_END,
            ], true);
    }

    private function parseBlockScalarPayload(ParseContext $parseContext, ValueNode $valueNode, int $parentIndentLen): void
    {
        if (null === $parseContext->tokens->current()) {
            return;
        }

        $this->registry->getBlockScalarParser()->consumeBlockScalarValue(
            $parseContext->tokens,
            $valueNode,
            $parentIndentLen,
        );
    }

    private function parseNewlinePayload(ParseContext $parseContext, ValueNode $valueNode, int $parentIndentLen): void
    {
        if (EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen) {
            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $valueNode);
            $this->parseValuePrimaryPayload($parseContext, $valueNode, $parentIndentLen);

            return;
        }

        $this->registry->getIndentedBlockValueParser()->parseIndentedBlockValue($parseContext, $valueNode, $parentIndentLen);
    }

    private function parsePlainScalarPayload(
        ParseContext $parseContext,
        ValueNode $valueNode,
        int $parentIndentLen,
        Token $token,
    ): void {
        $multilinePlainScalarParser = $this->registry->getMultilinePlainScalarParser();

        if (
            TokenType::PLAIN_SCALAR === $token->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($parseContext->tokens, 1, $parentIndentLen)
        ) {
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($this->nodeFactory->createScalarNode($token));
            $parseContext->tokens->advance();
            $multilinePlainScalarParser->appendMultilinePlainScalarContinuations($parseContext->tokens, $multiline, $parentIndentLen);
            $valueNode->addChild($multiline);
        } elseif (
            TokenType::PLAIN_SCALAR === $token->type
            && EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen
        ) {
            $head = $this->nodeFactory->createScalarNode($token);
            $parseContext->tokens->advance();
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($head);
            $consumedAny = false;
            while ($multilinePlainScalarParser->tryConsumeFlowValueMultilinePlainScalarLine($parseContext->tokens, $multiline)) {
                $consumedAny = true;
            }
            $valueNode->addChild($consumedAny ? $multiline : $head);
        } else {
            $valueNode->addChild($this->registry->getSimpleScalarParser()->parse($parseContext));
        }
    }

    /**
     * Parses the main value payload (block scalar, block-after-newline, scalars, aliases, compact collections, flow nodes).
     */
    private function parseValuePrimaryPayload(ParseContext $parseContext, ValueNode $valueNode, int $parentIndentLen): void
    {
        $token = $parseContext->tokens->current();
        if (null === $token) {
            return;
        }

        if ($this->isFlowEmptyValueTerminator($token, $parentIndentLen)) {
            return;
        }

        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $this->parseBlockScalarPayload($parseContext, $valueNode, $parentIndentLen);
        } elseif (TokenType::NEWLINE === $token->type) {
            $this->parseNewlinePayload($parseContext, $valueNode, $parentIndentLen);
        } elseif ($token->type->isScalar()) {
            $this->parsePlainScalarPayload($parseContext, $valueNode, $parentIndentLen, $token);
        } elseif (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $parseContext->anchorsRegistry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException($this->errorHelper->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
            }
            $aliasNode->setAnchor($anchor);
            $valueNode->addChild($aliasNode);
            $parseContext->tokens->advance();
        } elseif (TokenType::SEQUENCE_ENTRY === $token->type) {
            $valueNode->addChild($this->registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($parseContext, $token->column - 1));
        } elseif (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $valueNode->addChild($this->registry->getFlowSequenceParser()->parse($parseContext));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->registry->getFlowMappingParser()->parse($parseContext));
        } else {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected type while parsing of value: %s', $token->type->value), $token));
        }
    }
}
