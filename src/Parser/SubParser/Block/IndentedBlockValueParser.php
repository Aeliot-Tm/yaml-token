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
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\LookAheadResult;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\SubParser\Consumer;
use Aeliot\YamlToken\Token\Token;

final readonly class IndentedBlockValueParser
{
    private const NODE_PROPERTIES_LINE_ANCHOR_OR_TAG_ONLY = 'anchor_or_tag_only';
    private const NODE_PROPERTIES_LINE_OTHER = 'other';
    private const NODE_PROPERTIES_LINE_SCALAR = 'scalar';

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

    public function parseIndentedBlockValue(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        $token = $parseContext->tokens->current();
        if (TokenType::NEWLINE !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE while parsing indented block value, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 1);
        if (null === $head) {
            return;
        }

        if ($head->indentLen > 0) {
            $this->dispatchIndentedContent($parseContext, $valueNode, $parentIndent, $head, $token);

            return;
        }

        if ($parentIndent->isBareDocumentRoot) {
            if ($this->tryDispatchNodePropertyContinuation($parseContext, $valueNode, $parentIndent, $head, $token, false)) {
                return;
            }

            $this->dispatchBareDocumentContent($parseContext, $valueNode, $head);
        }
    }

    private function classifyNodePropertiesLine(ParseContext $parseContext, int $offset): string
    {
        $i = $offset;
        $seenTag = false;

        while (true) {
            $token = $parseContext->tokens->peek($i);
            if (null === $token || TokenType::NEWLINE === $token->type) {
                return self::NODE_PROPERTIES_LINE_ANCHOR_OR_TAG_ONLY;
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
                    return self::NODE_PROPERTIES_LINE_OTHER;
                }
                $seenTag = true;
                ++$i;

                continue;
            }

            return $token->type->isScalar()
                ? self::NODE_PROPERTIES_LINE_SCALAR
                : self::NODE_PROPERTIES_LINE_OTHER;
        }
    }

    private function consumeContinuationLineLayout(ParseContext $parseContext, Node $layoutContainer, Token $newlineToken): void
    {
        $layoutContainer->addChild(new NewLineNode($newlineToken));
        $parseContext->tokens->advance();

        $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $layoutContainer);
        $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $layoutContainer);
    }

    private function consumeBlockValueOpeningLayout(ParseContext $parseContext, ValueNode $valueNode): void
    {
        $this->consumeContinuationLineLayout($parseContext, $valueNode, $parseContext->tokens->current());
    }

    /**
     * Consumes an indented plain scalar (no node properties prefix).
     * The stream must be positioned at the INDENTATION token (opening layout already consumed).
     * INDENTATION and any trailing WHITESPACE/COMMENT tokens are deferred into $layoutPrefix
     * and flushed into either a MultilinePlainScalarNode or directly into $valueNode by
     * finishScalarWithPossibleMultiline — they must not be separated from that call.
     */
    private function consumePlainScalar(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        $indentationToken = $parseContext->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION for indented block scalar, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndent->indentLen) {
            throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Indented block scalar must be deeper than parent key line indent (%d spaces)', $parentIndent->indentLen), $indentationToken));
        }

        $layoutPrefix = [new IndentationNode($indentationToken)];
        $parseContext->tokens->advance();

        while (true) {
            $layoutToken = $parseContext->tokens->current();
            if (
                null === $layoutToken
                || !\in_array($layoutToken->type, [TokenType::WHITESPACE, TokenType::COMMENT], true)
            ) {
                break;
            }
            $layoutPrefix[] = $this->nodeFactory->createSimpleNode($layoutToken);
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

        $this->finishScalarWithPossibleMultiline($parseContext, $valueNode, $scalarToken, $parentIndent, $layoutPrefix);
    }

    /**
     * Consumes an indented scalar that is preceded by node properties (tag/anchor) on the same line.
     * The stream must be positioned at the INDENTATION token (opening layout already consumed).
     */
    private function consumeTaggedScalar(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        $indentationToken = $parseContext->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION for indented block tagged scalar, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndent->indentLen) {
            throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Indented block tagged scalar must be deeper than parent key line indent (%d spaces)', $parentIndent->indentLen), $indentationToken));
        }

        $valueNode->addChild(new IndentationNode($indentationToken));
        $parseContext->tokens->advance();

        $this->consumeTaggedScalarPayload($parseContext, $valueNode, $parentIndent);
    }

    private function consumeTaggedScalarPayload(ParseContext $parseContext, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        $this->registry->getNodePropertiesParser()->collectProperties($parseContext, $valueNode);

        $this->registerAnchorIfPresent($parseContext, $valueNode);

        $this->consumer->collectSpaceAndComments($parseContext->tokens, $valueNode);

        $scalarToken = $parseContext->tokens->current();
        if (null === $scalarToken || !\in_array($scalarToken->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected for tagged scalar value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $this->finishScalarWithPossibleMultiline($parseContext, $valueNode, $scalarToken, $parentIndent);
    }

    private function dispatchBareDocumentContent(
        ParseContext $parseContext,
        ValueNode $valueNode,
        LookAheadResult $head,
    ): void {
        $afterIndent = $head->significantToken;
        $linePeekOffset = $head->peekOffset;
        if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $valueNode->addChild(
                $this->registry
                    ->getBlockSequenceParser()
                    ->parseBlockSequenceValue($parseContext, IndentContext::createForBareDocument()),
            );

            return;
        }

        if (
            TokenType::EXPLICIT_KEY_INDICATOR === $afterIndent->type
            || TokenType::MERGE_INDICATOR === $afterIndent->type
        ) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $valueNode->addChild(
                $this->registry
                    ->getBlockMappingParser()
                    ->parseBlockMappingValue($parseContext, IndentContext::createForBareDocument()),
            );

            return;
        }

        if (
            $this->nodePropertyIdentifier->isNodePropertyToken($afterIndent)
            && (
                $this->nodePropertyIdentifier->isNodePropertiesFollowedByImplicitKeyFromOffset($parseContext, $linePeekOffset)
                || $this->nodePropertyIdentifier->isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyFromOffset($parseContext, $linePeekOffset)
            )
        ) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $valueNode->addChild(
                $this->registry
                    ->getBlockMappingParser()
                    ->parseBlockMappingValue($parseContext, IndentContext::createForBareDocument()),
            );

            return;
        }

        if (!$afterIndent->type->isScalar()) {
            return;
        }

        $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);

        $scalarToken = $parseContext->tokens->current();
        if (null === $scalarToken || !$scalarToken->type->isScalar()) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Scalar expected for bare document block value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        if ($this->multilineContinuationHelper->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, 0)) {
            $valueNode->addChild(
                $this->registry
                    ->getBlockMappingParser()
                    ->parseBlockMappingValue($parseContext, IndentContext::createForBareDocument()),
            );

            return;
        }

        $this->finishScalarWithPossibleMultiline(
            $parseContext,
            $valueNode,
            $scalarToken,
            IndentContext::createForBareDocument(),
        );
    }

    /**
     * Dispatches indented block value content when the next significant line has positive indent.
     * Branch order is precedence: earlier branches win over later ones.
     */
    private function dispatchIndentedContent(
        ParseContext $parseContext,
        ValueNode $valueNode,
        IndentContext $parentIndent,
        LookAheadResult $head,
        Token $newlineToken,
    ): void {
        // YAML spec: a block sequence may start at the same indent level as the parent key
        // (same-indent sequence entry must be checked before the generic "too shallow" guard)
        if ($head->indentLen === $parentIndent->indentLen && TokenType::SEQUENCE_ENTRY === $head->significantToken->type) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, IndentContext::createForBlock($parentIndent->indentLen - 1), true));

            return;
        }

        if ($head->indentLen <= $parentIndent->indentLen) {
            return;
        }

        if ($this->tryDispatchNodePropertyContinuation($parseContext, $valueNode, $parentIndent, $head, $newlineToken, true)) {
            return;
        }

        if (TokenType::SEQUENCE_ENTRY === $head->significantToken->type) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $valueNode->addChild($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, $parentIndent));

            return;
        }

        if (
            TokenType::FLOW_SEQUENCE_START === $head->significantToken->type
            || TokenType::FLOW_MAPPING_START === $head->significantToken->type
        ) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $this->parseIndentedFlowCollection($parseContext, $valueNode, $head->significantToken);

            return;
        }

        // Plain/quoted scalar that is not an implicit mapping key
        if (
            \in_array($head->significantToken->type, [
                TokenType::DOUBLE_QUOTED_SCALAR,
                TokenType::SINGLE_QUOTED_SCALAR,
                TokenType::PLAIN_SCALAR,
            ], true)
            && !$this->multilineContinuationHelper
                ->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, $head->peekOffset)
        ) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $this->consumePlainScalar($parseContext, $valueNode, $parentIndent);

            return;
        }

        // Block scalar on a continuation line (e.g. after a node-properties-only line)
        if (\in_array($head->significantToken->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $indentationToken = $parseContext->tokens->current();
            if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION before block scalar, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
            }
            $valueNode->addChild(new IndentationNode($indentationToken));
            $parseContext->tokens->advance();
            $this->registry->getBlockScalarValueConsumer()->consume($parseContext->tokens, $valueNode, $parentIndent);

            return;
        }

        $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
        $valueNode->addChild($this->registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, $parentIndent));
    }

    /**
     * @param array<Node> $layoutPrefix
     */
    private function finishScalarWithPossibleMultiline(
        ParseContext $parseContext,
        ValueNode $valueNode,
        Token $scalarToken,
        IndentContext $parentIndent,
        array $layoutPrefix = [],
    ): void {
        if (
            TokenType::PLAIN_SCALAR === $scalarToken->type
            && $this->multilineContinuationHelper
                ->isMultilinePlainContinuationAhead($parseContext->tokens, 1, $parentIndent)
        ) {
            $multiline = new MultilinePlainScalarNode();
            foreach ($layoutPrefix as $layoutNode) {
                $multiline->addChild($layoutNode);
            }
            $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
            $parseContext->tokens->advance();
            $this->registry
                ->getMultilinePlainScalarParser()
                ->appendMultilinePlainScalarContinuations($parseContext->tokens, $multiline, $parentIndent);
            $valueNode->addChild($multiline);

            return;
        }

        foreach ($layoutPrefix as $layoutNode) {
            $valueNode->addChild($layoutNode);
        }
        $valueNode->addChild($this->nodeFactory->createScalarNode($scalarToken));
        $parseContext->tokens->advance();
    }

    private function parseIndentedFlowCollection(
        ParseContext $parseContext,
        ValueNode $valueNode,
        Token $afterIndent,
    ): void {
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
    }

    private function parseNodePropertiesContinuationLine(
        ParseContext $parseContext,
        ValueNode $valueNode,
        IndentContext $parentIndent,
        Token $newlineToken,
        bool $requiresIndentation,
    ): void {
        $separatorContainer = $valueNode->getProperties() ?? $valueNode;
        $this->consumeContinuationLineLayout($parseContext, $separatorContainer, $newlineToken);

        if ($requiresIndentation) {
            $indentationToken = $parseContext->tokens->current();
            if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION before node properties, but %s given', $indentationToken?->type->value ?? '_nothing_'), $parseContext->tokens));
            }
            $separatorContainer->addChild(new IndentationNode($indentationToken));
            $parseContext->tokens->advance();
        }

        $this->registry->getNodePropertiesParser()->collectProperties($parseContext, $valueNode);

        $this->registerAnchorIfPresent($parseContext, $valueNode);

        $next = $parseContext->tokens->current();
        if (null === $next || TokenType::NEWLINE !== $next->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE after node properties, but %s given', $next?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $this->parseIndentedBlockValue($parseContext, $valueNode, $parentIndent);
    }

    private function registerAnchorIfPresent(ParseContext $parseContext, ValueNode $valueNode): void
    {
        if ($anchor = $valueNode->getAnchor()) {
            $parseContext->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }
    }

    private function shouldContinueWithTaggedScalar(ParseContext $parseContext, int $offset): bool
    {
        if (self::NODE_PROPERTIES_LINE_SCALAR !== $this->classifyNodePropertiesLine($parseContext, $offset)) {
            return false;
        }

        return !$this->nodePropertyIdentifier->isNodePropertiesFollowedByImplicitKeyFromOffset($parseContext, $offset);
    }

    private function tryDispatchNodePropertyContinuation(
        ParseContext $parseContext,
        ValueNode $valueNode,
        IndentContext $parentIndent,
        LookAheadResult $head,
        Token $newlineToken,
        bool $requiresIndentation,
    ): bool {
        if (!$this->nodePropertyIdentifier->isNodePropertyToken($head->significantToken)) {
            return false;
        }

        if (self::NODE_PROPERTIES_LINE_ANCHOR_OR_TAG_ONLY === $this->classifyNodePropertiesLine($parseContext, $head->peekOffset)) {
            $this->parseNodePropertiesContinuationLine($parseContext, $valueNode, $parentIndent, $newlineToken, $requiresIndentation);

            return true;
        }

        if (!$this->shouldContinueWithTaggedScalar($parseContext, $head->peekOffset)) {
            return false;
        }

        if ($requiresIndentation) {
            $this->consumeBlockValueOpeningLayout($parseContext, $valueNode);
            $this->consumeTaggedScalar($parseContext, $valueNode, $parentIndent);

            return true;
        }

        $this->consumeContinuationLineLayout($parseContext, $valueNode->getProperties() ?? $valueNode, $newlineToken);
        $this->consumeTaggedScalarPayload($parseContext, $valueNode, IndentContext::createForBareDocument());

        return true;
    }
}
