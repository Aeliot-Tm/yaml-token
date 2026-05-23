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
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Token\Token;

final readonly class KeyParser implements SubParserInterface
{
    public function __construct(
        private ErrorHelper $errorHelper,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private ParserRegistry $registry,
    ) {
    }

    public function getKeyNode(ParseContext $parseContext, ?int $entryIndentLen = null): KeyNode
    {
        $keyNode = new KeyNode();
        $this->collectKeyProperties($parseContext, $keyNode);
        $token = $parseContext->tokens->current();

        if (TokenType::EXPLICIT_KEY_INDICATOR === $token->type) {
            $keyNode->addChild(new ExplicitKeyIndicatorNode($token));
            $parseContext->tokens->advance();
            $token = $parseContext->tokens->current();

            if (TokenType::WHITESPACE === $token->type) {
                $keyNode->addChild(new WhitespaceNode($token));
                $parseContext->tokens->advance();
            }

            $this->collectKeyProperties($parseContext, $keyNode);
            $token = $parseContext->tokens->current();
        }

        if (
            null !== $keyNode->getExplicitKeyIndicatorNode()
            && null !== $entryIndentLen
            && TokenType::NEWLINE === $token->type
        ) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 1);
            if (null === $head) {
                return $keyNode;
            }

            [$indentLen, $significantToken, $scalarPeekOffset] = $head;
            if ($indentLen <= $entryIndentLen) {
                return $keyNode;
            }

            if (TokenType::SEQUENCE_ENTRY === $significantToken->type) {
                $keyNode->setName($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, $entryIndentLen));

                return $keyNode;
            }

            if (
                TokenType::EXPLICIT_KEY_INDICATOR === $significantToken->type
                || TokenType::MERGE_INDICATOR === $significantToken->type
            ) {
                $keyNode->setName($this->registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, $entryIndentLen));

                return $keyNode;
            }

            if ($significantToken->type->isScalar()) {
                if ($this->multilineContinuationHelper->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, $scalarPeekOffset)) {
                    $keyNode->setName($this->registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, $entryIndentLen));
                } else {
                    $this->registry->getBlockScalarParser()->consumeExplicitKeyMultilinePlainScalar($parseContext->tokens, $keyNode, $entryIndentLen);
                }

                return $keyNode;
            }

            return $keyNode;
        }

        if (TokenType::VALUE_INDICATOR === $token->type) {
            return $keyNode;
        }

        if (
            null !== $keyNode->getExplicitKeyIndicatorNode()
            && TokenType::SEQUENCE_ENTRY === $token->type
        ) {
            $keyNode->setName($this->registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($parseContext, $token->column - 1));

            return $keyNode;
        }

        if (TokenType::FLOW_MAPPING_START === $token->type) {
            $keyNode->setName($this->registry->getFlowMappingParser()->parse($parseContext));

            return $keyNode;
        }

        if (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $keyNode->setName($this->registry->getFlowSequenceParser()->parse($parseContext));

            return $keyNode;
        }

        if (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $parseContext->anchorsRegistry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException($this->errorHelper->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
            }
            $aliasNode->setAnchor($anchor);
            $keyNode->setName($aliasNode);
            $parseContext->tokens->advance();

            return $keyNode;
        }

        if (TokenType::VALUE_INDICATOR === $token->type && null !== $keyNode->getProperties()) {
            return $keyNode;
        }

        if (
            null !== $keyNode->getExplicitKeyIndicatorNode()
            && \in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)
        ) {
            $this->registry->getBlockScalarParser()->consumeBlockScalarKeyName($parseContext->tokens, $keyNode);

            return $keyNode;
        }

        if (!$token->type->isScalar() && !$token->type->isMergeIndicator()) {
            if (null !== $keyNode->getExplicitKeyIndicatorNode()) {
                return $keyNode;
            }

            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Key scalar expected, but %s given', $token->type->value), $token));
        }

        $keyNode->setName(
            $this->registry
                ->getMultilinePlainScalarParser()
                ->buildScalarKeyName(
                    $parseContext->tokens,
                    $token,
                    $entryIndentLen,
                    null !== $keyNode->getExplicitKeyIndicatorNode(),
                ),
        );

        return $keyNode;
    }

    private function collectKeyProperties(ParseContext $parseContext, KeyNode $keyNode): void
    {
        $properties = null;
        $whitespaceBuffer = [];

        while (!$parseContext->tokens->isEnd()) {
            $token = $parseContext->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                if (null === $properties) {
                    $keyNode->addChild(new WhitespaceNode($token));
                } else {
                    $whitespaceBuffer[] = new WhitespaceNode($token);
                }
                $parseContext->tokens->advance();

                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->addChild(new AnchorNode($token));
                $parseContext->tokens->advance();

                continue;
            }

            if ($this->isNodePropertyToken($token)) {
                if (null !== $properties?->getTag()) {
                    throw new UnexpectedStateException($this->errorHelper->appendTokenLocation('Only one tag is supported per key node', $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->addChild(new TagNode($token));
                $parseContext->tokens->advance();

                continue;
            }

            break;
        }

        if (null !== $properties) {
            $keyNode->addChild($properties);
        }
        foreach ($whitespaceBuffer as $whitespace) {
            $keyNode->addChild($whitespace);
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
