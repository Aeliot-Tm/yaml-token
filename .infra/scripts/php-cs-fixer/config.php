<?php

/*
 * This file is part of the YAML Token project.
 *
 * (c) Anatoliy Melnikov <5785276@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Aeliot\PhpCsFixerBaseline\Service\FilterFactory;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

Phar::loadPhar(dirname(__DIR__, 3).'/tools/pcsf-baseline.phar', 'pcsf-baseline.phar');
require_once 'phar://pcsf-baseline.phar/vendor/autoload.php';

return (static function (): Config {
    $rules = [
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'class_definition' => [
            'multi_line_extends_each_single_line' => true,
            'single_line' => false,
        ],
        'header_comment' => [
            'header' => <<<'EOF'
            This file is part of the YAML Token project.

            (c) Anatoliy Melnikov <5785276@gmail.com>

            This source file is subject to the MIT license that is bundled
            with this source code in the file LICENSE.
            EOF,
        ],
        'phpdoc_align' => ['align' => 'left'],
    ];

    $config = (new Config())
        ->setRiskyAllowed(true)
        ->setCacheFile(dirname(__DIR__, 3).'/var/.php-cs-fixer.cache')
        ->setRules($rules);

    /** @var Finder $finder */
    $finder = require __DIR__.'/finder.php';
    $finder->filter((new FilterFactory())->createFilter(__DIR__.'/baseline.json', $config));

    return $config->setFinder($finder);
})();
