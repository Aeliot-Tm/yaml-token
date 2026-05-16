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

class TagDirectiveNode extends AbstractNode
{
    private TagDirectiveHandleNode $handleNode;
    private TagDirectiveIndicatorNode $indicatorNode;
    private TagDirectivePrefixNode $prefixNode;

    public function addChild(Node $child): void
    {
        if ($child instanceof TagDirectiveHandleNode) {
            $this->handleNode = $child;
        }
        if ($child instanceof TagDirectiveIndicatorNode) {
            $this->indicatorNode = $child;
        }
        if ($child instanceof TagDirectivePrefixNode) {
            $this->prefixNode = $child;
        }

        parent::addChild($child);
    }

    public function getHandle(): string
    {
        return $this->handleNode->getHandle();
    }

    public function getHandleNode(): TagDirectiveHandleNode
    {
        return $this->handleNode;
    }

    public function getIndicatorNode(): TagDirectiveIndicatorNode
    {
        return $this->indicatorNode;
    }

    public function getPrefix(): string
    {
        return $this->prefixNode->getPrefix();
    }

    public function getPrefixNode(): TagDirectivePrefixNode
    {
        return $this->prefixNode;
    }
}
