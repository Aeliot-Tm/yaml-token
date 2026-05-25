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

namespace Aeliot\YamlToken\Parser\SubParser\Scalar;

use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class BlockScalarKeyNameConsumer
{
    public function __construct(
        private BlockScalarFirstFragmentConsumer $blockScalarFirstFragmentConsumer,
    ) {
    }

    /**
     * Consumes a block scalar (literal | or folded >) used as an explicit mapping key
     * (YAML 1.2.2 §8.2.2 c-l-block-map-explicit-key). Tokens consumed:
     * BLOCK_SCALAR_INDICATOR, optional sub-indicators (chomping/indentation), NEWLINE,
     * optional leading empty lines, optional INDENTATION, and the scalar payload.
     * The assembled entry node is set as the {@see KeyNode::setName() name} of the key.
     */
    public function consume(TokenStreamInterface $tokens, KeyNode $keyNode): void
    {
        $entry = $this->blockScalarFirstFragmentConsumer->consume($tokens);
        $keyNode->setName($entry);
    }
}
