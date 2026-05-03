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

namespace Aeliot\YamlToken\Parser\Driver;

use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Completed;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Continued;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Delegate;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;

final class Driver
{
    public function run(Harvester $harvester, Frame $initial): Node
    {
        $stack = [$initial];

        while (true) {
            $frame = $stack[array_key_last($stack)];
            $result = $frame->step($harvester);

            while (true) {
                if ($result instanceof Continued) {
                    continue 2;
                }
                if ($result instanceof Delegate) {
                    $stack[] = $result->frame;
                    continue 2;
                }
                if ($result instanceof Completed) {
                    array_pop($stack);
                    if ([] === $stack) {
                        return $result->node;
                    }
                    $parent = $stack[array_key_last($stack)];
                    $result = $parent->onChildCompleted($harvester, $result->node);
                    continue;
                }

                throw new UnexpectedStateException(\sprintf('Unknown BuilderResult: %s', $result::class));
            }
        }
    }
}
