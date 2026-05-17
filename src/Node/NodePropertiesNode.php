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
 * Node properties (c-ns-properties :96): an optional !tag and/or &anchor with
 * an optional s-separate between them. Groups the property tokens so that the
 * same accessor surface can be used for both {@see KeyNode} and {@see ValueNode}.
 */
class NodePropertiesNode extends AbstractNode
{
    private ?AnchorNode $anchor = null;
    private ?TagNode $tag = null;

    public function addChild(Node $child): void
    {
        if ($child instanceof AnchorNode) {
            if (null !== $this->anchor) {
                throw new UnexpectedStateException('Attempt to set anchor twice');
            }
            $this->anchor = $child;
        } elseif ($child instanceof TagNode) {
            if (null !== $this->tag) {
                throw new UnexpectedStateException('Attempt to set tag twice');
            }
            $this->tag = $child;
        }

        parent::addChild($child);
    }

    public function getAnchor(): ?AnchorNode
    {
        return $this->anchor;
    }

    public function getTag(): ?TagNode
    {
        return $this->tag;
    }

    public function removeChild(Node $child): void
    {
        if ($this->anchor === $child) {
            $this->anchor = null;
        } elseif ($this->tag === $child) {
            $this->tag = null;
        }

        parent::removeChild($child);
    }
}
