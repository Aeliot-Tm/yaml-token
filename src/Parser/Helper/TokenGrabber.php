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
use Aeliot\YamlToken\Parser\Exception\InvalidArgumentException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class TokenGrabber
{
    public function __construct(
        private ErrorHelper $errorHelper,
    ) {
    }

    public function require(TokenStreamInterface $tokens, TokenType ...$types): Token
    {
        if (!$types) {
            throw new InvalidArgumentException('Types for the grabbing are required');
        }

        $token = $tokens->current();
        if (!\in_array($token?->type, $types, true)) {
            $exceptionMessage = \sprintf(
                'Expected %s token, but %s given',
                implode(' or ', array_map(static fn (TokenType $x): string => $x->value, $types)),
                $token?->type->value ?? '_nothing_'
            );
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation($exceptionMessage, $tokens));
        }
        $tokens->advance();

        return $token;
    }
}
