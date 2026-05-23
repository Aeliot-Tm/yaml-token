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
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;

final readonly class BlockScalarParser
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private MultilinePlainScalarParser $multilinePlainScalarParser,
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    /**
     * Consumes a block scalar (literal | or folded >) used as an explicit mapping key
     * (YAML 1.2.2 §8.2.2 c-l-block-map-explicit-key). Tokens consumed:
     * BLOCK_SCALAR_INDICATOR, optional sub-indicators (chomping/indentation), NEWLINE,
     * optional leading empty lines, optional INDENTATION, and the scalar payload.
     * The resulting scalar node is set as the {@see KeyNode::setName() name} of the key.
     */
    public function consumeBlockScalarKeyName(TokenStreamProxy $tokens, KeyNode $keyNode): void
    {
        $scalar = $this->consumeBlockScalarFirstFragment($tokens, $keyNode, failOnTruncatedStream: true);
        $keyNode->setName($scalar);
    }

    /**
     * Consumes a block scalar (literal | or folded >) used as a mapping value
     * (YAML 1.2.2 §8.1.1). The first fragment and trailing empty lines are attached to
     * {@see ValueNode}; non-empty continuation lines are appended via
     * {@see MultilinePlainScalarParser::appendMultilinePlainScalarContinuations()}.
     */
    public function consumeBlockScalarValue(
        TokenStreamProxy $tokens,
        ValueNode $valueNode,
        int $parentIndentLen,
    ): void {
        $scalar = $this->consumeBlockScalarFirstFragment($tokens, $valueNode, failOnTruncatedStream: false);
        if (null === $scalar) {
            return;
        }

        $valueNode->addChild($scalar);
        $this->multilinePlainScalarParser->appendMultilinePlainScalarContinuations($tokens, $valueNode, $parentIndentLen);
    }

    /**
     * Builds the {@see KeyNode} name for the explicit-block-key path where the key starts on a new line
     * after the `?` indicator (YAML 1.2.2 §8.2.2). Consumes the first NEWLINE + INDENTATION + PLAIN_SCALAR
     * line and any subsequent continuation lines. When only a single scalar fragment is present, the
     * leading layout (NEWLINE / INDENTATION / WHITESPACE) is attached directly to the {@see KeyNode}
     * and the name becomes a plain {@see ScalarNode}; otherwise the whole sequence is wrapped in a
     * {@see MultilinePlainScalarNode}.
     */
    public function consumeExplicitKeyMultilinePlainScalar(TokenStreamProxy $tokens, KeyNode $keyNode, int $entryIndentLen): void
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

    public function tryConsumeExplicitKeyMultilinePlainScalarLine(
        TokenStreamProxy $tokens,
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

    private function consumeBlockScalarFirstFragment(
        TokenStreamProxy $tokens,
        Node $layoutTarget,
        bool $failOnTruncatedStream,
    ): ?ScalarNode {
        $token = $tokens->current();
        $layoutTarget->addChild(new BlockScalarIndicatorNode($token));
        $tokens->advance();

        $this->consumer->collectUntil($tokens, TokenType::NEWLINE, $layoutTarget);

        $token = $tokens->current();
        if (null === $token) {
            if ($failOnTruncatedStream) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation('Expected NEWLINE after block scalar indicator, got _nothing_', $tokens));
            }

            return null;
        }

        if (TokenType::NEWLINE !== $token->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE after block scalar indicator, got %s', $token->type->value), $token));
        }
        $layoutTarget->addChild(new NewLineNode($token));
        $tokens->advance();

        while (TokenType::NEWLINE === $tokens->current()?->type) {
            $layoutTarget->addChild(new NewLineNode($tokens->current()));
            $tokens->advance();
        }

        // YAML 1.2.2 §8.1.1.1: with an explicit indentation indicator (|N, >N, |N-, >N+, ...),
        // the body may start with leading spaces that are part of the content but surface
        // to the parser as a separate INDENTATION token before the scalar payload.
        if (TokenType::INDENTATION === $tokens->current()?->type) {
            $layoutTarget->addChild(new IndentationNode($tokens->current()));
            $tokens->advance();
        }

        $token = $tokens->current();
        if (null === $token || !$token->type->isScalar()) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected scalar payload for block scalar, got %s', $token?->type->value ?? '_nothing_'), $token));
        }

        $scalarNode = $this->nodeFactory->createScalarNode($token);
        $tokens->advance();

        // YAML 1.2.2 §8.1.1.2 / rule [166]-[168] l-chomped-empty(n,t):
        // trailing "empty" indented lines belong to the block scalar and must be
        // consumed here (even with strip chomping they are excluded from content but
        // still consumed from the token stream).
        $this->consumer->consumeTrailingEmptyLines($tokens, $layoutTarget);

        return $scalarNode;
    }

    private function consumeExplicitKeyMultilinePlainScalarLine(
        TokenStreamProxy $tokens,
        MultilinePlainScalarNode $multiline,
        int $entryIndentLen,
    ): void {
        if (!$this->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
            $token = $tokens->current();
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE to start indented explicit key plain scalar, got %s', $token?->type->value ?? '_nothing_'), $tokens));
        }
    }
}
