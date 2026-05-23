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
 * Wraps {@see TokenStream} and records the last non-null token returned from
 * {@see self::current()} and {@see self::advance()} for parser error locations.
 *
 * @mixin TokenStream
 */
final class TokenStreamProxy implements TokenStreamInterface
{
    private TokenStream $inner;

    private ?Token $lastObserved = null;

    public function __construct(TokenStream $inner)
    {
        $this->inner = $inner;
    }

    public function advance(): ?Token
    {
        $token = $this->inner->advance();
        if (null !== $token) {
            $this->lastObserved = $token;
        }

        return $token;
    }

    public function current(): ?Token
    {
        $token = $this->inner->current();
        if (null !== $token) {
            $this->lastObserved = $token;
        }

        return $token;
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

    public function getColumn(): ?int
    {
        return $this->lastObserved?->column;
    }

    public function getLine(): ?int
    {
        return $this->lastObserved?->line;
    }
}
