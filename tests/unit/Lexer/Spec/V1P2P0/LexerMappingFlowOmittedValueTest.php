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
final class LexerMappingFlowOmittedValueTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            [
                'type' => TokenType::FLOW_MAPPING_START,
                'text' => '{',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'https',
            ],
            [
                'type' => TokenType::UNRECOGNIZED,
                'text' => ':',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '//example.com',
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
                'text' => 'omitted value',
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
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::MAPPING_KEY,
                'text' => '?',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
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
                'text' => 'omitted key',
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
        ], __DIR__.'/../../../../fixture/spec/1.2.0/flow-omitted-value.yaml'];
    }
}
