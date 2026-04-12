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

class SequenceEntryNode extends AbstractNode
{
    private Node $value;

    public function getValue(): Node
    {
        return $this->value;
    }

    public function setValue(Node $node): void
    {
        $this->value = $node;
        $this->addChild($node);
    }
}
