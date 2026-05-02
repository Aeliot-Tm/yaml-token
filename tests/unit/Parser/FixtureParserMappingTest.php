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

namespace Aeliot\YamlToken\Test\Unit\Parser;

use Aeliot\YamlToken\Parser\Parser;
use Aeliot\YamlToken\TestHelper\FixtureFinder;
use Aeliot\YamlToken\TestHelper\NodeTreeRepresenter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(NodeTreeRepresenter::class)]
final class FixtureParserMappingTest extends TestCase
{
    /**
     * @return iterable<string, array{0: string, 1: string}>
     */
    public static function expectedTreeCases(): iterable
    {
        $projectRoot = \dirname(__DIR__, 3);
        $fixtureBase = $projectRoot.'/tests/fixture';
        $expectBase = $projectRoot.'/tests/parser_expectations';

        $finder = new FixtureFinder(
            $fixtureBase,
            [
                'edge_cases',
                'edge_cases_extra',
                'spec/1.0',
                'spec/1.1',
                'spec/1.2.0',
                'spec/1.2.1',
                'spec/1.2.2',
                'spec_extra/1.0',
            ],
        );

        foreach ($finder as $yamlPath) {
            $relFromFixture = substr($yamlPath, \strlen($fixtureBase) + 1);
            $expectPath = $expectBase.'/'.substr($relFromFixture, 0, -5).'.php';
            yield $relFromFixture => [$yamlPath, $expectPath];
        }
    }

    #[DataProvider('expectedTreeCases')]
    public function testFixtureMatchesStoredTree(string $fixturePath, string $expectationPath): void
    {
        self::assertFileExists(
            $expectationPath,
            'Missing parser expectation. Regenerate with: php bin/dev/generate-parser-expectations.php'
        );

        $raw = (string) file_get_contents($fixturePath);
        self::assertNotSame('', $raw);

        /** @var array<string, mixed> $expected */
        $expected = require $expectationPath;

        $stream = (new Parser())->parse(str_replace(["\r\n", "\r"], "\n", $raw));
        self::assertSame($expected, (new NodeTreeRepresenter())->build($stream));
    }
}
