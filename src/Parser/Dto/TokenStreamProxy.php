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

namespace Aeliot\YamlToken\Parser\Dto;

use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;
use Aeliot\YamlToken\Token\TokenStreamInterface;

/**
 * @deprecated use TokenStream (TokenStreamInterface)
 */
final class TokenStreamProxy implements TokenStreamInterface
{
    private TokenStream $inner;

    public function __construct(TokenStream $inner)
    {
        $this->inner = $inner;
    }

    public function advance(): ?Token
    {
        return $this->inner->advance();
    }

    public function current(): ?Token
    {
        return $this->inner->current();
    }

    public function addToken(Token $token): void
    {
        $this->inner->addToken($token);
    }

    public function getLength(): int
    {
        return $this->inner->getLength();
    }

    public function getTokens(): array
    {
        return $this->inner->getTokens();
    }

    public function isEnd(): bool
    {
        return $this->inner->isEnd();
    }

    public function peek(int $offset): ?Token
    {
        return $this->inner->peek($offset);
    }

    public function getLastObservedColumn(): ?int
    {
        return $this->inner->getLastObservedColumn();
    }

    public function getLastObservedLine(): ?int
    {
        return $this->inner->getLastObservedLine();
    }
}
