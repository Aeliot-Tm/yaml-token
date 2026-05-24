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
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\AliasResolver;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Parser\SubParser\Consumer;
use Aeliot\YamlToken\Parser\SubParser\NodePropertiesParser;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class ExplicitKeyParser
{
    public function __construct(
        private AliasResolver $aliasResolver,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private NodePropertiesParser $nodePropertiesParser,
        private PeekOffsetHelper $peekOffsetHelper,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $parseContext, KeyNode $keyNode, ?int $entryIndentLen): void
    {
        $token = $parseContext->tokens->current();
        $keyNode->addChild(new ExplicitKeyIndicatorNode($token));
        $parseContext->tokens->advance();
        $token = $parseContext->tokens->current();

        if (TokenType::WHITESPACE === $token->type) {
            $keyNode->addChild(new WhitespaceNode($token));
            $parseContext->tokens->advance();
        }

        $this->nodePropertiesParser->collectProperties($parseContext, $keyNode);
        $this->parseContent($parseContext, $keyNode, $entryIndentLen);
    }

    /**
     * YAML 1.2.2 §8.2.2: explicit block key whose body starts on a following line
     * (after optional same-line trailing comment).
     */
    public function parseIndentedKeyBodyIfPresent(ParseContext $parseContext, KeyNode $keyNode, int $entryIndentLen): void
    {
        if (null !== $keyNode->getName()) {
            return;
        }

        $this->consumeSameLineTrailingCommentForBlockExplicitKey($parseContext, $keyNode);

        $token = $parseContext->tokens->current();
        if (TokenType::NEWLINE !== $token?->type) {
            return;
        }

        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 1);
        if (null === $head) {
            return;
        }

        $indentLen = $head->indentLen;
        $significantToken = $head->significantToken;
        $scalarPeekOffset = $head->peekOffset;
        if ($indentLen <= $entryIndentLen) {
            return;
        }

        if (TokenType::SEQUENCE_ENTRY === $significantToken->type) {
            $keyNode->setName($this->registry->getBlockSequenceParser()->parseBlockSequenceValue($parseContext, IndentContext::createForBlock($entryIndentLen)));

            return;
        }

        if (
            TokenType::EXPLICIT_KEY_INDICATOR === $significantToken->type
            || TokenType::MERGE_INDICATOR === $significantToken->type
        ) {
            $keyNode->setName($this->registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, IndentContext::createForBlock($entryIndentLen)));

            return;
        }

        if ($significantToken->type->isScalar()) {
            if ($this->multilineContinuationHelper->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, $scalarPeekOffset)) {
                $keyNode->setName($this->registry->getBlockMappingParser()->parseBlockMappingValue($parseContext, IndentContext::createForBlock($entryIndentLen)));
            } else {
                $this->consumeExplicitKeyMultilinePlainScalar($parseContext->tokens, $keyNode, $entryIndentLen);
            }
        }
    }

    private function buildExplicitBlockKeyMultilinePlainScalarName(
        TokenStreamInterface $tokens,
        PlainScalarNode $head,
        int $entryIndentLen,
    ): Node {
        $multiline = new MultilinePlainScalarNode();
        $multiline->addChild($head);

        $consumedAny = false;
        while ($this->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
            $consumedAny = true;
        }

        return $consumedAny ? $multiline : $head;
    }

    private function buildScalarKeyName(TokenStreamInterface $tokens, Token $headToken, ?int $entryIndentLen): Node
    {
        $head = $this->nodeFactory->createScalarNode($headToken);
        $tokens->advance();

        if (!$head instanceof PlainScalarNode) {
            return $head;
        }

        if (null === $entryIndentLen) {
            return $this->registry->getFlowMultilinePlainScalarKeyParser()->parse($tokens, $head);
        }

        return $this->buildExplicitBlockKeyMultilinePlainScalarName($tokens, $head, $entryIndentLen);
    }

    /**
     * Builds the {@see KeyNode} name for the explicit-block-key path where the key starts on a new line
     * after the `?` indicator (YAML 1.2.2 §8.2.2). Consumes the first NEWLINE + INDENTATION + PLAIN_SCALAR
     * line and any subsequent continuation lines. When only a single scalar fragment is present, the
     * leading layout (NEWLINE / INDENTATION / WHITESPACE) is attached directly to the {@see KeyNode}
     * and the name becomes a plain {@see ScalarNode}; otherwise the whole sequence is wrapped in a
     * {@see MultilinePlainScalarNode}.
     */
    private function consumeExplicitKeyMultilinePlainScalar(TokenStreamInterface $tokens, KeyNode $keyNode, int $entryIndentLen): void
    {
        if (TokenType::NEWLINE !== $tokens->current()?->type) {
            return;
        }

        $multiline = new MultilinePlainScalarNode();
        $this->consumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen);

        while ($this->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
        }

        $scalars = array_values(array_filter(
            $multiline->getChildren(),
            static fn (Node $child): bool => $child instanceof ScalarNode,
        ));

        if (1 === \count($scalars)) {
            foreach ($multiline->getChildren() as $child) {
                if ($child instanceof ScalarNode) {
                    $keyNode->setName($child);
                } else {
                    $keyNode->addChild($child);
                }
            }

            return;
        }

        $keyNode->setName($multiline);
    }

    private function consumeExplicitKeyMultilinePlainScalarLine(
        TokenStreamInterface $tokens,
        MultilinePlainScalarNode $multiline,
        int $entryIndentLen,
    ): void {
        if (!$this->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
            $token = $tokens->current();
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE to start indented explicit key plain scalar, got %s', $token?->type->value ?? '_nothing_'), $tokens));
        }
    }

    private function consumeSameLineTrailingCommentForBlockExplicitKey(ParseContext $parseContext, KeyNode $keyNode): void
    {
        if (TokenType::COMMENT === $parseContext->tokens->current()?->type) {
            $this->consumer->collectTypes($parseContext->tokens, [TokenType::COMMENT], $keyNode);
        }
    }

    private function parseContent(ParseContext $parseContext, KeyNode $keyNode, ?int $entryIndentLen): void
    {
        if (null !== $entryIndentLen) {
            $this->parseIndentedKeyBodyIfPresent($parseContext, $keyNode, $entryIndentLen);
            if (null !== $keyNode->getName()) {
                return;
            }
        }

        $token = $parseContext->tokens->current();

        if (TokenType::VALUE_INDICATOR === $token->type) {
            return;
        }

        if (TokenType::SEQUENCE_ENTRY === $token->type) {
            $keyNode->setName($this->registry->getCompactBlockSequenceParser()->parseCompactBlockSequence($parseContext, $token->column - 1));

            return;
        }

        if (TokenType::FLOW_MAPPING_START === $token->type) {
            $keyNode->setName($this->registry->getFlowMappingParser()->parse($parseContext));

            return;
        }

        if (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $keyNode->setName($this->registry->getFlowSequenceParser()->parse($parseContext));

            return;
        }

        if (TokenType::ALIAS === $token->type) {
            $aliasNode = $this->aliasResolver->resolveAlias($parseContext, $token);
            $keyNode->setName($aliasNode);
            $parseContext->tokens->advance();

            return;
        }

        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $this->registry->getBlockScalarKeyNameConsumer()->consume($parseContext->tokens, $keyNode);

            return;
        }

        if (
            null !== $entryIndentLen
            && TokenType::PLAIN_SCALAR === $token->type
            && $this->multilineContinuationHelper->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, 0)
        ) {
            $keyNode->setName($this->registry->getCompactBlockMappingParser()->parseCompactBlockMapping($parseContext, $token->column - 1));

            return;
        }

        if (!$token->type->isScalar() && !$token->type->isMergeIndicator()) {
            return;
        }

        $keyNode->setName($this->buildScalarKeyName($parseContext->tokens, $token, $entryIndentLen));
    }

    private function tryConsumeExplicitKeyMultilinePlainScalarLine(
        TokenStreamInterface $tokens,
        MultilinePlainScalarNode $multiline,
        int $entryIndentLen,
    ): bool {
        $newLine = $tokens->current();
        if (TokenType::NEWLINE !== $newLine?->type) {
            return false;
        }

        $indentation = $tokens->peek(1);
        if (TokenType::INDENTATION !== $indentation?->type) {
            return false;
        }

        if (\strlen($indentation->text) <= $entryIndentLen) {
            return false;
        }

        $scalarOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, 2);
        $scalarToken = $tokens->peek($scalarOffset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        $multiline->addChild(new NewLineNode($newLine));
        $multiline->addChild(new IndentationNode($indentation));
        $tokens->advance();
        $tokens->advance();

        $this->consumer->collectWhitespace($tokens, $multiline);

        $multiline->addChild($this->nodeFactory->createScalarNode($tokens->current()));
        $tokens->advance();

        return true;
    }
}
