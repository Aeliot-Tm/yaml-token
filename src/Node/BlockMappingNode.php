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
 * Block mapping node (indented key/value couples).
 * Contains: KeyValueCoupleNode[].
 *
 * A {@see MergeInstructionNode} (the YAML 1.1 merge-key extension `<< : *anchor`)
 * may also appear among the children but is not exposed via {@see self::getEntries()}.
 */
class BlockMappingNode extends AbstractNode
{
    /**
     * @return list<KeyValueCoupleNode>
     */
    public function getEntries(): array
    {
        return array_values(array_filter(
            $this->children,
            static fn (Node $c): bool => $c instanceof KeyValueCoupleNode,
        ));
    }
}
