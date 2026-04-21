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

use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\IndentationOverrideException;
use Aeliot\YamlToken\Parser\Exception\IndentationUndefinedException;

final class ParseState
{
    public ?int $indentStepLen = null;

    public function isIndentLenRegistered(): bool
    {
        return null !== $this->indentStepLen;
    }

    public function registerIndentStepLen(int $indentLen): void
    {
        if (null !== $this->indentStepLen) {
            throw new IndentationOverrideException('Indent step length is already registered');
        }

        if ($indentLen <= 0) {
            throw new IndentationInvalidException('Indent length must be positive');
        }

        $this->indentStepLen = $indentLen;
    }

    public function assertIndentLenIsValid(int $indentLen): void
    {
        if (null === $this->indentStepLen) {
            throw new IndentationUndefinedException('Indent step length is not registered yet');
        }

        if ($indentLen <= 0) {
            throw new IndentationInvalidException('Indent length must be positive');
        }

        if (0 !== ($indentLen % $this->indentStepLen)) {
            throw new IndentationInvalidException(\sprintf('Indentation must be multiple of %d, got %d', $this->indentStepLen, $indentLen));
        }
    }
}
