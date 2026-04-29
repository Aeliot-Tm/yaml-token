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

namespace Aeliot\YamlToken\Test\Unit\Lexer\EdgeCases;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class BlankLineInLiteralBlockScalarTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'foo',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '1',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'bar',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => '    ',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'text',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                'text' => '|',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::LITERAL_BLOCK_SCALAR,
                'text' => "  a\n    \n  b\n\n  c\n \n  d\n",
            ],
        ], __DIR__.'/../../../fixture/edge_cases/blank_line_in_literal_block_scalar.yaml'];
    }
}
