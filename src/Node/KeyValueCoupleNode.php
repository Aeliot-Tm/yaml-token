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

class KeyValueCoupleNode extends AbstractNode
{
    private ?IndentationNode $indentation = null;
    private ?KeyNode $key = null;
    private ?MergeInstructionNode $mergeInstruction = null;
    private ?SyntaxTokenNode $mappingValueIndicator = null;
    private ?ValueNode $value = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof MergeInstructionNode) {
            if (null !== $this->mergeInstruction) {
                throw new UnexpectedStateException('Attempt to set merge instruction twice');
            }
            $this->mergeInstruction = $child;
        // } elseif ($child instanceof KeyNode) {
        //     if (null !== $this->key) {
        //         throw new UnexpectedStateException('Attempt to set key twice');
        //     }
        //     $this->key = $child;
        // } elseif ($child instanceof ValueNode) {
        //     if (null !== $this->value) {
        //         throw new UnexpectedStateException('Attempt to set value twice');
        //     }
        //     $this->value = $child;
        }

        parent::addChild($child);
    }

    public function getIndentation(): ?IndentationNode
    {
        return $this->indentation;
    }

    public function setIndentation(IndentationNode $node): void
    {
        $this->indentation = $node;
        $this->addChild($node);
    }

    public function getKey(): ?KeyNode
    {
        return $this->key;
    }

    public function setKey(KeyNode $node): void
    {
        $this->key = $node;
        $this->addChild($node);
    }

    public function getMergeInstruction(): ?MergeInstructionNode
    {
        return $this->mergeInstruction;
    }

    public function getMappingValueIndicator(): ?SyntaxTokenNode
    {
        return $this->mappingValueIndicator;
    }

    public function setMappingValueIndicator(SyntaxTokenNode $node): void
    {
        $this->mappingValueIndicator = $node;
        $this->addChild($node);
    }

    public function getValue(): ?ValueNode
    {
        return $this->value;
    }

    public function setValue(ValueNode $node): void
    {
        $this->value = $node;
        $this->addChild($node);
    }

    public function removeChild(Node $child): void
    {
        if ($this->indentation === $child) {
            $this->indentation = null;
        } elseif ($this->key === $child) {
            $this->key = null;
        } elseif ($this->mappingValueIndicator === $child) {
            $this->mappingValueIndicator = null;
        } elseif ($this->mergeInstruction === $child) {
            $this->mergeInstruction = null;
        } elseif ($this->value === $child) {
            $this->value = null;
        }

        parent::removeChild($child);
    }
}
