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

interface NodeVisitorInterface
{
    /**
     * @return Node|null Returns nothing or restructured tree
     */
    public function afterTraverse(Node $root): ?Node;

    /**
     * @return Node|null Returns nothing or restructured tree
     */
    public function beforeTraverse(Node $root): ?Node;

    /**
     * @return NodeVisitorSignal|null One of {@see NodeVisitorSignal::DontTraverseChildren}, {@see NodeVisitorSignal::StopTraversal}, or null
     */
    public function enterNode(Node $node): ?NodeVisitorSignal;

    /**
     * @return NodeVisitorSignal|null {@see NodeVisitorSignal::StopTraversal} or null
     */
    public function leaveNode(Node $node): ?NodeVisitorSignal;
}
