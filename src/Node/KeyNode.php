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

    public function addChild(Node $child): void
    {
        if ($child instanceof ExplicitKeyIndicatorNode) {
            if (null !== $this->explicitKeyIndicatorNode) {
                throw new UnexpectedStateException('Attempt to set explicit key indicator twice');
            }
            $this->explicitKeyIndicatorNode = $child;
        } elseif ($child instanceof NodePropertiesNode) {
            if (null !== $this->properties) {
                throw new UnexpectedStateException('Attempt to set key indicator twice');
            }
            $this->properties = $child;
        }

        parent::addChild($child);
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->properties?->getAnchor();
    }

    public function getExplicitKeyIndicatorNode(): ?ExplicitKeyIndicatorNode
    {
        return $this->explicitKeyIndicatorNode;
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

    public function getTag(): ?TagNode
    {
        return $this->properties?->getTag();
    }

    public function isEmpty(): bool
    {
        return null === $this->name;
    }

    public function removeChild(Node $child): void
    {
        if ($this->explicitKeyIndicatorNode === $child) {
            $this->explicitKeyIndicatorNode = null;
        } elseif ($this->name === $child) {
            $this->name = null;
        } elseif ($this->properties === $child) {
            $this->properties = null;
        }

        parent::removeChild($child);
    }
}
