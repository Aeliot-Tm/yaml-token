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

namespace Aeliot\YamlToken\Parser\Helper\Identifier;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class SequenceIdentifier
{
    public function isSequenceStart(ParseContext $parseContext): bool
    {
        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $parseContext->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
    }
}
