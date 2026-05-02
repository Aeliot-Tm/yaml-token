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

namespace Aeliot\YamlToken\Test\Unit\Lexer\Invalid;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class BrokenIndentTabTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield 'after document start' => [[
            [
                'type' => TokenType::DOCUMENT_START,
                'text' => '---',
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
                'type' => TokenType::WHITESPACE,
                'text' => "\t",
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
                'text' => 'a',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../../fixture/invalid/indent_after_directive.yaml'];

        yield 'spaces tab trailing spaces' => [[
            [
                'type' => TokenType::INDENTATION,
                'text' => '  ',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => "\t  ",
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
                'text' => 'a',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../../fixture/invalid/indent_spaces_tab_trailing_spaces.yaml'];

        yield 'spaces then tab' => [[
            [
                'type' => TokenType::INDENTATION,
                'text' => '  ',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => "\t",
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
                'text' => 'a',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../../fixture/invalid/indent_spaces_then_tab.yaml'];

        yield 'tab at column 1' => [[
            [
                'type' => TokenType::WHITESPACE,
                'text' => "\t",
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
                'text' => 'a',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../../fixture/invalid/indent_tab_only.yaml'];

        yield 'two tabs' => [[
            [
                'type' => TokenType::WHITESPACE,
                'text' => "\t\t",
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
                'text' => 'a',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../../fixture/invalid/indent_tabs_only.yaml'];
    }
}
