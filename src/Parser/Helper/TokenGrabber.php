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
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class TokenGrabber
{
    public function __construct(
        private ErrorHelper $errorHelper,
    ) {
    }

    public function current(TokenStreamInterface $tokens, TokenType $tokenType): Token
    {
        $token = $tokens->current();
        if ($token?->type !== $tokenType) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected %s token, but %s given', $tokenType->value, $token?->type->value ?? '_nothing_'), $tokens));
        }
        $tokens->advance();

        return $token;
    }
}
