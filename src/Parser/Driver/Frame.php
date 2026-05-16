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

namespace Aeliot\YamlToken\Parser\Driver;

use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\BuilderResultInterface;
use Aeliot\YamlToken\Parser\Dto\Harvester;

final class Frame
{
    public function __construct(
        public readonly BuilderInterface $builder,
        public readonly Node $node,
    ) {
    }

    public function onChildCompleted(Harvester $harvester, Node $child): BuilderResultInterface
    {
        return $this->builder->onChildCompleted($harvester, $this, $child);
    }

    public function step(Harvester $harvester): BuilderResultInterface
    {
        return $this->builder->step($harvester, $this);
    }
}
