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

namespace Aeliot\YamlToken\Test\Unit\Lexer\EdgeCases\Indentation;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class JsonInPlainScalarOfSequenceTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'a',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::INDENTATION,
                'text' => '  ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'b',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::INDENTATION,
                'text' => '    ',
            ],
            [
                'type' => TokenType::SEQUENCE_ENTRY,
                'text' => '-',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'escaped_json "{\\"level1\\":{\\"level2\\":\\"\\"}}"',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::INDENTATION,
                'text' => '    ',
            ],
            [
                'type' => TokenType::SEQUENCE_ENTRY,
                'text' => '-',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'x',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::INDENTATION,
                'text' => '  ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'c',
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
                'text' => 'value',
            ],
        ], __DIR__.'/../../../../fixture/edge_cases/indentation/json_in_plain_scalar_of_sequence.yaml'];
    }
}
