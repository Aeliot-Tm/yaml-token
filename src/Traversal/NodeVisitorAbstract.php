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

namespace Aeliot\YamlToken\Traversal;

use Aeliot\YamlToken\Enum\NodeVisitorSignal;
use Aeliot\YamlToken\Node\Node;

abstract class NodeVisitorAbstract implements NodeVisitorInterface
{
    public function afterTraverse(Node $root): ?Node
    {
        return null;
    }

    public function beforeTraverse(Node $root): ?Node
    {
        return null;
    }

    public function enterNode(Node $node): ?NodeVisitorSignal
    {
        return null;
    }

    public function leaveNode(Node $node): ?NodeVisitorSignal
    {
        return null;
    }
}
