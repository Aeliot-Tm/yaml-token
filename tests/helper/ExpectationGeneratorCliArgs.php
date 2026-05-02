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

final readonly class ExpectationGeneratorCliArgs
{
    public bool $force;

    /**
     * @var list<string>
     */
    public array $onlyRelativeYamlPaths;

    public function __construct(array $argv, string $fixtureBase)
    {
        $only = [];
        foreach ($argv as $arg) {
            if (!str_starts_with($arg, '--only=')) {
                continue;
            }
            $raw = substr($arg, \strlen('--only='));
            $only[] = $this->normalizeOnlyPath($raw, $fixtureBase);
        }

        $this->force = \in_array('--force', $argv, true);
        $this->onlyRelativeYamlPaths = array_values(array_unique($only));
    }

    public function isIncluded(string $relFromFixture): bool
    {
        if ([] === $this->onlyRelativeYamlPaths) {
            return true;
        }

        return \in_array($relFromFixture, $this->onlyRelativeYamlPaths, true);
    }

    private function normalizeOnlyPath(string $raw, string $fixtureBase): string
    {
        $path = str_replace('\\', '/', trim($raw));
        if ('' === $path) {
            throw new \RuntimeException('Empty path in --only= is not allowed.');
        }
        $path = ltrim($path, './');
        $fixtureBase = rtrim(str_replace('\\', '/', $fixtureBase), '/');

        if (str_starts_with($path, 'tests/fixture/')) {
            $path = substr($path, \strlen('tests/fixture/'));
        }

        $realBase = realpath($fixtureBase);
        if (str_starts_with($path, '/') && false !== $realBase) {
            $realPath = realpath($path);
            if (false !== $realPath && str_starts_with($realPath, $realBase.'/')) {
                $path = substr($realPath, \strlen($realBase) + 1);
            }
        } elseif (false !== $realBase && !str_starts_with($path, '/')) {
            $candidate = $fixtureBase.'/'.$path;
            $realPath = realpath($candidate);
            if (false !== $realPath && str_starts_with($realPath, $realBase.'/')) {
                $path = substr($realPath, \strlen($realBase) + 1);
            }
        }

        if (!str_ends_with($path, '.yaml') && !str_ends_with($path, '.yml')) {
            $path .= '.yaml';
        }

        return $path;
    }
}
