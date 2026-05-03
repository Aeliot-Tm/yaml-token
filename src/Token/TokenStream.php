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

namespace Aeliot\YamlToken\Token;

use Aeliot\YamlToken\Enum\TokenType;

final class TokenStream
{
    private int $position = 0;

    /**
     * @var list<Token>
     */
    private array $tokens = [];

    public function addToken(Token $token): void
    {
        $this->tokens[] = $token;
    }

    public function advance(): ?Token
    {
        $token = $this->current();
        if (null !== $token) {
            ++$this->position;
        }

        return $token;
    }

    public function current(): ?Token
    {
        return $this->tokens[$this->position] ?? null;
    }

    public function getLength(): int
    {
        return \count($this->tokens);
    }

    /**
     * @return list<Token>
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function isEnd(): bool
    {
        return $this->position >= \count($this->tokens);
    }

    public function peek(int $offset): ?Token
    {
        $index = $this->position + $offset;

        return $this->tokens[$index] ?? null;
    }

    /**
     * Replaces the token at the current position with two consecutive tokens whose
     * concatenated text equals the original one. Used for parser-side disambiguation,
     * e.g. JSON-style adjacent value separator inside flow sequences (YAML 1.2.2 rule [153]).
     */
    public function splitCurrent(TokenType $headType, int $headLen, TokenType $tailType): void
    {
        $current = $this->current();
        if (null === $current) {
            throw new \LogicException('Cannot split: no current token');
        }

        $textLen = \strlen($current->text);
        if ($headLen <= 0 || $headLen >= $textLen) {
            throw new \LogicException(\sprintf('Invalid head length %d for token text of length %d', $headLen, $textLen));
        }

        $head = new Token(
            $headType,
            substr($current->text, 0, $headLen),
            $current->line,
            $current->column,
        );
        $tail = new Token(
            $tailType,
            substr($current->text, $headLen),
            $current->line,
            $current->column + $headLen,
        );

        array_splice($this->tokens, $this->position, 1, [$head, $tail]);
    }
}
