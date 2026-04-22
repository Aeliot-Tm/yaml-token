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

namespace Aeliot\YamlToken\Emitter;

use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TokenHolderInterface;

class YamlEmitter
{
    public function emit(StreamNode $stream): string
    {
        return $this->emitNode($stream);
    }

    private function emitNode(Node $node): string
    {
        $result = '';

        if ($node instanceof TokenHolderInterface) {
            $result .= $node->getToken()->text;
        }

        $seenChildren = [];
        foreach ($node->getChildren() as $child) {
            $childId = spl_object_id($child);
            if (isset($seenChildren[$childId])) {
                continue;
            }
            $seenChildren[$childId] = true;

            $result .= $this->emitNode($child);
        }

        return $result;
    }
}
