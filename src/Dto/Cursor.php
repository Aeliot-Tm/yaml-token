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

use Aeliot\YamlToken\Enum\BlockScalarChomping;
use Aeliot\YamlToken\Enum\TokenType;

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

    /**
     * After {@see TokenType::LITERAL_BLOCK_SCALAR_INDICATOR} / {@see TokenType::FOLDED_BLOCK_SCALAR_INDICATOR} until the header line break.
     */
    public bool $inBlockScalarHeaderLine = false;

    /**
     * Set when emitting {@see TokenType::LITERAL_BLOCK_SCALAR_INDICATOR} or {@see TokenType::FOLDED_BLOCK_SCALAR_INDICATOR}:
     * {@see TokenType::LITERAL_BLOCK_SCALAR} or {@see TokenType::FOLDED_BLOCK_SCALAR} for the upcoming body token.
     *
     * @var TokenType::LITERAL_BLOCK_SCALAR|TokenType::FOLDED_BLOCK_SCALAR|null
     */
    public ?TokenType $blockScalarBodyTokenType = null;

    /**
     * After the block scalar header newline (or EOF before body), the next token is block body.
     *
     * @var TokenType::LITERAL_BLOCK_SCALAR|TokenType::FOLDED_BLOCK_SCALAR|null
     */
    public ?TokenType $pendingBlockScalarBody = null;

    /**
     * Chomping from the block scalar header: set on {@see TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR},
     * default {@see BlockScalarChomping::Clip} when the header line ends without +/-.
     */
    public ?BlockScalarChomping $blockScalarChomping = null;
}
