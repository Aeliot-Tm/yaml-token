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
    private ?IndentNode $indent = null;
    private ?KeyNode $key = null;
    private ?MergeInstructionNode $mergeInstruction = null;
    private ?ValueNode $value = null;
    private ?ValueIndicatorNode $valueIndicator = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof MergeInstructionNode) {
            if (null !== $this->mergeInstruction) {
                throw new UnexpectedStateException('Attempt to set merge instruction twice');
            }
            $this->mergeInstruction = $child;
        } elseif ($child instanceof KeyNode) {
            if (null !== $this->key) {
                throw new UnexpectedStateException('Attempt to set key twice');
            }
            $this->key = $child;
        } elseif ($child instanceof ValueNode) {
            if (null !== $this->value) {
                throw new UnexpectedStateException('Attempt to set value twice');
            }
            $this->value = $child;
        } elseif ($child instanceof ValueIndicatorNode) {
            if (null !== $this->valueIndicator) {
                throw new UnexpectedStateException('Attempt to set merge instruction twice');
            }
            $this->valueIndicator = $child;
        }

        parent::addChild($child);
    }

    public function getIndent(): ?IndentNode
    {
        return $this->indent;
    }

    /**
     * NOTE: used separate method case Lexer produces INDENT token
     *       for spaces before value putted to the next line. And it has to be
     *       a part of couple. Only indentation before couple have to be
     *       identified as real indentation.
     */
    public function setIndent(IndentNode $node): void
    {
        $this->indent = $node;
        $this->addChild($node);
    }

    public function getKey(): ?KeyNode
    {
        return $this->key;
    }

    public function getMergeInstruction(): ?MergeInstructionNode
    {
        return $this->mergeInstruction;
    }

    public function getValue(): ?ValueNode
    {
        return $this->value;
    }

    public function getValueIndicator(): ?ValueIndicatorNode
    {
        return $this->valueIndicator;
    }

    public function removeChild(Node $child): void
    {
        if ($this->indent === $child) {
            $this->indent = null;
        } elseif ($this->key === $child) {
            $this->key = null;
        } elseif ($this->mergeInstruction === $child) {
            $this->mergeInstruction = null;
        } elseif ($this->valueIndicator === $child) {
            $this->valueIndicator = null;
        } elseif ($this->value === $child) {
            $this->value = null;
        }

        parent::removeChild($child);
    }
}
