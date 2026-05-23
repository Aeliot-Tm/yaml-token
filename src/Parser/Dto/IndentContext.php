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
 * Carries the parent indentation context for block-value parsing:
 * either a real block indent length, the bare-document root marker
 * (YAML 1.2.2 rule [211], n = -1), or the flow-collection context
 * for values nested inside flow structures.
 *
 * Use the named flags {@see self::$isBareDocumentRoot} and
 * {@see self::$isFlowCollection} for context checks instead of
 * comparing {@see self::$indentLen} against magic numbers.
 */
final readonly class IndentContext
{
    private function __construct(
        public int $indentLen,
        public bool $isBareDocumentRoot,
        public bool $isFlowCollection,
    ) {
    }

    public static function createForBareDocument(): self
    {
        return new self(-1, true, false);
    }

    public static function createForBlock(int $indent): self
    {
        return new self($indent, false, false);
    }

    public static function createForFlow(): self
    {
        return new self(-2, false, true);
    }
}
