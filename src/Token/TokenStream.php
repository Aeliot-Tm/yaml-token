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

final class TokenStream
{
    private int $position = 0;

    /**
     * @var list<Token>
     */
    private array $tokens = [];

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = max(0, min($position, \count($this->tokens)));
    }

    public function current(): ?Token
    {
        return $this->tokens[$this->position] ?? null;
    }

    public function peek(int $offset): ?Token
    {
        $index = $this->position + $offset;

        return $this->tokens[$index] ?? null;
    }

    public function advance(): ?Token
    {
        $token = $this->current();
        if (null !== $token) {
            ++$this->position;
        }

        return $token;
    }

    public function isEnd(): bool
    {
        return $this->position >= \count($this->tokens);
    }

    /**
     * @return list<Token>
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    public function addToken(Token $token): void
    {
        $this->tokens[] = $token;
    }

    public function getLength(): int
    {
        return \count($this->tokens);
    }
}
