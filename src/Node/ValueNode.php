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

class ValueNode extends AbstractNode
{
    private ?AnchorNode $anchor = null;
    private ?BlockMappingNode $blockMapping = null;
    private ?ScalarNode $scalar = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof AnchorNode) {
            $this->anchor = $child;
        }

        if ($child instanceof BlockMappingNode) {
            $this->blockMapping = $child;
        }

        if ($child instanceof ScalarNode) {
            $this->scalar = $child;
        }

        parent::addChild($child);
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->anchor;
    }

    public function getScalar(): ?ScalarNode
    {
        return $this->scalar;
    }

    public function getBlockMapping(): ?BlockMappingNode
    {
        return $this->blockMapping;
    }
}
