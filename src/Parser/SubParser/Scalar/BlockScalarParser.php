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
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\SubParser\Consumer;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class BlockScalarParser
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private MultilinePlainScalarParser $multilinePlainScalarParser,
        private NodeFactory $nodeFactory,
    ) {
    }

    /**
     * Consumes a block scalar (literal | or folded >) used as an explicit mapping key
     * (YAML 1.2.2 §8.2.2 c-l-block-map-explicit-key). Tokens consumed:
     * BLOCK_SCALAR_INDICATOR, optional sub-indicators (chomping/indentation), NEWLINE,
     * optional leading empty lines, optional INDENTATION, and the scalar payload.
     * The resulting scalar node is set as the {@see KeyNode::setName() name} of the key.
     */
    public function consumeBlockScalarKeyName(TokenStreamInterface $tokens, KeyNode $keyNode): void
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
        TokenStreamInterface $tokens,
        ValueNode $valueNode,
        IndentContext $parentIndent,
    ): void {
        $scalar = $this->consumeBlockScalarFirstFragment($tokens, $valueNode, failOnTruncatedStream: false);
        if (null === $scalar) {
            return;
        }

        $valueNode->addChild($scalar);
        $this->multilinePlainScalarParser->appendMultilinePlainScalarContinuations($tokens, $valueNode, $parentIndent);
    }

    private function consumeBlockScalarFirstFragment(
        TokenStreamInterface $tokens,
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
}
