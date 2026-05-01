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

use Aeliot\YamlToken\Emitter\YamlEmitter;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
final class ComplexMappingKeysTest extends TestCase
{
    public function testParsesBlockMappingAsExplicitKeyOnNextLine(): void
    {
        $source = "? \n  a: b\n: c\n";
        $stream = (new Parser())->parse($source);
        self::assertSame($source, (new YamlEmitter())->emit($stream));

        $couple = $this->getOnlyDocumentCouple($stream);
        self::assertFalse($couple->getKey()->isEmpty());

        self::assertInstanceOf(BlockMappingNode::class, $couple->getKey()->getName());
    }

    public function testParsesBlockSequenceAsExplicitKeyOnNextLine(): void
    {
        $source = "? \n  - a\n  - b\n: c\n";
        $stream = (new Parser())->parse($source);
        self::assertSame($source, (new YamlEmitter())->emit($stream));

        $couple = $this->getOnlyDocumentCouple($stream);
        self::assertFalse($couple->getKey()->isEmpty());
    }

    public function testParsesFlowSequenceKeyInFlowMapping(): void
    {
        $source = "root: { &a [a, &b b]: *b, *a : [c, *b, d]}\n";
        $stream = (new Parser())->parse($source);
        self::assertSame($source, (new YamlEmitter())->emit($stream));

        $rootCouple = $this->getOnlyDocumentCouple($stream);
        $rootValue = $rootCouple->getValue();
        self::assertNotNull($rootValue);

        $flowMappings = array_values(array_filter(
            $rootValue->getChildren(),
            static fn ($n): bool => $n instanceof FlowMappingNode,
        ));
        self::assertCount(1, $flowMappings);

        $couples = array_values(array_filter(
            $flowMappings[0]->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
        self::assertGreaterThanOrEqual(2, \count($couples));

        self::assertFalse($couples[0]->getKey()->isEmpty());

        self::assertInstanceOf(FlowSequenceNode::class, $couples[0]->getKey()->getName());
    }

    private function getOnlyDocumentCouple(StreamNode $stream): KeyValueCoupleNode
    {
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn ($n): bool => $n instanceof DocumentNode,
        ));
        self::assertCount(1, $documents);

        $couples = array_values(array_filter(
            $documents[0]->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
        self::assertCount(1, $couples);

        return $couples[0];
    }
}
