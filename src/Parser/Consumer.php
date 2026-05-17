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
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;

final readonly class Consumer
{
    private const TOKEN_TYPES_SPASE_AND_COMMENT = [
        TokenType::COMMENT,
        TokenType::WHITESPACE,
    ];

    private const TOKEN_TYPES_SPASE_COMMENT_END = [
        TokenType::COMMENT,
        TokenType::NEWLINE,
        TokenType::WHITESPACE,
    ];

    public function __construct(
        private NodeFactory $nodeFactory,
    ) {
    }

    public function collectSpaceAndComments(TokenStreamProxy $tokens, Node $root): void
    {
        $this->collectTypes($tokens, self::TOKEN_TYPES_SPASE_AND_COMMENT, $root);
    }

    public function collectSpaceCommentEnds(TokenStreamProxy $tokens, Node $root): void
    {
        $this->collectTypes($tokens, self::TOKEN_TYPES_SPASE_COMMENT_END, $root);
    }

    /**
     * @param TokenType[] $types
     */
    public function collectTypes(TokenStreamProxy $tokens, array $types, Node $root): void
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

    public function collectUntil(TokenStreamProxy $tokens, TokenType $until, Node $root): void
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
}
