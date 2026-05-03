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

use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;

class KeyNode extends AbstractNode
{
    private ?ExplicitKeyIndicatorNode $explicitKeyIndicatorNode = null;
    private ?Node $name = null;
    private ?NodePropertiesNode $properties = null;

    public function addScalarName(ScalarNode $node): void
    {
        if (null === $this->name) {
            $this->name = $node;
        } elseif ($this->name instanceof ScalarNode) {
            $multilinePlainScalar = new MultilinePlainScalarNode();
            $multilinePlainScalar->addChild($this->name);
            $multilinePlainScalar->addChild($node);
            $this->name = $multilinePlainScalar;
        } else {
            $this->name->addChild($node);
        }

        $this->addChild($node);
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->properties?->getAnchor();
    }

    public function getExplicitKeyIndicatorNode(): ?ExplicitKeyIndicatorNode
    {
        return $this->explicitKeyIndicatorNode;
    }

    public function setExplicitKeyIndicator(ExplicitKeyIndicatorNode $node): void
    {
        $this->explicitKeyIndicatorNode = $node;
        $this->addChild($node);
    }

    public function getName(): ?Node
    {
        return $this->name;
    }

    public function setName(Node $node): void
    {
        if (null !== $this->name) {
            throw new UnexpectedStateException('Attempt to set a key name twice');
        }

        $this->name = $node;
        $this->addChild($node);
    }

    public function getProperties(): ?NodePropertiesNode
    {
        return $this->properties;
    }

    public function setProperties(NodePropertiesNode $node): void
    {
        $this->properties = $node;
        $this->addChild($node);
    }

    public function getTag(): ?TagNode
    {
        return $this->properties?->getTag();
    }

    public function isEmpty(): bool
    {
        return null === $this->name;
    }
}
