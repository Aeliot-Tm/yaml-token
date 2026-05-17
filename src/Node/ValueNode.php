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

class ValueNode extends AbstractNode
{
    private ?Node $payload = null;
    private ?NodePropertiesNode $properties = null;

    public function addChild(Node $child): void
    {
        if (
            $child instanceof AliasNode
            || $child instanceof BlockMappingNode
            || $child instanceof BlockSequenceNode
            || $child instanceof FlowMappingNode
            || $child instanceof FlowSequenceNode
            || $child instanceof KeyValueCoupleNode
            || $child instanceof MultilinePlainScalarNode
            || $child instanceof ScalarNode
        ) {
            if (null !== $this->payload) {
                throw new UnexpectedStateException('Attempt to set a value name twice');
            }
            $this->payload = $child;
        } elseif ($child instanceof NodePropertiesNode) {
            $this->properties = $child;
        }

        parent::addChild($child);
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->properties?->getAnchor();
    }

    public function getPayload(): ?Node
    {
        return $this->payload;
    }

    public function getProperties(): ?NodePropertiesNode
    {
        return $this->properties;
    }

    public function getTag(): ?TagNode
    {
        return $this->properties?->getTag();
    }

    public function isAlias(): bool
    {
        return $this->payload instanceof AliasNode;
    }

    public function isBlockMapping(): bool
    {
        return $this->payload instanceof BlockMappingNode;
    }

    public function isBlockSequence(): bool
    {
        return $this->payload instanceof BlockSequenceNode;
    }

    public function isEmpty(): bool
    {
        return null === $this->payload;
    }

    public function isFlowMapping(): bool
    {
        return $this->payload instanceof FlowMappingNode;
    }

    public function isFlowSequence(): bool
    {
        return $this->payload instanceof FlowSequenceNode;
    }

    public function isKeyValueCouple(): bool
    {
        return $this->payload instanceof KeyValueCoupleNode;
    }

    public function isMultilinePlainScalar(): bool
    {
        return $this->payload instanceof MultilinePlainScalarNode;
    }

    public function isScalar(): bool
    {
        return $this->payload instanceof ScalarNode;
    }

    public function removeChild(Node $child): void
    {
        if ($this->payload === $child) {
            $this->payload = null;
        } elseif ($this->properties === $child) {
            $this->properties = null;
        }

        parent::removeChild($child);
    }
}
