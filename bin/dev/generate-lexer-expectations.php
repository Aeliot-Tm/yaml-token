#!/usr/bin/env php
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

require_once __DIR__.'/../../vendor/autoload.php';

use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\TestHelper\ParserExpectationExporter;
use Aeliot\YamlToken\Token\Token;

$projectRoot = dirname(__DIR__, 2);
$fixtureBase = $projectRoot.'/tests/fixture';
$expectBase = $projectRoot.'/tests/lexer_expectations';

$fixtureDirs = [
    'edge_cases',
    'edge_cases_extra',
    'spec/1.0',
    'spec/1.1',
    'spec/1.2.0',
    'spec/1.2.1',
    'spec/1.2.2',
    'spec_extra/1.0',
];

$lexer = new Lexer();
$exporter = new ParserExpectationExporter();
$written = 0;

foreach ($fixtureDirs as $sub) {
    $dir = $fixtureBase.'/'.$sub;
    if (!is_dir($dir)) {
        fwrite(\STDERR, "Skip missing directory: {$dir}\n");
        continue;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
    );

    $paths = [];
    foreach ($iterator as $fileInfo) {
        if (!$fileInfo->isFile() || !str_ends_with($fileInfo->getFilename(), '.yaml')) {
            continue;
        }
        $paths[] = $fileInfo->getPathname();
    }

    sort($paths, \SORT_STRING);

    foreach ($paths as $yamlPath) {
        $relFromFixture = substr($yamlPath, strlen($fixtureBase) + 1);
        $outPath = $expectBase.'/'.substr($relFromFixture, 0, -5).'.php';

        $input = str_replace(["\r\n", "\r"], "\n", (string) file_get_contents($yamlPath));
        $stream = $lexer->tokenize($input);
        $tokens = array_map(
            static fn (Token $token): array => [
                'type' => $token->type,
                'text' => $token->text,
            ],
            $stream->getTokens()
        );
        $php = $exporter->export($tokens);

        $outDir = dirname($outPath);
        if (!is_dir($outDir) && !mkdir($outDir, 0775, true) && !is_dir($outDir)) {
            throw new RuntimeException(sprintf('Cannot create directory: %s', $outDir));
        }
        if (false === file_put_contents($outPath, $php)) {
            throw new RuntimeException(sprintf('Cannot write: %s', $outPath));
        }
        ++$written;
    }
}

echo "Wrote {$written} expectation file(s) under tests/lexer_expectations/\n";
