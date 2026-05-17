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

use Aeliot\YamlToken\Parser\Enum\ParsingContext;

final readonly class ContextFrame
{
    public function __construct(
        public ParsingContext $context,
        public int $indentLen = 0,
    ) {
    }
}
