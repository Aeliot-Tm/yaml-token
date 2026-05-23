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

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class Consumer
{
    private const TOKEN_TYPES_SPACE_AND_COMMENT = [
        TokenType::COMMENT,
        TokenType::WHITESPACE,
    ];

    private const TOKEN_TYPES_SPACE_COMMENT_END = [
        TokenType::COMMENT,
        TokenType::NEWLINE,
        TokenType::WHITESPACE,
    ];

    public function __construct(
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    public function collectSpaceAndComments(TokenStreamInterface $tokens, Node $root): void
    {
        $this->collectTypes($tokens, self::TOKEN_TYPES_SPACE_AND_COMMENT, $root);
    }

    public function collectSpaceCommentEnds(TokenStreamInterface $tokens, Node $root): void
    {
        $this->collectTypes($tokens, self::TOKEN_TYPES_SPACE_COMMENT_END, $root);
    }

    /**
     * @param TokenType[] $types
     */
    public function collectTypes(TokenStreamInterface $tokens, array $types, Node $root): void
    {
        while (true) {
            $token = $tokens->current();
            if (null === $token) {
                break;
            }
            if (\in_array($token->type, $types, true)) {
                $root->addChild($this->nodeFactory->createSimpleNode($token));
                $tokens->advance();
                continue;
            }
            break;
        }
    }

    public function collectUntil(TokenStreamInterface $tokens, TokenType $until, Node $root): void
    {
        while (true) {
            $token = $tokens->current();
            if (null === $token || $token->type === $until) {
                break;
            }
            $root->addChild($this->nodeFactory->createSimpleNode($token));
            $tokens->advance();
        }
    }

    /**
     * Consumes trailing "empty" indented lines after the first block scalar payload line
     * (YAML 1.2.2 §8.1.1.2 / rule [166]-[168] l-chomped-empty(n,t)).
     */
    public function consumeTrailingEmptyLines(TokenStreamInterface $tokens, Node $target): void
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

            $emptyLineSpace = $tokens->current();
            while (TokenType::WHITESPACE === $emptyLineSpace?->type) {
                $target->addChild($this->nodeFactory->createSimpleNode($emptyLineSpace));
                $tokens->advance();
                $emptyLineSpace = $tokens->current();
            }
        }
    }
}
