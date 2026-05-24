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

namespace Aeliot\YamlToken\Parser\Helper;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class BlockMultilinePlainScalarHelper
{
    public function __construct(
        private ErrorHelper $errorHelper,
        private FlowMultilinePlainScalarHelper $flowMultilinePlainScalarHelper,
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
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
            return $this->flowMultilinePlainScalarHelper->buildFlowKeyMultilinePlainScalarName($tokens, $head);
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
}
