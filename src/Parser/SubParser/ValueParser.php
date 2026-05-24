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
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\AliasResolver;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Token\Token;

final readonly class ValueParser
{
    public function __construct(
        private AliasResolver $aliasResolver,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * @param IndentContext $parentIndent Key-line indent context: a real block indent,
     *                                    {@see IndentContext::createForBareDocument()} at bare document root (YAML 1.2.2 rule [211]),
     *                                    or {@see IndentContext::createForFlow()} for flow / merge RHS values.
     */
    public function parseValue(ParseContext $parseContext, IndentContext $parentIndent): ValueNode
    {
        $valueNode = new ValueNode();

        $this->registry->getNodePropertiesParser()->collectProperties($parseContext, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $parseContext->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }

        $this->consumer->collectSpaceAndComments($parseContext->tokens, $valueNode);

        $token = $parseContext->tokens->current();
        if (
            null !== $token
            && TokenType::NEWLINE === $token->type
            && $parentIndent->isFlowCollection
        ) {
            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $valueNode);
        }

        $this->parseValuePrimaryPayload($parseContext, $valueNode, $parentIndent);

        // Trailing s-separate / s-l-comments before ',', ']', or '}' belong to the enclosing
        // FlowSequenceBuilder / FlowMappingBuilder (YAML 1.2.2 §6.3, §7.1), not this ValueNode.
        if (!$parentIndent->isFlowCollection) {
            $this->consumer->collectSpaceAndComments($parseContext->tokens, $valueNode);
        }

        return $valueNode;
    }

    /**
     * YAML 1.2.2 §7.2 e-node / §7.4: in flow contexts, scalar content may be empty right
     * after c-ns-properties (tag/anchor) — the next ',' / '}' / ']' terminates the entry.
     */
    private function isFlowEmptyValueTerminator(Token $token, IndentContext $parentIndent): bool
    {
        return $parentIndent->isFlowCollection
            && \in_array($token->type, [
                TokenType::FLOW_ENTRY,
                TokenType::FLOW_MAPPING_END,
                TokenType::FLOW_SEQUENCE_END,
            ], true);
    }

    private function parseBlockScalarPayload(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        if (null === $parseContext->tokens->current()) {
            return;
        }

        $this->registry->getBlockScalarParser()->consumeBlockScalarValue(
            $parseContext->tokens,
            $valueNode,
            $parentIndent,
        );
    }

    private function parseNewlinePayload(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        if ($parentIndent->isFlowCollection) {
            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $valueNode);
            $this->parseValuePrimaryPayload($parseContext, $valueNode, $parentIndent);

            return;
        }

        $this->registry->getIndentedBlockValueParser()->parseIndentedBlockValue($parseContext, $valueNode, $parentIndent);
    }

    private function parsePlainScalarPayload(
        ParseContext $parseContext,
        ValueNode $valueNode,
        IndentContext $parentIndent,
        Token $token,
    ): void {
        if (
            TokenType::PLAIN_SCALAR === $token->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($parseContext->tokens, 1, $parentIndent)
        ) {
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($this->nodeFactory->createScalarNode($token));
            $parseContext->tokens->advance();
            $this->registry->getMultilinePlainScalarParser()->appendMultilinePlainScalarContinuations($parseContext->tokens, $multiline, $parentIndent);
            $valueNode->addChild($multiline);
        } elseif (
            TokenType::PLAIN_SCALAR === $token->type
            && $parentIndent->isFlowCollection
        ) {
            $head = $this->nodeFactory->createScalarNode($token);
            $parseContext->tokens->advance();
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($head);
            $consumedAny = false;
            while ($this->registry->getFlowMultilinePlainScalarHelper()->tryConsumeFlowValueMultilinePlainScalarLine($parseContext->tokens, $multiline)) {
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
    private function parseValuePrimaryPayload(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        $token = $parseContext->tokens->current();
        if (null === $token) {
            return;
        }

        if ($this->isFlowEmptyValueTerminator($token, $parentIndent)) {
            return;
        }

        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $this->parseBlockScalarPayload($parseContext, $valueNode, $parentIndent);
        } elseif (TokenType::NEWLINE === $token->type) {
            $this->parseNewlinePayload($parseContext, $valueNode, $parentIndent);
        } elseif ($token->type->isScalar()) {
            $this->parsePlainScalarPayload($parseContext, $valueNode, $parentIndent, $token);
        } elseif (TokenType::ALIAS === $token->type) {
            $aliasNode = $this->aliasResolver->resolveAlias($parseContext, $token);
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
