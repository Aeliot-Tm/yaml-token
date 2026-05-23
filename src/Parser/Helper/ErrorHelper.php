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

use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class ErrorHelper
{
    public function appendTokenLocation(string $message, Token|TokenStreamInterface $tokens): string
    {
        $line = $tokens instanceof Token ? $tokens->line : $tokens->getLastObservedLine();
        $column = $tokens instanceof Token ? $tokens->column : $tokens->getLastObservedColumn();
        if (null !== $line && null !== $column) {
            $message .= \sprintf(' in line %d column %d', $line, $column);
        }

        return $message;
    }

    /**
     * @throws \Exception
     */
    public function wrapParseStateIndentationException(\Exception $previous, TokenStreamInterface $tokens): never
    {
        throw new ($previous::class)($this->appendTokenLocation($previous->getMessage(), $tokens), (int) $previous->getCode(), $previous);
    }
}
