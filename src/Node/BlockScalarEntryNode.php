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

class BlockScalarEntryNode extends AbstractNode
{
    private ?BlockScalarOptionsNode $options = null;
    private ?BlockScalarNode $payload = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof BlockScalarOptionsNode) {
            if (null !== $this->options) {
                throw new UnexpectedStateException('Attempt to set block scalar chomping indicator twice');
            }
            $this->options = $child;
        } elseif ($child instanceof BlockScalarNode) {
            if (null !== $this->payload) {
                throw new UnexpectedStateException('Attempt to set block scalar payload twice');
            }
            $this->payload = $child;
        }

        parent::addChild($child);
    }

    public function getOptions(): ?BlockScalarOptionsNode
    {
        return $this->options;
    }

    public function getPayload(): ?BlockScalarNode
    {
        return $this->payload;
    }

    public function removeChild(Node $child): void
    {
        if ($this->options === $child) {
            $this->options = null;
        } elseif ($this->payload === $child) {
            $this->payload = null;
        }
        parent::removeChild($child);
    }
}
