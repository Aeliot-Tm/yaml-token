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

return $finder = (new PhpCsFixer\Finder())
    ->files()
    ->ignoreVCS(true)
    ->in(dirname(__DIR__, 3))
    ->exclude(['tests/parser_expectations', 'var', 'vendor'])
    ->append([
        '.infra/scripts/composer-unused/config.php',
        '.infra/scripts/php-cs-fixer/config.php',
        '.infra/scripts/php-cs-fixer/finder.php',
        'bin/rebuild',
    ]);
