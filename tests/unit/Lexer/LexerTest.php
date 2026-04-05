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
final class LexerTest extends TestCase
{
    /**
     * @return iterable<string,array{0: array<string,string|TokenType>, 1: string }>
     */
    public static function getDataForTestMapping(): iterable
    {
        yield [[], ''];
    }

    #[DataProvider('getDataForTestMapping')]
    public function testMapping(array $expectedTokens, string $input): void
    {
        $this->markTestIncomplete();
        $stream = (new Lexer())->tokenize($input);
        self::assertSame(
            $expectedTokens,
            array_map(static fn (Token $token): array => [
                'type' => $token->type,
                'text' => $token->text,
            ], $stream->getTokens())
        );
    }
}
