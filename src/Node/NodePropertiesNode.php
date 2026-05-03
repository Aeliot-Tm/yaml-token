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
 * Node properties (c-ns-properties :96): an optional !tag and/or &anchor with
 * an optional s-separate between them. Groups the property tokens so that the
 * same accessor surface can be used for both {@see KeyNode} and {@see ValueNode}.
 */
class NodePropertiesNode extends AbstractNode
{
    private ?AnchorNode $anchor = null;
    private ?TagNode $tag = null;

    public function getAnchor(): ?AnchorNode
    {
        return $this->anchor;
    }

    public function setAnchor(AnchorNode $node): void
    {
        $this->anchor = $node;
        $this->addChild($node);
    }

    public function getTag(): ?TagNode
    {
        return $this->tag;
    }

    public function setTag(TagNode $node): void
    {
        $this->tag = $node;
        $this->addChild($node);
    }
}
