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

namespace Aeliot\YamlToken\Test\Unit\Lexer;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class SequenceEntryMultilinePlainContinuationTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield 'ab8u continuation dash is plain' => [[
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
                'text' => 'single multiline',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::INDENTATION,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '- sequence entry',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../fixture/go_yaml/sequence-entry-that-looks-like-two-with-wrong-indentation/in.yaml'];

        yield 'nested sequence entry at two spaces' => [[
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
                'text' => 'first',
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
                'type' => TokenType::SEQUENCE_ENTRY,
                'text' => '-',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'nested',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
        ], __DIR__.'/../../fixture/edge_cases/sequence-entry-nested-after-plain.yaml'];
    }
}
