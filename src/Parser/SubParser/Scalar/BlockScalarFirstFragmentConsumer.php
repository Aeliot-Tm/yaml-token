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
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Parser\SubParser\Consumer;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class BlockScalarFirstFragmentConsumer
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    /**
     * Consumes a block scalar (literal | or folded >) indicator line and the first scalar fragment.
     * Tokens consumed: BLOCK_SCALAR_INDICATOR, optional sub-indicators (chomping/indentation), NEWLINE,
     * optional leading empty lines, optional INDENTATION, and the scalar payload.
     * Returns the assembled entry node. When the stream is truncated and $failOnTruncatedStream is false,
     * returns a partial entry containing only the options (no scalar payload).
     */
    public function consume(TokenStreamInterface $tokens): BlockScalarEntryNode
    {
        $options = new BlockScalarOptionsNode();

        $this->consumer->grabOneOf($tokens, $options, ...TokenType::BLOCK_SCALAR_INDICATORS);
        $this->consumer->collectUntil($tokens, $options, TokenType::NEWLINE);

        $entry = new BlockScalarEntryNode();
        $entry->addChild($options);

        $token = $tokens->current();
        if (null === $token) {
            return $entry;
        }

        $this->consumer->grab($tokens, $entry, TokenType::NEWLINE);
        $this->consumer->collectTypes($tokens, $entry, TokenType::NEWLINE);

        // YAML 1.2.2 §8.1.1.1: with an explicit indentation indicator (|N, >N, |N-, >N+, ...),
        // the body may start with leading spaces that are part of the content but surface
        // to the parser as a separate INDENTATION token before the scalar payload.
        $this->consumer->collectTypes($tokens, $entry, TokenType::INDENTATION);

        $token = $tokens->current();
        if (null === $token || !$token->type->isScalar()) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected scalar payload for block scalar, got %s', $token?->type->value ?? '_nothing_'), $token));
        }

        $scalarNode = $this->nodeFactory->createScalarNode($token);
        $tokens->advance();

        $entry->addChild($scalarNode);

        // YAML 1.2.2 §8.1.1.2 / rule [166]-[168] l-chomped-empty(n,t):
        // trailing "empty" indented lines belong to the block scalar and must be
        // consumed here (even with strip chomping they are excluded from content but
        // still consumed from the token stream).
        $this->consumeTrailingEmptyLines($tokens, $entry);

        return $entry;
    }

    /**
     * Consumes trailing "empty" indented lines after the first block scalar payload line
     * (YAML 1.2.2 §8.1.1.2 / rule [166]-[168] l-chomped-empty(n,t)).
     */
    private function consumeTrailingEmptyLines(TokenStreamInterface $tokens, Node $target): void
    {
        while (true) {
            $newLineToken = $tokens->current();
            if (TokenType::NEWLINE !== $newLineToken?->type) {
                break;
            }

            $indentationToken = $tokens->peek(1);
            if (TokenType::INDENTATION !== $indentationToken?->type) {
                break;
            }

            $probe = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, 2);

            $afterIndentation = $tokens->peek($probe);
            if (null !== $afterIndentation && TokenType::NEWLINE !== $afterIndentation->type) {
                break;
            }

            $target->addChild($this->nodeFactory->createSimpleNode($newLineToken));
            $tokens->advance();
            $target->addChild($this->nodeFactory->createSimpleNode($indentationToken));
            $tokens->advance();

            $this->consumer->collectWhitespace($tokens, $target);
        }
    }
}
