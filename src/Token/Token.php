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

/**
 * @param int $line 1-based line number
 * @param int $column 1-based Unicode code point column on that line
 */
class Token
{
    public function __construct(
        public readonly TokenType $type,
        public string $text,
        public int $line,
        public int $column,
    ) {
    }
}
