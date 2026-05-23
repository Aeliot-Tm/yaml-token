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

namespace Aeliot\YamlToken\Parser\SubParser\Scalar;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Token\Token;

final readonly class MultilinePlainScalarParser implements SubParserInterface
{
    public function __construct(
        private ErrorHelper $errorHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * Appends NEWLINE / INDENTATION / scalar chunks for multiline plain scalars and for | / > block bodies.
     *
     * @see Parser::parseValue() YAML 1.2.2 §7.3.3 / §8.1.1
     */
    public function appendMultilinePlainScalarContinuations(TokenStreamProxy $tokens, Node $targetNode, int $parentIndentLen): void
    {
        while (true) {
            $this->consumeTrailingWhitespaceBeforeNewline($tokens, $targetNode);

            if (TokenType::NEWLINE !== $tokens->current()?->type) {
                break;
            }

            if ($this->tryConsumeBlankLineContinuation($tokens, $targetNode, $parentIndentLen)) {
                continue;
            }
            if ($this->tryConsumeIndentedEmptyLineContinuation($tokens, $targetNode, $parentIndentLen)) {
                continue;
            }
            if ($this->tryConsumeIndentedContentLine($tokens, $targetNode, $parentIndentLen)) {
                continue;
            }
            if ($this->tryConsumeBareDocumentFlushLine($tokens, $targetNode, $parentIndentLen)) {
                continue;
            }

            break;
        }
    }

    public function buildExplicitBlockKeyMultilinePlainScalarName(
        TokenStreamProxy $tokens,
        PlainScalarNode $head,
        int $entryIndentLen,
    ): Node {
        $multiline = new MultilinePlainScalarNode();
        $multiline->addChild($head);

        $consumedAny = false;
        while ($this->registry->getBlockScalarParser()->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
            $consumedAny = true;
        }

        return $consumedAny ? $multiline : $head;
    }

    /**
     * Flow-context multiline plain key (YAML 1.2.2 §7.3.3 / §7.4.1): NEWLINE WHITESPACE* PLAIN_SCALAR
     * fragments may follow the first scalar. Returns the head scalar when no continuation is consumed,
     * otherwise a {@see MultilinePlainScalarNode} that wraps the head plus consumed fragments.
     */
    public function buildFlowKeyMultilinePlainScalarName(TokenStreamProxy $tokens, PlainScalarNode $head): Node
    {
        $multiline = new MultilinePlainScalarNode();
        $multiline->addChild($head);

        $consumedAny = false;
        while ($this->tryConsumeFlowKeyMultilinePlainScalarLine($tokens, $multiline)) {
            $consumedAny = true;
        }

        return $consumedAny ? $multiline : $head;
    }

    /**
     * Builds the {@see \Aeliot\YamlToken\Node\KeyNode} name node for a leading scalar key token, eagerly
     * consuming any multiline plain-scalar continuation lines.
     */
    public function buildScalarKeyName(
        TokenStreamProxy $tokens,
        Token $headToken,
        ?int $entryIndentLen,
        bool $hasExplicitKeyIndicator,
    ): Node {
        $head = $this->nodeFactory->createScalarNode($headToken);
        $tokens->advance();

        if (!$head instanceof PlainScalarNode) {
            return $head;
        }

        if (null === $entryIndentLen) {
            return $this->buildFlowKeyMultilinePlainScalarName($tokens, $head);
        }

        if ($hasExplicitKeyIndicator) {
            return $this->buildExplicitBlockKeyMultilinePlainScalarName($tokens, $head, $entryIndentLen);
        }

        return $head;
    }

    public function tryConsumeFlowKeyMultilinePlainScalarLine(TokenStreamProxy $tokens, MultilinePlainScalarNode $multiline): bool
    {
        return $this->tryConsumeFlowMultilinePlainScalarLine($tokens, $multiline, false);
    }

    /**
     * Flow-context multiline plain value (YAML 1.2.2 §7.3.3 / §7.4.1): NEWLINE WHITESPACE* PLAIN_SCALAR
     * fragments may follow the first scalar. Unlike {@see tryConsumeFlowKeyMultilinePlainScalarLine},
     * the continuation must not be a flow-pair key (PLAIN_SCALAR followed by VALUE_INDICATOR).
     */
    public function tryConsumeFlowValueMultilinePlainScalarLine(TokenStreamProxy $tokens, MultilinePlainScalarNode $multiline): bool
    {
        return $this->tryConsumeFlowMultilinePlainScalarLine($tokens, $multiline, true);
    }

    private function tryConsumeFlowMultilinePlainScalarLine(
        TokenStreamProxy $tokens,
        MultilinePlainScalarNode $multiline,
        bool $rejectValueIndicatorAfterScalar,
    ): bool {
        if (TokenType::NEWLINE !== $tokens->current()?->type) {
            return false;
        }

        $scalarOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, 1);
        $scalarToken = $tokens->peek($scalarOffset);
        if (TokenType::PLAIN_SCALAR !== $scalarToken?->type) {
            return false;
        }

        if ($rejectValueIndicatorAfterScalar) {
            $afterScalar = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $scalarOffset + 1);
            if (TokenType::VALUE_INDICATOR === $tokens->peek($afterScalar)?->type) {
                return false;
            }
        }

        $newLine = $tokens->current();
        $multiline->addChild(new NewLineNode($newLine));
        $tokens->advance();

        $contentHead = $tokens->current();
        while (TokenType::WHITESPACE === $contentHead->type) {
            $multiline->addChild(new WhitespaceNode($contentHead));
            $tokens->advance();
            $contentHead = $tokens->current();
        }

        $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
        $tokens->advance();

        return true;
    }

    private function appendWhitespaceThenScalar(TokenStreamProxy $tokens, Node $targetNode): void
    {
        $contentHead = $tokens->current();
        while (TokenType::WHITESPACE === $contentHead->type) {
            $targetNode->addChild(new WhitespaceNode($contentHead));
            $tokens->advance();
            $contentHead = $tokens->current();
        }

        $targetNode->addChild($this->nodeFactory->createScalarNode($contentHead));
        $tokens->advance();
    }

    private function consumeTrailingWhitespaceBeforeNewline(TokenStreamProxy $tokens, Node $targetNode): void
    {
        while (
            TokenType::WHITESPACE === $tokens->current()?->type
            && TokenType::NEWLINE === $tokens->peek(1)?->type
        ) {
            $targetNode->addChild(new WhitespaceNode($tokens->current()));
            $tokens->advance();
        }
    }

    private function tryConsumeBareDocumentFlushLine(TokenStreamProxy $tokens, Node $targetNode, int $parentIndentLen): bool
    {
        if (
            EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value !== $parentIndentLen
            || !$this->multilineContinuationHelper->isBareDocumentFlushMultilinePlainContinuationAt($tokens, 1)
        ) {
            return false;
        }

        $targetNode->addChild(new NewLineNode($tokens->current()));
        $tokens->advance();
        $this->appendWhitespaceThenScalar($tokens, $targetNode);

        return true;
    }

    private function tryConsumeBlankLineContinuation(TokenStreamProxy $tokens, Node $targetNode, int $parentIndentLen): bool
    {
        if (TokenType::NEWLINE !== $tokens->peek(1)?->type) {
            return false;
        }

        if (!$this->multilineContinuationHelper->isAnyContinuationAt($tokens, 2, $parentIndentLen)) {
            return false;
        }

        $targetNode->addChild(new NewLineNode($tokens->current()));
        $tokens->advance();

        return true;
    }

    private function tryConsumeIndentedContentLine(TokenStreamProxy $tokens, Node $targetNode, int $parentIndentLen): bool
    {
        if (!$this->multilineContinuationHelper->isIndentedMultilinePlainContinuationAt($tokens, 1, $parentIndentLen)) {
            return false;
        }

        $indentation = $tokens->peek(1);

        $targetNode->addChild(new NewLineNode($tokens->current()));
        $targetNode->addChild(new IndentationNode($indentation));
        $tokens->advance();
        $tokens->advance();
        $this->appendWhitespaceThenScalar($tokens, $targetNode);

        return true;
    }

    private function tryConsumeIndentedEmptyLineContinuation(TokenStreamProxy $tokens, Node $targetNode, int $parentIndentLen): bool
    {
        $newLine = $tokens->current();
        $maybeIndent = $tokens->peek(1);
        if (TokenType::INDENTATION !== $maybeIndent?->type || \strlen($maybeIndent->text) <= $parentIndentLen) {
            return false;
        }

        $afterIndentOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, 2);
        if (
            TokenType::NEWLINE !== $tokens->peek($afterIndentOffset)?->type
            || !$this->multilineContinuationHelper->isAnyContinuationAt($tokens, $afterIndentOffset + 1, $parentIndentLen)
        ) {
            return false;
        }

        $targetNode->addChild(new NewLineNode($newLine));
        $tokens->advance();
        $indentationToken = $tokens->current();
        if (TokenType::INDENTATION !== $indentationToken->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected INDENTATION after newline in multiline plain empty line, got %s', $indentationToken->type->value), $tokens));
        }
        $targetNode->addChild(new IndentationNode($indentationToken));
        $tokens->advance();
        for ($w = 2; $w < $afterIndentOffset; ++$w) {
            $wsToken = $tokens->current();
            if (TokenType::WHITESPACE !== $wsToken->type) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected WHITESPACE in multiline plain empty line, got %s', $wsToken->type->value), $tokens));
            }
            $targetNode->addChild(new WhitespaceNode($wsToken));
            $tokens->advance();
        }
        $closingNewline = $tokens->current();
        if (TokenType::NEWLINE !== $closingNewline->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE after multiline plain empty line content, got %s', $closingNewline->type->value), $tokens));
        }

        return true;
    }
}
