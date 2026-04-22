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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
final class ParserNotFailWithSpecFixturesTest extends TestCase
{
    /**
     * @return iterable<string, array{fixture: string}>
     */
    public static function getDataForTestParsesSpecFixtures(): iterable
    {
        $specRoot = self::getSpecRoot();
        foreach (self::getSortedYamlPaths($specRoot) as $path) {
            yield self::getFixtureDataSetName($specRoot, $path) => [$path];
        }
    }

    private static function getFixtureDataSetName(string $specRoot, string $path): string
    {
        $root = realpath($specRoot) ?: $specRoot;
        $real = realpath($path) ?: $path;
        $prefix = $root.\DIRECTORY_SEPARATOR;
        if (str_starts_with($real, $prefix)) {
            $relative = substr($real, \strlen($prefix));
        } else {
            $relative = $path;
        }

        return str_replace(\DIRECTORY_SEPARATOR, '/', $relative);
    }

    /**
     * @return list<string>
     */
    private static function getSortedYamlPaths(string $root): array
    {
        $paths = [];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if (!$file instanceof \SplFileInfo || !$file->isFile() || !str_ends_with($file->getFilename(), '.yaml')) {
                continue;
            }
            $paths[] = $file->getPathname();
        }

        sort($paths, \SORT_STRING);

        return $paths;
    }

    private static function getSpecRoot(): string
    {
        return realpath(__DIR__.'/../../fixture/spec') ?: __DIR__.'/../../fixture/spec';
    }

    #[DataProvider('getDataForTestParsesSpecFixtures')]
    public function testParsesSpecFixtures(string $fixture): void
    {
        self::assertNotEmpty((new Parser())->parse(file_get_contents($fixture))->getChildren());
    }
}
