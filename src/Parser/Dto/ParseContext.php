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

/**
 * Immutable parse context passed to flow builders. Defaults match flow-in-value
 * parsing (YAML 1.2.2 §7.4): parent indent sentinel -2, empty key/value allowed.
 *
 * TODO: consider to remove class ParseContext case no one `with-method` is used
 */
final class ParseContext
{
    public function __construct(
        public readonly bool $allowEmptyKey = true,
        public readonly bool $allowEmptyValue = true,
        public readonly bool $inFlow = true,
        public readonly int $parentIndentLen = -2,
    ) {
    }

    public function withAllowEmptyKey(bool $allowEmptyKey): self
    {
        return new self(
            $allowEmptyKey,
            $this->allowEmptyValue,
            $this->inFlow,
            $this->parentIndentLen,
        );
    }

    public function withAllowEmptyValue(bool $allowEmptyValue): self
    {
        return new self(
            $this->allowEmptyKey,
            $allowEmptyValue,
            $this->inFlow,
            $this->parentIndentLen,
        );
    }

    public function withInFlow(bool $inFlow): self
    {
        return new self(
            $this->allowEmptyKey,
            $this->allowEmptyValue,
            $inFlow,
            $this->parentIndentLen,
        );
    }

    public function withParentIndentLen(int $parentIndentLen): self
    {
        return new self(
            $this->allowEmptyKey,
            $this->allowEmptyValue,
            $this->inFlow,
            $parentIndentLen,
        );
    }
}
