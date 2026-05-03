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

/**
 * TODO: simplify interface & add easy way to get type of value.
 */
class ValueNode extends AbstractNode
{
    private ?AliasNode $alias = null;
    private ?BlockMappingNode $blockMapping = null;
    private ?BlockSequenceNode $blockSequence = null;
    private ?FlowMappingNode $flowMapping = null;
    private ?FlowSequenceNode $flowSequence = null;
    private ?KeyValueCoupleNode $keyValueCouple = null;
    private ?MultilinePlainScalarNode $multilinePlainScalar = null;
    private ?NodePropertiesNode $properties = null;
    private ?ScalarNode $scalar = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof AliasNode) {
            $this->alias = $child;
        }

        if ($child instanceof BlockMappingNode) {
            $this->blockMapping = $child;
        }

        if ($child instanceof BlockSequenceNode) {
            $this->blockSequence = $child;
        }

        if ($child instanceof FlowMappingNode) {
            $this->flowMapping = $child;
        }

        if ($child instanceof FlowSequenceNode) {
            $this->flowSequence = $child;
        }

        if ($child instanceof KeyValueCoupleNode) {
            $this->keyValueCouple = $child;
        }

        if ($child instanceof ScalarNode) {
            if (null !== $this->multilinePlainScalar) {
                $this->multilinePlainScalar->addChild($child);
            } elseif (null !== $this->scalar) {
                $this->multilinePlainScalar = new MultilinePlainScalarNode();
                $this->multilinePlainScalar->addChild($this->scalar);
                $this->multilinePlainScalar->addChild($child);
                $this->scalar = null;
            } else {
                $this->scalar = $child;
            }
        }

        parent::addChild($child);
    }

    public function getAlias(): ?AliasNode
    {
        return $this->alias;
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->properties?->getAnchor();
    }

    public function getBlockMapping(): ?BlockMappingNode
    {
        return $this->blockMapping;
    }

    public function getBlockSequence(): ?BlockSequenceNode
    {
        return $this->blockSequence;
    }

    public function getFlowMapping(): ?FlowMappingNode
    {
        return $this->flowMapping;
    }

    public function getFlowSequence(): ?FlowSequenceNode
    {
        return $this->flowSequence;
    }

    public function getKeyValueCouple(): ?KeyValueCoupleNode
    {
        return $this->keyValueCouple;
    }

    public function getMultilinePlainScalar(): ?MultilinePlainScalarNode
    {
        return $this->multilinePlainScalar;
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

    public function getScalar(): ?ScalarNode
    {
        return $this->scalar;
    }

    public function getTag(): ?TagNode
    {
        return $this->properties?->getTag();
    }

    public function isEmpty(): bool
    {
        return null === $this->alias
            && null === $this->blockMapping
            && null === $this->blockSequence
            && null === $this->flowMapping
            && null === $this->flowSequence
            && null === $this->keyValueCouple
            && null === $this->multilinePlainScalar
            && null === $this->scalar;
    }
}
