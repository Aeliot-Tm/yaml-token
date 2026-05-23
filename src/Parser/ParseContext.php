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

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;

final class ParseContext
{
    public function __construct(
        public readonly TokenStreamProxy $tokens,
        public readonly AnchorsRegistry $anchorsRegistry,
        public readonly ParseState $state,
    ) {
    }
}
