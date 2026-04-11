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

namespace Aeliot\YamlToken\Lexer\Dto;

final readonly class Harvester
{
    public Cursor $cursor;
    public string $input;
    public int $length;

    public function __construct(string $input)
    {
        $this->input = $input;
        $this->length = \strlen($input);
        $this->cursor = new Cursor();
    }
}
