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

final class ParserExpectationExporter
{
    /** @var array<string, string> fqcn => import suffix (short name or alias) */
    private array $importSuffixByFqcn = [];

    /** @var array<string, string> suffix => fqcn */
    private array $fqcnBySuffix = [];

    public function export(array $tree): string
    {
        $this->importSuffixByFqcn = [];
        $this->fqcnBySuffix = [];
        $this->collectImports($tree);

        $useLines = [];
        foreach ($this->importSuffixByFqcn as $fqcn => $suffix) {
            $naturalShort = $this->naturalShortName($fqcn);
            if ($naturalShort === $suffix) {
                $useLines[] = 'use '.$fqcn.';';
            } else {
                $useLines[] = 'use '.$fqcn.' as '.$suffix.';';
            }
        }

        sort($useLines, SORT_STRING);
        $useBlock = implode("\n", $useLines);
        $body = $this->exportValue($tree, null, 0);

        return "<?php\n\ndeclare(strict_types=1);\n\n".$useBlock."\n\nreturn {$body};\n";
    }

    private function collectImports(mixed $value): void
    {
        if (\is_array($value)) {
            foreach ($value as $item) {
                $this->collectImports($item);
            }

            return;
        }

        if ($value instanceof \UnitEnum) {
            $this->registerFqcn($value::class);

            return;
        }

        if (\is_string($value) && class_exists($value)) {
            $this->registerFqcn($value);
        }
    }

    private function registerFqcn(string $fqcn): void
    {
        if (isset($this->importSuffixByFqcn[$fqcn])) {
            return;
        }

        $natural = $this->naturalShortName($fqcn);
        if (!isset($this->fqcnBySuffix[$natural])) {
            $this->fqcnBySuffix[$natural] = $fqcn;
            $this->importSuffixByFqcn[$fqcn] = $natural;

            return;
        }

        if ($this->fqcnBySuffix[$natural] === $fqcn) {
            return;
        }

        $i = 2;
        while (isset($this->fqcnBySuffix[$natural.$i])) {
            ++$i;
        }

        $alias = $natural.$i;
        $this->fqcnBySuffix[$alias] = $fqcn;
        $this->importSuffixByFqcn[$fqcn] = $alias;
    }

    private function naturalShortName(string $fqcn): string
    {
        $i = strrpos($fqcn, '\\');

        return false === $i ? $fqcn : substr($fqcn, $i + 1);
    }

    private function suffixForFqcn(string $fqcn): string
    {
        $suffix = $this->importSuffixByFqcn[$fqcn] ?? null;
        if (null === $suffix) {
            throw new \RuntimeException('Missing import registration for: '.$fqcn);
        }

        return $suffix;
    }

    private function exportValue(mixed $value, ?string $parentKey, int $depth): string
    {
        if (\is_array($value)) {
            return $this->exportArray($value, $depth);
        }

        if (null === $value) {
            return 'null';
        }

        if (\is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (\is_int($value) || \is_float($value)) {
            return var_export($value, true);
        }

        if (\is_string($value)) {
            if ('type' === $parentKey && class_exists($value)) {
                return $this->suffixForFqcn($value).'::class';
            }

            return var_export($value, true);
        }

        if ($value instanceof \UnitEnum) {
            if ('type' === $parentKey) {
                return $this->suffixForFqcn($value::class).'::'.$value->name;
            }

            throw new \RuntimeException('Unexpected enum without type parent key: '.$value::class.'::'.$value->name);
        }

        throw new \RuntimeException('Unsupported export type: '.\get_debug_type($value));
    }

    /**
     * @param array<mixed> $array
     */
    private function exportArray(array $array, int $depth): string
    {
        if ([] === $array) {
            return '[]';
        }

        $indentUnit = '    ';
        $indent = str_repeat($indentUnit, $depth);
        $inner = str_repeat($indentUnit, $depth + 1);
        $isList = array_is_list($array);
        $parts = [];

        foreach ($array as $key => $item) {
            $keyPrefix = '';
            if (!$isList) {
                $keyPrefix = (\is_int($key) ? (string)$key : var_export($key, true)).' => ';
            }

            $parentKey = \is_string($key) ? $key : null;
            $parts[] = $inner.$keyPrefix.$this->exportValue($item, $parentKey, $depth + 1);
        }

        return "[\n".implode(",\n", $parts).",\n".$indent.']';
    }
}
