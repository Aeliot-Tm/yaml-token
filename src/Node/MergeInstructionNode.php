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

class MergeInstructionNode extends AbstractNode
{
    /**
     * @var list<AliasNode>
     */
    private array $aliases = [];

    public function addAlias(AliasNode $alias): void
    {
        $this->aliases[] = $alias;
    }

    /**
     * @return list<AliasNode>
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }
}
