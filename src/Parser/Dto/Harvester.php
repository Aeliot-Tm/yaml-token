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

namespace Aeliot\YamlToken\Parser\Dto;

use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Flow\FlowHost;
use Aeliot\YamlToken\Parser\ParseContext;

final class Harvester
{
    public AnchorsRegistry $anchorsRegistry;
    public FlowHost $flowHost;
    public ParseContext $parseContext;
    public ParseState $state;
    public StreamNode $stream;

    public function __construct(public readonly TokenStreamProxy $tokens)
    {
    }
}
