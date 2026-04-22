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

namespace Aeliot\YamlToken\Test\Unit\Lexer\Spec\V1P2P0;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class LexerMappingTrailingCommaTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield 'trailing_comma_in_flow_sequence' => [[
            [
                'type' => TokenType::FLOW_SEQUENCE_START,
                'text' => '[',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'a',
            ],
            [
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'b',
            ],
            [
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'c',
            ],
            [
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::FLOW_SEQUENCE_END,
                'text' => ']',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
        ], __DIR__.'/../../../../fixture/spec/1.2.0/flow-sequence-trailing-comma_7.4.1.yaml'];

        yield 'trailing_comma_in_flow_mapping' => [[
            [
                'type' => TokenType::FLOW_MAPPING_START,
                'text' => '{',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'a',
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
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
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
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2',
            ],
            [
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_END,
                'text' => '}',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
        ], __DIR__.'/../../../../fixture/spec/1.2.0/flow-mapping-trailing-comma_7.4.2.yaml'];
    }
}
