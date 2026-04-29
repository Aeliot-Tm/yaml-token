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

namespace Aeliot\YamlToken\Test\Unit\Lexer\Spec\V1P0;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class MappingBlockSequenceTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
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
                'text' => 'one',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
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
                'text' => 'two',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
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
                'text' => 'three',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => '
',
            ],
        ], __DIR__.'/../../../../fixture/spec/1.0/block-sequence_4.5.1.yaml'];
    }
}
