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

use Aeliot\YamlToken\Parser\Assembler\ParserAssembler;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\StructureType;

final class ParserRegistry
{
    public function __construct(
        private readonly ParserAssembler $assembler,
    ) {
    }

    public function getByType(StructureType $type): SubParserInterface
    {
        throw new \LogicException(\sprintf('No sub-parser registered for structure type "%s" in assembler %s', $type->value, $this->assembler::class));
    }
}
