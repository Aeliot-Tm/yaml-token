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
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class IndentedBlockValueParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private NodePropertyIdentifier $nodePropertyIdentifier,
        private ParserRegistry $registry,
    ) {
    }

    public function parseIndentedBlockValue(ParseContext $parseContext, ValueNode $valueNode, int $parentIndentLen): void
    {
        $token = $parseContext->tokens->current();
        if (TokenType::NEWLINE !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE while parsing indented block value, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 1);
        if (null === $head) {
            return;
        }
        [$indentLen, $afterIndent, $afterIndentOffset] = $head;

        if ($indentLen > 0) {
            if ($indentLen === $parentIndentLen && TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
                $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, $parentIndentLen - 1, true));

                return;
            }

            if ($indentLen <= $parentIndentLen) {
                return;
            }

            if ($this->nodePropertyIdentifier->isNodePropertyToken($afterIndent) && $this->isNodePropertiesOnlyLine($parseContext, $afterIndentOffset)) {
                $separatorContainer = $valueNode->getProperties() ?? $valueNode;
                $separatorContainer->addChild(new NewLineNode($token));
                $parseContext->tokens->advance();
                $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $separatorContainer);
                $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $separatorContainer);

                $indentationToken = $parseContext->tokens->current();
                if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                    throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION before node properties, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
                }
                $separatorContainer->addChild(new IndentationNode($indentationToken));
                $parseContext->tokens->advance();

                $this->registry->getNodePropertiesParser()->collectValueProperties($parseContext, $valueNode);

                $next = $parseContext->tokens->current();
                if (null === $next || TokenType::NEWLINE !== $next->type) {
                    throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE after node properties, but %s given', $next?->type->value ?? '_nothing_'), $parseContext->tokens));
                }

                $this->parseIndentedBlockValue($parseContext, $valueNode, $parentIndentLen);

                return;
            }

            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
                $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, $parentIndentLen));

                return;
            }

            if (
                TokenType::FLOW_SEQUENCE_START === $afterIndent->type
                || TokenType::FLOW_MAPPING_START === $afterIndent->type
            ) {
                $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);

                $indentationToken = $parseContext->tokens->current();
                if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                    throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION before flow node, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
                }
                $valueNode->addChild(new IndentationNode($indentationToken));
                $parseContext->tokens->advance();

                $valueNode->addChild(
                    TokenType::FLOW_SEQUENCE_START === $afterIndent->type
                        ? $this->registry->getFlowSequenceParser()->parse($parseContext)
                        : $this->registry->getFlowMappingParser()->parse($parseContext),
                );

                return;
            }

            if (
                $this->nodePropertyIdentifier->isNodePropertyToken($afterIndent)
                && !$this->nodePropertyIdentifier->isNodePropertiesFollowedByImplicitKeyFromOffset($parseContext, $afterIndentOffset)
            ) {
                $this->consumeIndentedBlockTaggedScalarValue($parseContext, $valueNode, $parentIndentLen);

                return;
            }

            if (
                \in_array($afterIndent->type, [
                    TokenType::DOUBLE_QUOTED_SCALAR,
                    TokenType::SINGLE_QUOTED_SCALAR,
                    TokenType::PLAIN_SCALAR,
                ], true)
                && !$this->multilineContinuationHelper
                    ->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, $afterIndentOffset)
            ) {
                $this->consumeIndentedBlockScalarValue($parseContext, $valueNode, $parentIndentLen);

                return;
            }

            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $valueNode->addChild($this->registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, $parentIndentLen));

            return;
        }

        if (EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen) {
            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
                $valueNode->addChild(
                    $this->registry
                        ->getBlockSequenceParser()
                        ->parseBlockSequenceValue($parseContext, EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value),
                );

                return;
            }
            if (
                TokenType::EXPLICIT_KEY_INDICATOR === $afterIndent->type
                || TokenType::MERGE_INDICATOR === $afterIndent->type
                || $afterIndent->type->isScalar()
            ) {
                $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
                $valueNode->addChild(
                    $this->registry
                        ->getBlockMappingParser()
                        ->parseBlockMappingValue($parseContext, EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value),
                );
            }
        }
    }

    private function consumeBlockValueOpeningLayout(ParseContext $parseContext, ValueNode $valueNode): void
    {
        $valueNode->addChild(new NewLineNode($parseContext->tokens->current()));
        $parseContext->tokens->advance();

        $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $valueNode);
        $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $valueNode);
    }

    private function consumeIndentedBlockScalarValue(ParseContext $parseContext, ValueNode $valueNode, int $parentIndentLen): void
    {
        $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);

        $indentationToken = $parseContext->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION for indented block scalar value, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndentLen) {
            throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Indented block scalar must be deeper than parent key line indent (%d spaces)', $parentIndentLen), $indentationToken));
        }

        $indentationNode = new IndentationNode($indentationToken);
        $parseContext->tokens->advance();

        $layoutBuffer = [];
        while (true) {
            $layoutToken = $parseContext->tokens->current();
            if (
                null === $layoutToken
                || !\in_array($layoutToken->type, [TokenType::WHITESPACE, TokenType::COMMENT], true)
            ) {
                break;
            }
            $layoutBuffer[] = $this->nodeFactory->createSimpleNode($layoutToken);
            $parseContext->tokens->advance();
        }

        $scalarToken = $parseContext->tokens->current();
        if (null === $scalarToken || !\in_array($scalarToken->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected for indented block value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        if (
            TokenType::PLAIN_SCALAR === $scalarToken->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($parseContext->tokens, 1, $parentIndentLen)
        ) {
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($indentationNode);
            foreach ($layoutBuffer as $layoutNode) {
                $multiline->addChild($layoutNode);
            }
            $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $parseContext->tokens->advance();
            $this->registry
                ->getMultilinePlainScalarParser()
                ->appendMultilinePlainScalarContinuations($parseContext->tokens, $multiline, $parentIndentLen);
            $valueNode->addChild($multiline);
        } else {
            $valueNode->addChild($indentationNode);
            foreach ($layoutBuffer as $layoutNode) {
                $valueNode->addChild($layoutNode);
            }
            $valueNode->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $parseContext->tokens->advance();
        }
    }

    private function consumeIndentedBlockTaggedScalarValue(ParseContext $parseContext, ValueNode $valueNode, int $parentIndentLen): void
    {
        $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);

        $indentationToken = $parseContext->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION for indented block tagged scalar value, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndentLen) {
            throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Indented block tagged scalar must be deeper than parent key line indent (%d spaces)', $parentIndentLen), $indentationToken));
        }

        $valueNode->addChild(new IndentationNode($indentationToken));
        $parseContext->tokens->advance();

        $this->registry->getNodePropertiesParser()->collectValueProperties($parseContext, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $parseContext->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }

        $this->consumer->collectSpaceAndComments($parseContext->tokens, $valueNode);

        $scalarToken = $parseContext->tokens->current();
        if (null === $scalarToken || !\in_array($scalarToken->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected for indented block tagged scalar value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        if (
            TokenType::PLAIN_SCALAR === $scalarToken->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($parseContext->tokens, 1, $parentIndentLen)
        ) {
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $parseContext->tokens->advance();
            $this->registry
                ->getMultilinePlainScalarParser()
                ->appendMultilinePlainScalarContinuations($parseContext->tokens, $multiline, $parentIndentLen);
            $valueNode->addChild($multiline);
        } else {
            $valueNode->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $parseContext->tokens->advance();
        }
    }

    private function isNodePropertiesOnlyLine(ParseContext $parseContext, int $offset): bool
    {
        $i = $offset;
        $seenTag = false;

        while (true) {
            $token = $parseContext->tokens->peek($i);
            if (null === $token) {
                return true;
            }
            if (TokenType::NEWLINE === $token->type) {
                return true;
            }
            if (TokenType::WHITESPACE === $token->type || TokenType::COMMENT === $token->type) {
                ++$i;

                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                ++$i;

                continue;
            }

            if ($this->nodePropertyIdentifier->isNodePropertyToken($token)) {
                if ($seenTag) {
                    return false;
                }
                $seenTag = true;
                ++$i;

                continue;
            }

            return false;
        }
    }
}
