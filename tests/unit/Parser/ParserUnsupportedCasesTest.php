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

use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
final class ParserUnsupportedCasesTest extends TestCase
{
    public function testThrowsWhenMergeValueIsNotAliasOrFlowSequenceOfAliases(): void
    {
        $this->expectException(UnexpectedStateException::class);
        $this->expectExceptionMessage('Merge value must be an alias or a flow sequence of aliases');

        (new Parser())->parse(<<<'YAML'
a:
  <<: not-an-alias
YAML);
    }
}
