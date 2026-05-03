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

interface BuilderInterface
{
    public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface;

    public function step(Harvester $harvester, Frame $self): BuilderResultInterface;
}
