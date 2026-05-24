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
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class MultilinePlainScalarParser
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
    public function appendMultilinePlainScalarContinuations(TokenStreamInterface $tokens, Node $targetNode, IndentContext $parentIndent): void
    {
        while (true) {
            $this->consumeTrailingWhitespaceBeforeNewline($tokens, $targetNode);

            if (TokenType::NEWLINE !== $tokens->current()?->type) {
                break;
            }

            if ($this->tryConsumeBlankLineContinuation($tokens, $targetNode, $parentIndent)) {
                continue;
            }
            if ($this->tryConsumeIndentedEmptyLineContinuation($tokens, $targetNode, $parentIndent)) {
                continue;
            }
            if ($this->tryConsumeIndentedContentLine($tokens, $targetNode, $parentIndent)) {
                continue;
            }
            if ($this->tryConsumeBareDocumentFlushLine($tokens, $targetNode, $parentIndent)) {
                continue;
            }

            break;
        }
    }

    public function buildExplicitBlockKeyMultilinePlainScalarName(
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

    /**
     * Builds the {@see KeyNode} name node for a leading scalar key token, eagerly
     * consuming any multiline plain-scalar continuation lines.
     */
    public function buildScalarKeyName(
        TokenStreamInterface $tokens,
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
            return $this->registry->getFlowMultilinePlainScalarHelper()->buildFlowKeyMultilinePlainScalarName($tokens, $head);
        }

        if ($hasExplicitKeyIndicator) {
            return $this->buildExplicitBlockKeyMultilinePlainScalarName($tokens, $head, $entryIndentLen);
        }

        return $head;
    }

    /**
     * Builds the {@see KeyNode} name for the explicit-block-key path where the key starts on a new line
     * after the `?` indicator (YAML 1.2.2 §8.2.2). Consumes the first NEWLINE + INDENTATION + PLAIN_SCALAR
     * line and any subsequent continuation lines. When only a single scalar fragment is present, the
     * leading layout (NEWLINE / INDENTATION / WHITESPACE) is attached directly to the {@see KeyNode}
     * and the name becomes a plain {@see ScalarNode}; otherwise the whole sequence is wrapped in a
     * {@see MultilinePlainScalarNode}.
     */
    public function consumeExplicitKeyMultilinePlainScalar(TokenStreamInterface $tokens, KeyNode $keyNode, int $entryIndentLen): void
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

    private function appendWhitespaceThenScalar(TokenStreamInterface $tokens, Node $targetNode): void
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

    private function consumeTrailingWhitespaceBeforeNewline(TokenStreamInterface $tokens, Node $targetNode): void
    {
        while (
            TokenType::WHITESPACE === $tokens->current()?->type
            && TokenType::NEWLINE === $tokens->peek(1)?->type
        ) {
            $targetNode->addChild(new WhitespaceNode($tokens->current()));
            $tokens->advance();
        }
    }

    private function tryConsumeBareDocumentFlushLine(TokenStreamInterface $tokens, Node $targetNode, IndentContext $parentIndent): bool
    {
        if (
            !$parentIndent->isBareDocumentRoot
            || !$this->multilineContinuationHelper->isBareDocumentFlushMultilinePlainContinuationAt($tokens, 1)
        ) {
            return false;
        }

        $targetNode->addChild(new NewLineNode($tokens->current()));
        $tokens->advance();
        $this->appendWhitespaceThenScalar($tokens, $targetNode);

        return true;
    }

    private function tryConsumeBlankLineContinuation(TokenStreamInterface $tokens, Node $targetNode, IndentContext $parentIndent): bool
    {
        if (TokenType::NEWLINE !== $tokens->peek(1)?->type) {
            return false;
        }

        if (!$this->multilineContinuationHelper->isAnyContinuationAt($tokens, 2, $parentIndent)) {
            return false;
        }

        $targetNode->addChild(new NewLineNode($tokens->current()));
        $tokens->advance();

        return true;
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

        $keyProbe = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $scalarOffset + 1);
        if (TokenType::VALUE_INDICATOR === $tokens->peek($keyProbe)?->type) {
            return false;
        }

        $multiline->addChild(new NewLineNode($newLine));
        $multiline->addChild(new IndentationNode($indentation));
        $tokens->advance();
        $tokens->advance();

        $contentHead = $tokens->current();
        while (TokenType::WHITESPACE === $contentHead->type) {
            $multiline->addChild(new WhitespaceNode($contentHead));
            $tokens->advance();
            $contentHead = $tokens->current();
        }

        $multiline->addChild($this->nodeFactory->createScalarNode($contentHead));
        $tokens->advance();

        return true;
    }

    private function tryConsumeIndentedContentLine(TokenStreamInterface $tokens, Node $targetNode, IndentContext $parentIndent): bool
    {
        if (!$this->multilineContinuationHelper->isIndentedMultilinePlainContinuationAt($tokens, 1, $parentIndent)) {
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

    private function tryConsumeIndentedEmptyLineContinuation(TokenStreamInterface $tokens, Node $targetNode, IndentContext $parentIndent): bool
    {
        $newLine = $tokens->current();
        $maybeIndent = $tokens->peek(1);
        if (TokenType::INDENTATION !== $maybeIndent?->type || \strlen($maybeIndent->text) <= $parentIndent->indentLen) {
            return false;
        }

        $afterIndentOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, 2);
        if (
            TokenType::NEWLINE !== $tokens->peek($afterIndentOffset)?->type
            || !$this->multilineContinuationHelper->isAnyContinuationAt($tokens, $afterIndentOffset + 1, $parentIndent)
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
