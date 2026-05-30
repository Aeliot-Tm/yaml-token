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

class TagDefinitionNode extends AbstractNode
{
    private ?TagHandleNode $handleNode = null;
    private ?TagDirectiveNode $indicatorNode = null;
    private ?TagDirectivePrefixNode $prefixNode = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof TagHandleNode) {
            $this->handleNode = $child;
        }
        if ($child instanceof TagDirectiveNode) {
            $this->indicatorNode = $child;
        }
        if ($child instanceof TagDirectivePrefixNode) {
            $this->prefixNode = $child;
        }

        parent::addChild($child);
    }

    public function getHandle(): ?string
    {
        return $this->handleNode?->getHandle();
    }

    public function getHandleNode(): ?TagHandleNode
    {
        return $this->handleNode;
    }

    public function getIndicatorNode(): ?TagDirectiveNode
    {
        return $this->indicatorNode;
    }

    public function getPrefix(): string
    {
        return $this->prefixNode->getPrefix();
    }

    public function getPrefixNode(): ?TagDirectivePrefixNode
    {
        return $this->prefixNode;
    }

    public function removeChild(Node $child): void
    {
        if ($this->handleNode === $child) {
            $this->handleNode = null;
        } elseif ($this->indicatorNode === $child) {
            $this->indicatorNode = null;
        } elseif ($this->prefixNode === $child) {
            $this->prefixNode = null;
        }

        parent::removeChild($child);
    }
}
