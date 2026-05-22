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
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
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
    public function parseValue(ParseContext $harvester, int $parentIndentLen): ValueNode
    {
        $valueNode = new ValueNode();

        $this->registry->getNodePropertiesParser()->collectValueProperties($harvester, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $harvester->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }

        $this->consumer->collectSpaceAndComments($harvester->tokens, $valueNode);

        $token = $harvester->tokens->current();
        if (
            null !== $token
            && TokenType::NEWLINE === $token->type
            && EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen
        ) {
            $this->consumer->collectSpaceCommentEnds($harvester->tokens, $valueNode);
        }

        $this->parseValuePrimaryPayload($harvester, $valueNode, $parentIndentLen);

        // Trailing s-separate / s-l-comments before ',', ']', or '}' belong to the enclosing
        // FlowSequenceBuilder / FlowMappingBuilder (YAML 1.2.2 §6.3, §7.1), not this ValueNode.
        if (EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value !== $parentIndentLen) {
            $this->consumer->collectSpaceAndComments($harvester->tokens, $valueNode);
        }

        return $valueNode;
    }

    /**
     * Parses the main value payload (block scalar, block-after-newline, scalars, aliases, compact collections, flow nodes).
     */
    private function parseValuePrimaryPayload(ParseContext $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            return;
        }
        // YAML 1.2.2 §7.2 e-node / §7.4: in flow contexts, scalar content may be empty right
        // after c-ns-properties (tag/anchor) — the next ',' / '}' / ']' terminates the entry.
        if (
            EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen
            && \in_array($token->type, [
                TokenType::FLOW_ENTRY,
                TokenType::FLOW_MAPPING_END,
                TokenType::FLOW_SEQUENCE_END,
            ], true)
        ) {
            return;
        }

        $multilinePlainScalarParser = $this->registry->getMultilinePlainScalarParser();

        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $valueNode->addChild(new BlockScalarIndicatorNode($token));
            $harvester->tokens->advance();
            $this->consumer->collectUntil($harvester->tokens, TokenType::NEWLINE, $valueNode);

            $token = $harvester->tokens->current();
            if (!$token) {
                return;
            }

            if (TokenType::NEWLINE !== $token->type) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected newline, but %s given', $token->type->value), $token));
            }
            $valueNode->addChild(new NewLineNode($token));
            $harvester->tokens->advance();

            while (TokenType::NEWLINE === $harvester->tokens->current()?->type) {
                $leadingEmptyLineBreak = $harvester->tokens->current();
                $valueNode->addChild(new NewLineNode($leadingEmptyLineBreak));
                $harvester->tokens->advance();
            }

            // YAML 1.2.2 §8.1.1.1: with an explicit indentation indicator (|N, >N, |N-, >N+, ...),
            // the body may start with leading spaces that are part of the content but surface
            // to the parser as a separate INDENTATION token before the scalar payload.
            if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
                $valueNode->addChild(new IndentationNode($harvester->tokens->current()));
                $harvester->tokens->advance();
            }

            $token = $harvester->tokens->current();
            if (null === $token || !$token->type->isScalar()) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected, but %s given', $token?->type->value ?? '_nothing_'), $token));
            }

            $valueNode->addChild($this->nodeFactory->createScalarNode($token));
            $harvester->tokens->advance();

            // YAML 1.2.2 §8.1.1.2 / rule [166]-[168] l-chomped-empty(n,t):
            // trailing "empty" indented lines belong to the block scalar and must be
            // consumed here (even with strip chomping they are excluded from content but
            // still consumed from the token stream).
            while (true) {
                $newLineToken = $harvester->tokens->current();
                if (TokenType::NEWLINE !== $newLineToken?->type) {
                    break;
                }
                $indentationToken = $harvester->tokens->peek(1);
                if (TokenType::INDENTATION !== $indentationToken?->type) {
                    break;
                }
                $probe = 2;
                while (TokenType::WHITESPACE === $harvester->tokens->peek($probe)?->type) {
                    ++$probe;
                }
                $afterIndentation = $harvester->tokens->peek($probe);
                if (null !== $afterIndentation && TokenType::NEWLINE !== $afterIndentation->type) {
                    break;
                }
                $valueNode->addChild(new NewLineNode($newLineToken));
                $harvester->tokens->advance();
                $valueNode->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();
                $emptyLineSpace = $harvester->tokens->current();
                while (TokenType::WHITESPACE === $emptyLineSpace->type) {
                    $valueNode->addChild(new WhitespaceNode($emptyLineSpace));
                    $harvester->tokens->advance();
                    $emptyLineSpace = $harvester->tokens->current();
                }
            }

            // Non-empty continuation lines (| / > body): same newline + indent + scalar
            // structure as multiline plain scalars (YAML 1.2.2 §8.1.1).
            $multilinePlainScalarParser->appendMultilinePlainScalarContinuations($harvester->tokens, $valueNode, $parentIndentLen);
        } elseif (TokenType::NEWLINE === $token->type) {
            if (EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen) {
                $this->consumer->collectSpaceCommentEnds($harvester->tokens, $valueNode);
                $this->parseValuePrimaryPayload($harvester, $valueNode, $parentIndentLen);

                return;
            }
            $this->registry->getIndentedBlockValueParser()->parseIndentedBlockValue($harvester, $valueNode, $parentIndentLen);
        } elseif ($token->type->isScalar()) {
            if (
                TokenType::PLAIN_SCALAR === $token->type
                && $this->multilineContinuationHelper
                    ->isMultilinePlainContinuationAhead($harvester->tokens, 1, $parentIndentLen)
            ) {
                $multiline = new MultilinePlainScalarNode();
                $multiline->addChild($this->nodeFactory->createScalarNode($token));
                $harvester->tokens->advance();
                $multilinePlainScalarParser->appendMultilinePlainScalarContinuations($harvester->tokens, $multiline, $parentIndentLen);
                $valueNode->addChild($multiline);
            } elseif (
                TokenType::PLAIN_SCALAR === $token->type
                && EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value === $parentIndentLen
            ) {
                $head = $this->nodeFactory->createScalarNode($token);
                $harvester->tokens->advance();
                $multiline = new MultilinePlainScalarNode();
                $multiline->addChild($head);
                $consumedAny = false;
                while ($multilinePlainScalarParser->tryConsumeFlowValueMultilinePlainScalarLine($harvester->tokens, $multiline)) {
                    $consumedAny = true;
                }
                $valueNode->addChild($consumedAny ? $multiline : $head);
            } else {
                $valueNode->addChild($this->registry->getSimpleScalarParser()->parse($harvester));
            }
        } elseif (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $harvester->anchorsRegistry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException($this->errorHelper->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
            }
            $aliasNode->setAnchor($anchor);
            $valueNode->addChild($aliasNode);
            $harvester->tokens->advance();
        } elseif (TokenType::SEQUENCE_ENTRY === $token->type) {
            $valueNode->addChild($this->registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($harvester, $token->column - 1));
        } elseif (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $valueNode->addChild($this->registry->getFlowSequenceParser()->parse($harvester));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->registry->getFlowMappingParser()->parse($harvester));
        } else {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected type while parsing of value: %s', $token->type->value), $token));
        }
    }
}
