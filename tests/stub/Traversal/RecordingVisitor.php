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

namespace Aeliot\YamlToken\TestStub\Traversal;

use Aeliot\YamlToken\Enum\NodeVisitorSignal;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Traversal\NodeVisitorAbstract;

final class RecordingVisitor extends NodeVisitorAbstract
{
    /** @var list<string> */
    public array $events = [];

    public function __construct(
        private readonly string $prefix = '',
    ) {
    }

    public function afterTraverse(Node $root): ?Node
    {
        $this->events[] = $this->format('after', $root);

        return null;
    }

    public function beforeTraverse(Node $root): ?Node
    {
        $this->events[] = $this->format('before', $root);

        return null;
    }

    public function enterNode(Node $node): ?NodeVisitorSignal
    {
        $this->events[] = $this->format('enter', $node);

        return null;
    }

    public function leaveNode(Node $node): ?NodeVisitorSignal
    {
        $this->events[] = $this->format('leave', $node);

        return null;
    }

    private function format(string $phase, Node $node): string
    {
        $label = $phase.':'.$node::class;

        if ('' === $this->prefix) {
            return $label;
        }

        return $this->prefix.':'.$label;
    }
}
