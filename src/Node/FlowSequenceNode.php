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
 * Flow sequence (c-flow-sequence :137).
 * Contains: "[" + ValueNode[] + "]".
 *
 * Each entry is wrapped in a {@see ValueNode}. A flow-node entry is exposed via
 * the usual ValueNode getters (scalar, flowMapping, etc.); a flow-pair entry
 * (YAML 1.2.2 §7.4.1 ns-flow-pair) is exposed via {@see ValueNode::getKeyValueCouple()}.
 */
class FlowSequenceNode extends AbstractNode
{
    /**
     * @return list<ValueNode>
     */
    public function getEntries(): array
    {
        return array_values(array_filter(
            $this->children,
            static fn (Node $c): bool => $c instanceof ValueNode,
        ));
    }
}
