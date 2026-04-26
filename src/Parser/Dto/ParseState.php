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
            // YAML does not prescribe a global indentation step size.
            // The parser validates indentation consistency locally (per block collection),
            // so the step length may remain undefined in some edge cases.
            return;
        }

        if ($indentLen <= 0) {
            throw new IndentationInvalidException('Indent length must be positive');
        }
    }
}
