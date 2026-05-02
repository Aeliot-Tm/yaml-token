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

namespace Aeliot\YamlToken\Test\Unit\Emitter;

use Aeliot\YamlToken\Emitter\YamlEmitter;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(YamlEmitter::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(Parser::class)]
#[UsesClass(StreamNode::class)]
final class YamlEmitterTest extends TestCase
{
    /**
     * @return iterable<string, array{fixture: string}>
     */
    public static function getDataForTestEmitsOriginalYaml(): iterable
    {
        $fixtureRoot = realpath(__DIR__.'/../../fixture') ?: __DIR__.'/../../fixture';
        foreach (self::getSpecRoot() as $specRoot) {
            foreach (self::getSortedYamlPaths($specRoot) as $path) {
                yield self::getFixtureDataSetName($fixtureRoot, $path) => [$path];
            }
        }
    }

    private static function getFixtureDataSetName(string $fixtureRoot, string $path): string
    {
        $real = realpath($path) ?: $path;
        $prefix = $fixtureRoot.\DIRECTORY_SEPARATOR;
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

    private static function getSpecRoot(): \Generator
    {
        foreach (['edge_cases', 'edge_cases_extra', 'go_yaml', 'go_yaml_extra', 'spec', 'spec_extra'] as $name) {
            $path = __DIR__.'/../../fixture/'.$name;
            yield realpath($path) ?: $path;
        }
    }

    #[DataProvider('getDataForTestEmitsOriginalYaml')]
    public function testEmitsOriginalYaml(string $fixture): void
    {
        $yaml = file_get_contents($fixture);
        $stream = (new Parser())->parse($yaml);
        self::assertSame($yaml, (new YamlEmitter())->emit($stream));
    }
}
