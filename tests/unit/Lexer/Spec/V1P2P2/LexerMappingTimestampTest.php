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

namespace Aeliot\YamlToken\Test\Unit\Lexer\Spec\V1P2P2;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class LexerMappingTimestampTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'canonical',
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2001-12-15T02',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '59',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '43.1Z',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'iso8601',
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2001-12-14t21',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '59',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '43.10-05',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '00',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'spaced',
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2001-12-14 21',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '59',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '43.10 -5',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'date',
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2002-12-14',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
        ], __DIR__.'/../../../../fixture/spec/1.2.2/timestamp.yaml'];
    }
}
