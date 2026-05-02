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
use Aeliot\YamlToken\TestHelper\ExpectationGeneratorCliArgs;
use Aeliot\YamlToken\TestHelper\FixtureFinder;
use Aeliot\YamlToken\TestHelper\ParserExpectationExporter;
use Aeliot\YamlToken\Token\Token;

$projectRoot = dirname(__DIR__, 2);
$fixtureBase = $projectRoot.'/tests/fixture';
$expectBase = $projectRoot.'/tests/lexer_expectations';

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
$args = new ExpectationGeneratorCliArgs($argv, $fixtureBase);
$lexer = new Lexer();
$exporter = new ParserExpectationExporter();
$skipped = 0;
$written = 0;

foreach ($finder as $yamlPath) {
    $relFromFixture = substr($yamlPath, strlen($fixtureBase) + 1);
    if (!$args->isIncluded($relFromFixture)) {
        continue;
    }

    $outPath = $expectBase.'/'.substr($relFromFixture, 0, -5).'.php';

    if (!$args->force && is_file($outPath)) {
        ++$skipped;
        continue;
    }

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

if ($args->force) {
    echo "Wrote {$written} expectation file(s) under tests/lexer_expectations/\n";
} else {
    echo "Wrote {$written} expectation file(s), skipped {$skipped} existing (use --force to regenerate) under tests/lexer_expectations/\n";
}
