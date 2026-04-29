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

namespace Aeliot\YamlToken\Test\Unit\Lexer\Spec\V1P1;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class MappingAnchorAliasTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'anchored',
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
                'type' => TokenType::ANCHOR,
                'text' => '&name',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'value',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'alias',
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
                'type' => TokenType::ALIAS,
                'text' => '*name',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
        ], __DIR__.'/../../../../fixture/spec/1.1/anchor-alias_3.2.2.2.yaml'];
    }
}
