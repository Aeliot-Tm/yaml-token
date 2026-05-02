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

namespace Aeliot\YamlToken\TestHelper;

final class FixtureFinder implements \IteratorAggregate
{
    /**
     * @param string[] $fixtureDirs
     */
    public function __construct(
        private readonly string $fixtureBase,
        private readonly array $fixtureDirs,
    ) {
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->detect());
    }

    private function detect(): array
    {
        $paths = [];
        foreach ($this->fixtureDirs as $sub) {
            $dir = $this->fixtureBase.'/'.$sub;
            if (!is_dir($dir)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $fileInfo) {
                if (!$fileInfo->isFile() || !str_ends_with($fileInfo->getFilename(), '.yaml')) {
                    continue;
                }
                $paths[] = $fileInfo->getPathname();
            }
        }

        sort($paths, \SORT_STRING);

        return $paths;
    }
}
