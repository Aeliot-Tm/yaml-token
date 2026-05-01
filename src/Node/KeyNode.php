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

class KeyNode extends AbstractNode
{
    private ?ExplicitKeyIndicatorNode $explicitKeyIndicatorNode = null;
    private ?Node $name = null;

    public function getExplicitKeyIndicatorNode(): ?ExplicitKeyIndicatorNode
    {
        return $this->explicitKeyIndicatorNode;
    }

    public function setExplicitKeyIndicator(ExplicitKeyIndicatorNode $node): void
    {
        $this->explicitKeyIndicatorNode = $node;
        $this->addChild($node);
    }

    public function setName(Node $node): void
    {
        $this->name = $node;
        $this->addChild($node);
    }

    public function getName(): ?Node
    {
        return $this->name;
    }

    public function isEmpty(): bool
    {
        return null === $this->name;
    }
}
