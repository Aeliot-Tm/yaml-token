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

class KeyValueCoupleNode extends AbstractNode
{
    private ?IndentationNode $indentation = null;
    private KeyNode $key;
    private ValueNode $value;

    public function getIndentation(): ?IndentationNode
    {
        return $this->indentation;
    }

    public function setIndentation(IndentationNode $node): void
    {
        $this->indentation = $node;
        $this->addChild($node);
    }

    public function getKey(): KeyNode
    {
        return $this->key;
    }

    public function setKey(KeyNode $node): void
    {
        $this->key = $node;
        $this->addChild($node);
    }

    public function getValue(): ValueNode
    {
        return $this->value;
    }

    public function setValue(ValueNode $node): void
    {
        $this->value = $node;
        $this->addChild($node);
    }
}
