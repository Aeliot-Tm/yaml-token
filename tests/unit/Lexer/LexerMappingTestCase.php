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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class LexerMappingTestCase extends TestCase
{
    /**
     * @return iterable<string, array{0: list<array{type: TokenType, text: string}>, 1: string}>
     */
    abstract public static function getDataForTestMapping(): iterable;

    #[DataProvider('getDataForTestMapping')]
    public function testMapping(array $expectedTokens, string $path): void
    {
        $input = file_get_contents($path);
        $input = str_replace(["\r\n", "\r"], "\n", $input);
        $stream = (new Lexer())->tokenize($input);
        self::assertSame(
            $expectedTokens,
            array_map(static fn (Token $token): array => [
                'type' => $token->type,
                'text' => $token->text,
            ], $stream->getTokens())
        );

        $expectationPath = self::lexerExpectationPathForFixture($path);
        if (null !== $expectationPath && is_file($expectationPath)) {
            /** @var list<array{type: TokenType, text: string}> $fromExpectation */
            $fromExpectation = require $expectationPath;
            self::assertSame(
                $expectedTokens,
                $fromExpectation,
                'Handwritten tokens must match tests/lexer_expectations for '.$path
            );
        }
    }

    private static function lexerExpectationPathForFixture(string $yamlPath): ?string
    {
        $projectRoot = \dirname(__DIR__, 3);
        $fixtureBaseReal = realpath($projectRoot.'/tests/fixture');
        $yamlReal = realpath($yamlPath);
        if (false === $fixtureBaseReal || false === $yamlReal) {
            return null;
        }

        $prefix = $fixtureBaseReal.\DIRECTORY_SEPARATOR;
        if (!str_starts_with($yamlReal, $prefix)) {
            return null;
        }

        $relative = substr($yamlReal, \strlen($prefix));
        $relative = str_replace('\\', '/', $relative);
        if (!str_ends_with($relative, '.yaml')) {
            return null;
        }

        return $projectRoot.'/tests/lexer_expectations/'.substr($relative, 0, -5).'.php';
    }
}
