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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
final class LexerUTFColumnTest extends TestCase
{
    /**
     * @return iterable<string,array{0: array<string,int|string|TokenType>, 1: string }>
     */
    public static function getDataForUTFColumnDetection(): iterable
    {
        yield 'simple' => [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'аб',
                'line' => 1,
                'column' => 1,
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
                'line' => 1,
                'column' => 3,
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
                'line' => 1,
                'column' => 4,
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'вг',
                'line' => 1,
                'column' => 5,
            ],
        ], 'аб: вг'];

        yield 'column after new line and indent' => [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'key',
                'line' => 1,
                'column' => 1,
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
                'line' => 1,
                'column' => 4,
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
                'line' => 1,
                'column' => 5,
            ],
            [
                'type' => TokenType::INDENTATION,
                'text' => '  ',
                'line' => 2,
                'column' => 1,
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'аб',
                'line' => 2,
                'column' => 3,
            ],
        ], "key:\n  аб"];

        yield 'with BOM' => [[
            [
                'type' => TokenType::BYTE_ORDER_MARK,
                'text' => "\xEF\xBB\xBF",
                'line' => 1,
                'column' => 1,
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'ab',
                'line' => 1,
                'column' => 2,
            ],
            [
                'type' => TokenType::MAPPING_VALUE,
                'text' => ':',
                'line' => 1,
                'column' => 4,
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
                'line' => 1,
                'column' => 5,
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'c',
                'line' => 1,
                'column' => 6,
            ],
        ], "\xEF\xBB\xBFab: c"];
    }

    #[DataProvider('getDataForUTFColumnDetection')]
    public function testUTFColumnDetection(array $expectedTokens, string $input): void
    {
        $stream = (new Lexer())->tokenize($input);
        self::assertSame(
            $expectedTokens,
            array_map(static fn (Token $token): array => [
                'type' => $token->type,
                'text' => $token->text,
                'line' => $token->line,
                'column' => $token->column,
            ], $stream->getTokens())
        );
    }
}
