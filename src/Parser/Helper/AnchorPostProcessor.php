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

namespace Aeliot\YamlToken\Parser\Helper;

use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;

final readonly class AnchorPostProcessor
{
    /**
     * @param AnchorNode[] $anchors
     */
    public function collectAnchorsRecursive(Node $node, array &$anchors): void
    {
        if ($node instanceof AnchorNode) {
            $anchors[] = $node;

            return;
        }

        foreach ($node->getChildren() as $child) {
            if ($child instanceof KeyValueCoupleNode) {
                continue;
            }
            $this->collectAnchorsRecursive($child, $anchors);
        }
    }

    public function postProcessKeyValueCouple(AnchorsRegistry $anchorsRegistry, KeyValueCoupleNode $couple): void
    {
        $anchors = [];
        $this->collectAnchorsRecursive($couple->getKey(), $anchors);
        if (null !== ($valueAnchor = $couple->getValue()?->getAnchor())) {
            $anchors[] = $valueAnchor;
        }

        foreach ($anchors as $anchor) {
            $anchor->setDeclarationCouple($couple);
            $anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }
    }
}
