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

/**
 * Wraps {@see TokenStream} and records the last non-null token returned from
 * {@see self::current()} and {@see self::advance()} for parser error locations.
 *
 * @mixin TokenStream
 */
final class TokenStreamProxy
{
    private TokenStream $inner;

    private ?Token $lastObserved = null;

    /**
     * @param array<int, mixed> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        return $this->inner->{$name}(...$arguments);
    }

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

    public function getColumn(): ?int
    {
        return $this->lastObserved?->column;
    }

    public function getLine(): ?int
    {
        return $this->lastObserved?->line;
    }
}
