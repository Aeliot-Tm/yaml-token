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

namespace Aeliot\YamlToken\TestHelper\Parser\Driver;

use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Driver\BuilderInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\BuilderResultInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Completed;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Delegate;
use Aeliot\YamlToken\Parser\Driver\Frame;
use Aeliot\YamlToken\Parser\Dto\Harvester;

final class TestMidDelegateBuilder implements BuilderInterface
{
    public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface
    {
        $self->node->addChild($child);

        return new Completed($self->node);
    }

    public function step(Harvester $harvester, Frame $self): BuilderResultInterface
    {
        $inner = new ValueNode();

        return new Delegate(new Frame(new TestLeafCompletedBuilder(), $inner));
    }
}
