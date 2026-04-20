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

final class ParseState
{
    public ?int $indentStepLen = null;

    public function isIndentLenRegistered(): bool
    {
        return null !== $this->indentStepLen;
    }

    public function registerIndentStepLen(int $indentLen): void
    {
        if ($indentLen <= 0) {
            throw new \LogicException('Indent length must be positive');
        }

        if (null !== $this->indentStepLen) {
            throw new \LogicException('Indent step length is already registered');
        }

        $this->indentStepLen = $indentLen;
    }

    public function assertIndentLenIsValid(int $indentLen): void
    {
        if ($indentLen <= 0) {
            throw new \LogicException('Indent length must be positive');
        }

        if (null === $this->indentStepLen) {
            throw new \LogicException('Indent step length is not registered yet');
        }

        if (0 !== ($indentLen % $this->indentStepLen)) {
            throw new \LogicException(\sprintf('Indentation must be multiple of %d, got %d', $this->indentStepLen, $indentLen));
        }
    }
}
