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

/**
 * TODO: simplify interface & add easy way to get type of value.
 */
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

    public function getAlias(): ?AliasNode
    {
        return $this->payload instanceof AliasNode ? $this->payload : null;
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->properties?->getAnchor();
    }

    public function getBlockMapping(): ?BlockMappingNode
    {
        return $this->payload instanceof BlockMappingNode ? $this->payload : null;
    }

    public function getBlockSequence(): ?BlockSequenceNode
    {
        return $this->payload instanceof BlockSequenceNode ? $this->payload : null;
    }

    public function getFlowMapping(): ?FlowMappingNode
    {
        return $this->payload instanceof FlowMappingNode ? $this->payload : null;
    }

    public function getFlowSequence(): ?FlowSequenceNode
    {
        return $this->payload instanceof FlowSequenceNode ? $this->payload : null;
    }

    public function getKeyValueCouple(): ?KeyValueCoupleNode
    {
        return $this->payload instanceof KeyValueCoupleNode ? $this->payload : null;
    }

    public function getMultilinePlainScalar(): ?MultilinePlainScalarNode
    {
        return $this->payload instanceof MultilinePlainScalarNode ? $this->payload : null;
    }

    public function getPayload(): ?Node
    {
        return $this->payload;
    }

    public function getProperties(): ?NodePropertiesNode
    {
        return $this->properties;
    }

    public function getScalar(): ?ScalarNode
    {
        return $this->payload instanceof ScalarNode ? $this->payload : null;
    }

    public function getTag(): ?TagNode
    {
        return $this->properties?->getTag();
    }

    public function isEmpty(): bool
    {
        return null === $this->payload;
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
