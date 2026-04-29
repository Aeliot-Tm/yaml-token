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

use Aeliot\YamlToken\Parser\Exception\UnexpectedNodeException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
final class AdditionalNegativeCasesTest extends TestCase
{
    public function testThrowsWhenFlowMappingIsNotClosed(): void
    {
        $this->expectException(UnexpectedTokenException::class);
        $this->expectExceptionMessageMatches('/^There is no expected FLOW_MAPPING_END token/');

        (new Parser())->parse(<<<'YAML'
key: {a: 1
YAML);
    }

    public function testThrowsWhenFlowSequenceIsNotClosed(): void
    {
        $this->expectException(UnexpectedTokenException::class);
        $this->expectExceptionMessageMatches('/^There is no expected FLOW_SEQUENCE_END token/');

        (new Parser())->parse(<<<'YAML'
key: [a, b
YAML);
    }

    public function testThrowsWhenFlowKeyIsNotScalar(): void
    {
        $this->expectException(UnexpectedTokenException::class);
        $this->expectExceptionMessageMatches('/^Key scalar expected/');

        (new Parser())->parse(<<<'YAML'
key: {[a, b]: c}
YAML);
    }

    public function testThrowsWhenMergeSequenceContainsNonValueEntry(): void
    {
        $this->expectException(UnexpectedNodeException::class);
        $this->expectExceptionMessage('Flow sequence entry must be a value node');

        (new Parser())->parse(<<<'YAML'
a: &A {k: v}
b:
  <<: [*A, foo]
YAML);
    }

    public function testThrowsWhenMergeSequenceEntryIsNotAlias(): void
    {
        $this->expectException(UnexpectedStateException::class);
        $this->expectExceptionMessage('Each merge sequence entry must contain exactly one alias');

        (new Parser())->parse(<<<'YAML'
a:
  <<: [foo]
YAML);
    }

    public function testThrowsWhenBlockSequenceHasNonSequenceEntryAtSameIndent(): void
    {
        $this->expectException(UnexpectedTokenException::class);
        $this->expectExceptionMessageMatches('/^Sequence entry expected while parsing block sequence value/');

        (new Parser())->parse(<<<'YAML'
a:
  - one
  two: three
YAML);
    }
}
