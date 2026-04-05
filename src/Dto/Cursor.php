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

namespace Aeliot\YamlToken\Dto;

/**
 * Lexer cursor: {@see self::$position} is a byte offset into the input string;
 * {@see self::$column} is a 1-based Unicode code point index on the current line.
 */
final class Cursor
{
    /** Byte offset from the start of the input. */
    public int $position = 0;
    public int $line = 1;
    public int $column = 1;
    public int $currentIndent = 0;
}
