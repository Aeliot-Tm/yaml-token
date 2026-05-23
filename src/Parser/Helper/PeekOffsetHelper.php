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
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;

final readonly class PeekOffsetHelper
{
    /**
     * Returns the first peek offset >= $offset that is not a WHITESPACE token.
     */
    public function skipWhitespaceOffset(TokenStreamProxy $tokens, int $offset): int
    {
        while (TokenType::WHITESPACE === $tokens->peek($offset)?->type) {
            ++$offset;
        }

        return $offset;
    }
}
