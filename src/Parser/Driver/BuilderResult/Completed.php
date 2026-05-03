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

namespace Aeliot\YamlToken\Parser\Driver\BuilderResult;

use Aeliot\YamlToken\Node\Node;

final class Completed implements BuilderResultInterface
{
    public function __construct(
        public readonly Node $node,
    ) {
    }
}
