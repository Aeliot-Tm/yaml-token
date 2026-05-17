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

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\ContextFrame;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;

final class ParseContext
{
    public int $depth = 0;

    /** @var ContextFrame[] */
    private array $contextStack = [];

    public function __construct(
        public readonly TokenStreamProxy $tokens,
        public readonly AnchorsRegistry $anchors,
        public readonly ParseState $state,
    ) {
    }

    public function getCurrentContext(): ContextFrame
    {
        return $this->contextStack[array_key_last($this->contextStack)];
    }

    public function popContext(): void
    {
        array_pop($this->contextStack);
    }

    public function pushContext(ContextFrame $frame): void
    {
        $this->contextStack[] = $frame;
    }
}
