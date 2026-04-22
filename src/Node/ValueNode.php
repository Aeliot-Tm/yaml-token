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
    private ?AliasNode $alias = null;
    private ?AnchorNode $anchor = null;
    private ?BlockMappingNode $blockMapping = null;
    private ?BlockSequenceNode $blockSequence = null;
    private ?FlowMappingNode $flowMapping = null;
    private ?FlowSequenceNode $flowSequence = null;
    private ?ScalarNode $scalar = null;
    private ?TagPropertyNode $tagProperty = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof AliasNode) {
            $this->alias = $child;
        }

        if ($child instanceof AnchorNode) {
            $this->anchor = $child;
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

        if ($child instanceof ScalarNode) {
            $this->scalar = $child;
        }

        if ($child instanceof TagPropertyNode) {
            $this->tagProperty = $child;
        }

        parent::addChild($child);
    }

    public function getAlias(): ?AliasNode
    {
        return $this->alias;
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

    public function getTagProperty(): ?TagPropertyNode
    {
        return $this->tagProperty;
    }

    public function isEmpty(): bool
    {
        return null === $this->alias
            && null === $this->blockMapping
            && null === $this->blockSequence
            && null === $this->flowMapping
            && null === $this->flowSequence
            && null === $this->scalar;
    }
}
