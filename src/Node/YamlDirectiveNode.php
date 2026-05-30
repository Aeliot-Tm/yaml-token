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

class YamlDirectiveNode extends AbstractNode
{
    private ?YamlDirectiveIndicatorNode $indicatorNode = null;
    private ?YamlVersionNode $versionNode = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof YamlDirectiveIndicatorNode) {
            $this->indicatorNode = $child;
        }
        if ($child instanceof YamlVersionNode) {
            $this->versionNode = $child;
        }

        parent::addChild($child);
    }

    public function getIndicatorNode(): ?YamlDirectiveIndicatorNode
    {
        return $this->indicatorNode;
    }

    public function getVersionNode(): ?YamlVersionNode
    {
        return $this->versionNode;
    }

    public function removeChild(Node $child): void
    {
        if ($this->indicatorNode === $child) {
            $this->indicatorNode = null;
        } elseif ($this->versionNode === $child) {
            $this->versionNode = null;
        }

        parent::removeChild($child);
    }
}
