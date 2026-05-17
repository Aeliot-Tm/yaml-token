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
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;

final readonly class LookAheadHelper
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    public function collectInsignificantIndentationLines(TokenStreamProxy $tokens, Node $root): void
    {
        while ($this->isInsignificantIndentationLine($tokens)) {
            $token = $tokens->current();
            $root->addChild(new IndentationNode($token));
            $tokens->advance();
            $this->consumer->collectSpaceCommentEnds($tokens, $root);
        }
    }

    public function isInsignificantIndentationLine(TokenStreamProxy $tokens): bool
    {
        if (TokenType::INDENTATION !== $tokens->current()?->type) {
            return false;
        }

        for ($offset = 1;; ++$offset) {
            $token = $tokens->peek($offset);
            if (null === $token || TokenType::NEWLINE === $token->type) {
                return true;
            }
            if (TokenType::COMMENT !== $token->type && TokenType::WHITESPACE !== $token->type) {
                return false;
            }
        }
    }

    /**
     * @return array{int, \Aeliot\YamlToken\Token\Token, int}|null
     */
    public function peekFirstSignificantBlockHead(TokenStreamProxy $tokens, int $offset = 1): ?array
    {
        while (true) {
            $token = $tokens->peek($offset);
            if (null === $token) {
                return null;
            }

            if (TokenType::NEWLINE === $token->type) {
                ++$offset;
                continue;
            }

            $hasIndentation = TokenType::INDENTATION === $token->type;
            $indentLen = $hasIndentation ? \strlen($token->text) : 0;
            $probe = $hasIndentation ? $offset + 1 : $offset;

            while (true) {
                $candidate = $tokens->peek($probe);
                if (null === $candidate || TokenType::NEWLINE === $candidate->type) {
                    $offset = null === $candidate ? $probe : $probe + 1;
                    continue 2;
                }
                if (TokenType::COMMENT !== $candidate->type && TokenType::WHITESPACE !== $candidate->type) {
                    return [$indentLen, $candidate, $probe];
                }
                ++$probe;
            }
        }
    }
}
