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
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Token\Token;

final readonly class IndentedBlockValueParser implements SubParserInterface
{
    private const BARE_DOCUMENT_BLOCK_PARENT_INDENT = -1;

    /**
     * @param \Closure(Harvester, ValueNode): void $collectValueProperties
     * @param \Closure(Harvester, int): bool $isNodePropertiesFollowedByImplicitKeyFromOffset
     */
    public function __construct(
        private \Closure $collectValueProperties,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private \Closure $isNodePropertiesFollowedByImplicitKeyFromOffset,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    public function parseIndentedBlockValue(Harvester $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        $token = $harvester->tokens->current();
        if (TokenType::NEWLINE !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE while parsing indented block value, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($harvester->tokens, 1);
        if (null === $head) {
            return;
        }
        [$indentLen, $afterIndent, $afterIndentOffset] = $head;

        if ($indentLen > 0) {
            if ($indentLen === $parentIndentLen && TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $this->consumeBlockValueOpeningLayout($harvester, $valueNode);
                $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($harvester, $parentIndentLen - 1, true));

                return;
            }

            if ($indentLen <= $parentIndentLen) {
                return;
            }

            if ($this->isNodePropertyToken($afterIndent) && $this->isNodePropertiesOnlyLine($harvester, $afterIndentOffset)) {
                $separatorContainer = $valueNode->getProperties() ?? $valueNode;
                $separatorContainer->addChild(new NewLineNode($token));
                $harvester->tokens->advance();
                $this->consumer->collectSpaceCommentEnds($harvester->tokens, $separatorContainer);
                $this->lookAheadHelper->collectInsignificantIndentationLines($harvester->tokens, $separatorContainer);

                $indentationToken = $harvester->tokens->current();
                if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                    throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION before node properties, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
                }
                $separatorContainer->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();

                ($this->collectValueProperties)($harvester, $valueNode);

                $next = $harvester->tokens->current();
                if (null === $next || TokenType::NEWLINE !== $next->type) {
                    throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE after node properties, but %s given', $next?->type->value ?? '_nothing_'), $harvester->tokens));
                }

                $this->parseIndentedBlockValue($harvester, $valueNode, $parentIndentLen);

                return;
            }

            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $this->consumeBlockValueOpeningLayout($harvester, $valueNode);
                $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($harvester, $parentIndentLen));

                return;
            }

            if (
                TokenType::FLOW_SEQUENCE_START === $afterIndent->type
                || TokenType::FLOW_MAPPING_START === $afterIndent->type
            ) {
                $this->consumeBlockValueOpeningLayout($harvester, $valueNode);

                $indentationToken = $harvester->tokens->current();
                if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                    throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION before flow node, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
                }
                $valueNode->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();

                $valueNode->addChild(
                    TokenType::FLOW_SEQUENCE_START === $afterIndent->type
                        ? $this->registry->getFlowSequenceParser()->parse($harvester)
                        : $this->registry->getFlowMappingParser()->parse($harvester),
                );

                return;
            }

            if (
                $this->isNodePropertyToken($afterIndent)
                && !($this->isNodePropertiesFollowedByImplicitKeyFromOffset)($harvester, $afterIndentOffset)
            ) {
                $this->consumeIndentedBlockTaggedScalarValue($harvester, $valueNode, $parentIndentLen);

                return;
            }

            if (
                \in_array($afterIndent->type, [
                    TokenType::DOUBLE_QUOTED_SCALAR,
                    TokenType::SINGLE_QUOTED_SCALAR,
                    TokenType::PLAIN_SCALAR,
                ], true)
                && !$this->multilineContinuationHelper
                    ->isImplicitYamlKeyOnContinuationLine($harvester->tokens, $afterIndentOffset)
            ) {
                $this->consumeIndentedBlockScalarValue($harvester, $valueNode, $parentIndentLen);

                return;
            }

            $this->consumeBlockValueOpeningLayout($harvester, $valueNode);
            $valueNode->addChild($this->registry->getBlockMappingParser()->parseBlockMappingValue($harvester, $parentIndentLen));

            return;
        }

        if (self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen) {
            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $this->consumeBlockValueOpeningLayout($harvester, $valueNode);
                $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));

                return;
            }
            if (
                TokenType::EXPLICIT_KEY_INDICATOR === $afterIndent->type
                || TokenType::MERGE_INDICATOR === $afterIndent->type
                || $afterIndent->type->isScalar()
            ) {
                $this->consumeBlockValueOpeningLayout($harvester, $valueNode);
                $valueNode->addChild($this->registry->getBlockMappingParser()->parseBlockMappingValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));
            }
        }
    }

    private function consumeBlockValueOpeningLayout(Harvester $harvester, ValueNode $valueNode): void
    {
        $valueNode->addChild(new NewLineNode($harvester->tokens->current()));
        $harvester->tokens->advance();

        $this->consumer->collectSpaceCommentEnds($harvester->tokens, $valueNode);
        $this->lookAheadHelper->collectInsignificantIndentationLines($harvester->tokens, $valueNode);
    }

    private function consumeIndentedBlockScalarValue(Harvester $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        $this->consumeBlockValueOpeningLayout($harvester, $valueNode);

        $indentationToken = $harvester->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION for indented block scalar value, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndentLen) {
            throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Indented block scalar must be deeper than parent key line indent (%d spaces)', $parentIndentLen), $indentationToken));
        }

        $indentationNode = new IndentationNode($indentationToken);
        $harvester->tokens->advance();

        $layoutBuffer = [];
        while (true) {
            $layoutToken = $harvester->tokens->current();
            if (
                null === $layoutToken
                || !\in_array($layoutToken->type, [TokenType::WHITESPACE, TokenType::COMMENT], true)
            ) {
                break;
            }
            $layoutBuffer[] = $this->nodeFactory->createSimpleNode($layoutToken);
            $harvester->tokens->advance();
        }

        $scalarToken = $harvester->tokens->current();
        if (null === $scalarToken || !\in_array($scalarToken->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected for indented block value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        if (
            TokenType::PLAIN_SCALAR === $scalarToken->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($harvester->tokens, 1, $parentIndentLen)
        ) {
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($indentationNode);
            foreach ($layoutBuffer as $layoutNode) {
                $multiline->addChild($layoutNode);
            }
            $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $harvester->tokens->advance();
            $this->registry
                ->getMultilinePlainScalarParser()
                ->appendMultilinePlainScalarContinuations($harvester->tokens, $multiline, $parentIndentLen);
            $valueNode->addChild($multiline);
        } else {
            $valueNode->addChild($indentationNode);
            foreach ($layoutBuffer as $layoutNode) {
                $valueNode->addChild($layoutNode);
            }
            $valueNode->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $harvester->tokens->advance();
        }
    }

    private function consumeIndentedBlockTaggedScalarValue(Harvester $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        $this->consumeBlockValueOpeningLayout($harvester, $valueNode);

        $indentationToken = $harvester->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION for indented block tagged scalar value, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndentLen) {
            throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Indented block tagged scalar must be deeper than parent key line indent (%d spaces)', $parentIndentLen), $indentationToken));
        }

        $valueNode->addChild(new IndentationNode($indentationToken));
        $harvester->tokens->advance();

        ($this->collectValueProperties)($harvester, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $harvester->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }

        $this->consumer->collectSpaceAndComments($harvester->tokens, $valueNode);

        $scalarToken = $harvester->tokens->current();
        if (null === $scalarToken || !\in_array($scalarToken->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected for indented block tagged scalar value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        if (
            TokenType::PLAIN_SCALAR === $scalarToken->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($harvester->tokens, 1, $parentIndentLen)
        ) {
            $multiline = new MultilinePlainScalarNode();
            $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $harvester->tokens->advance();
            $this->registry
                ->getMultilinePlainScalarParser()
                ->appendMultilinePlainScalarContinuations($harvester->tokens, $multiline, $parentIndentLen);
            $valueNode->addChild($multiline);
        } else {
            $valueNode->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $harvester->tokens->advance();
        }
    }

    private function isNodePropertiesOnlyLine(Harvester $harvester, int $offset): bool
    {
        $i = $offset;
        $seenTag = false;

        while (true) {
            $token = $harvester->tokens->peek($i);
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

            if ($this->isNodePropertyToken($token)) {
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
