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

class SequenceEntryNode extends AbstractNode
{
    private ?ValueNode $value = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof ValueNode) {
            if (null !== $this->value) {
                throw new UnexpectedStateException('Attempt to set a value name twice');
            }

            $this->value = $child;
        }

        parent::addChild($child);
    }

    public function getValue(): ?ValueNode
    {
        return $this->value;
    }

    public function removeChild(Node $child): void
    {
        if ($this->value === $child) {
            $this->value = null;
        }

        parent::removeChild($child);
    }
}
