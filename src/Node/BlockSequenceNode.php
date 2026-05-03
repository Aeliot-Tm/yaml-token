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
 * Block sequence node (indented sequence entries).
 * Contains: SequenceEntryNode[] (each holds a "-" indicator and a ValueNode).
 */
class BlockSequenceNode extends AbstractNode
{
    /**
     * @return list<SequenceEntryNode>
     */
    public function getEntries(): array
    {
        return array_values(array_filter(
            $this->children,
            static fn (Node $c): bool => $c instanceof SequenceEntryNode,
        ));
    }
}
