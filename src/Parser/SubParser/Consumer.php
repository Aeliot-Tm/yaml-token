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

namespace Aeliot\YamlToken\Parser\SubParser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Exception\InvalidArgumentException;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\TokenGrabber;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class Consumer
{
    public function __construct(
        private NodeFactory $nodeFactory,
        private TokenGrabber $tokenGrabber,
    ) {
    }

    public function collectSpaceAndComments(TokenStreamInterface $tokens, Node $root): void
    {
        $this->collectTypes($tokens, $root, TokenType::COMMENT, TokenType::WHITESPACE);
    }

    public function collectSpaceCommentEnds(TokenStreamInterface $tokens, Node $root): void
    {
        $this->collectTypes($tokens, $root, TokenType::COMMENT, TokenType::NEWLINE, TokenType::WHITESPACE);
    }

    public function collectSpaceValueIndicator(TokenStreamInterface $tokens, Node $root): void
    {
        $this->collectTypes($tokens, $root, TokenType::VALUE_INDICATOR, TokenType::WHITESPACE);
    }

    public function collectTypes(TokenStreamInterface $tokens, Node $root, TokenType ...$types): void
    {
        if (!$types) {
            throw new InvalidArgumentException('Types for the collecting are required');
        }

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

    public function collectWhitespace(TokenStreamInterface $tokens, Node $root): void
    {
        $this->collectTypes($tokens, $root, TokenType::WHITESPACE);
    }

    public function collectUntil(TokenStreamInterface $tokens, Node $root, TokenType $until): void
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

    public function grab(TokenStreamInterface $tokens, Node $root, TokenType $tokenType): void
    {
        $root->addChild($this->nodeFactory->createSimpleNode($this->tokenGrabber->current($tokens, $tokenType)));
    }
}
