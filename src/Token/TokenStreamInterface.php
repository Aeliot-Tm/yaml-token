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

interface TokenStreamInterface
{
    public function addToken(Token $token): void;

    public function advance(): ?Token;

    public function current(): ?Token;

    public function getLength(): int;

    /**
     * @return list<Token>
     */
    public function getTokens(): array;

    public function isEnd(): bool;

    public function peek(int $offset): ?Token;
}
