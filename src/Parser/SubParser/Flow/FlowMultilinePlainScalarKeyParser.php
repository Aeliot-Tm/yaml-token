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

namespace Aeliot\YamlToken\Parser\SubParser\Flow;

use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class FlowMultilinePlainScalarKeyParser
{
    public function __construct(
        private FlowMultilinePlainScalarConsumer $consumer,
    ) {
    }

    /**
     * Flow-context multiline plain key (YAML 1.2.2 §7.3.3 / §7.4.1): NEWLINE WHITESPACE* PLAIN_SCALAR
     * fragments may follow the first scalar. Returns the head scalar when no continuation is consumed,
     * otherwise a {@see MultilinePlainScalarNode} that wraps the head plus consumed fragments.
     */
    public function parse(TokenStreamInterface $tokens, PlainScalarNode $head): Node
    {
        $multiline = new MultilinePlainScalarNode();
        $multiline->addChild($head);

        $consumedAny = false;
        while ($this->consumer->tryConsume($tokens, $multiline, false)) {
            $consumedAny = true;
        }

        return $consumedAny ? $multiline : $head;
    }
}
