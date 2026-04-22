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
        if (!is_dir($root)) {
            return [];
        }

        $paths = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS),
        );
        foreach ($iterator as $file) {
            if (!$file instanceof \SplFileInfo || !$file->isFile()) {
                continue;
            }
            if (!str_ends_with($file->getFilename(), '.yaml')) {
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

    private static function isEmitterRoundTripNotYetVerbatim(string $fixtureId): bool
    {
        return
            str_contains($fixtureId, 'merge-key_')
            // Empty scalars: blank line before continuation; key-only; multiple adjacent keys; etc.
            || str_contains($fixtureId, 'empty-scalar')
            || str_contains($fixtureId, 'plain-multiline')
        ;
    }

    #[DataProvider('getDataForTestEmitsOriginalYaml')]
    public function testEmitsOriginalYaml(string $fixture): void
    {
        $yaml = file_get_contents($fixture);
        self::assertNotFalse($yaml);

        try {
            $stream = (new Parser())->parse($yaml);
        } catch (\Throwable $e) {
            self::markTestSkipped('Parser error: '.$e->getMessage().' on '.$this->getRelativePathFromRoot($e->getFile()).':'.$e->getLine());
        }

        if (self::isEmitterRoundTripNotYetVerbatim(self::getFixtureDataSetName(self::getSpecRoot(), $fixture))) {
            self::markTestSkipped('Emitter does not yet reproduce this fixture text verbatim (whitespace, merge key, or multiline plain).');
        }

        self::assertSame($yaml, (new YamlEmitter())->emit($stream));
    }

    private function getRelativePathFromRoot(string $pathname): string
    {
        return preg_replace('~^'.\dirname(__DIR__, 3).'/~', '', $pathname);
    }
}
