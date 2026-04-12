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

namespace Aeliot\YamlToken\Node;

abstract class AbstractNode implements Node
{
    /**
     * @var Node[]
     */
    protected array $children = [];

    private ?Node $parent = null;

    public function addChild(Node $child): void
    {
        $this->children[] = $child;
        if ($child instanceof self) {
            $child->setParent($this);
        }
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getParent(): ?Node
    {
        return $this->parent;
    }

    public function setParent(Node $parent): void
    {
        $this->parent = $parent;
        $parent->addChild($this);
    }
}
