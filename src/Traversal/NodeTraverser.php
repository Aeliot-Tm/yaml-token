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

final class NodeTraverser implements NodeTraverserInterface
{
    /**
     * @var list<NodeVisitorInterface>
     */
    private array $visitors;

    private bool $stopTraversal = false;

    /**
     * @param NodeVisitorInterface ...$visitors Node visitors
     */
    public function __construct(NodeVisitorInterface ...$visitors)
    {
        $this->visitors = array_values($visitors);
    }

    public function addVisitor(NodeVisitorInterface $visitor): void
    {
        $this->visitors[] = $visitor;
    }

    public function removeVisitor(NodeVisitorInterface $visitor): void
    {
        $index = array_search($visitor, $this->visitors, true);
        if (false === $index) {
            return;
        }

        array_splice($this->visitors, $index, 1);
    }

    public function traverse(Node $root): void
    {
        $this->stopTraversal = false;

        foreach ($this->visitors as $visitor) {
            if (null !== $return = $visitor->beforeTraverse($root)) {
                $root = $return;
            }
        }

        $this->visitNode($root);

        for ($i = \count($this->visitors) - 1; $i >= 0; --$i) {
            if (null !== $return = $this->visitors[$i]->afterTraverse($root)) {
                $root = $return;
            }
        }
    }

    private function visitNode(Node $node): void
    {
        if ($this->stopTraversal) {
            return;
        }

        $traverseChildren = true;
        $lastEnterVisitorIndex = -1;
        $visitorCount = \count($this->visitors);

        for ($i = 0; $i < $visitorCount; ++$i) {
            $return = $this->visitors[$i]->enterNode($node);
            if (null === $return) {
                $lastEnterVisitorIndex = $i;
                continue;
            }

            switch ($return) {
                case NodeVisitorSignal::StopTraversal:
                    $this->stopTraversal = true;

                    return;
                case NodeVisitorSignal::DontTraverseChildren:
                    $traverseChildren = false;
                    $lastEnterVisitorIndex = $i;
            }
        }

        if ($traverseChildren) {
            foreach ($node->getChildren() as $child) {
                $this->visitNode($child);
                if ($this->stopTraversal) {
                    return;
                }
            }
        }

        if ($lastEnterVisitorIndex < 0) {
            return;
        }

        for ($i = $lastEnterVisitorIndex; $i >= 0; --$i) {
            $return = $this->visitors[$i]->leaveNode($node);
            if (null === $return) {
                continue;
            }

            if (NodeVisitorSignal::StopTraversal === $return) {
                $this->stopTraversal = true;

                return;
            }
        }
    }
}
