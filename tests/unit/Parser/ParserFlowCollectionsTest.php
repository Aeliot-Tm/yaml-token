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
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(FlowMappingNode::class)]
#[UsesClass(FlowSequenceNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(YamlEmitter::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class ParserFlowCollectionsTest extends TestCase
{
    public function testParsesFlowSequenceAsValue(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
key: [one, two]
YAML);

        $couple = $this->getOnlyCouple($stream);
        $value = $couple->getValue();
        self::assertNotNull($value);

        $flows = array_values(array_filter(
            $value->getChildren(),
            static fn ($n): bool => $n instanceof FlowSequenceNode,
        ));
        self::assertCount(1, $flows);

        $entries = array_values(array_filter(
            $flows[0]->getEntries(),
            static fn ($n): bool => $n instanceof ValueNode,
        ));
        self::assertCount(2, $entries);
        self::assertSame('one', $entries[0]->getScalar()?->getToken()->text);
        self::assertSame('two', $entries[1]->getScalar()?->getToken()->text);
    }

    public function testParsesFlowMappingAsValue(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
key: {a: 1, b: 2}
YAML);

        $couple = $this->getOnlyCouple($stream);
        $value = $couple->getValue();
        self::assertNotNull($value);

        $flows = array_values(array_filter(
            $value->getChildren(),
            static fn ($n): bool => $n instanceof FlowMappingNode,
        ));
        self::assertCount(1, $flows);

        $flowMapping = $flows[0];
        $flowCouples = array_values(array_filter(
            $flowMapping->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));

        self::assertCount(2, $flowCouples);
        self::assertSame(['a', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $flowCouples));
        self::assertSame('1', $this->getScalarValueText($flowCouples[0]));
        self::assertSame('2', $this->getScalarValueText($flowCouples[1]));
    }

    public function testParsesFlowSequenceWithTrailingCommaFromMinimalFixture(): void
    {
        $path = __DIR__.'/../../fixture/spec/1.2.2/flow-sequence-trailing-comma_7.4.1.yaml';
        $raw = str_replace(["\r\n", "\r"], "\n", (string) file_get_contents($path));
        $stream = (new Parser())->parse('k: '.rtrim($raw));

        $couple = $this->getOnlyCouple($stream);
        $value = $couple->getValue();
        self::assertNotNull($value);

        $flows = array_values(array_filter(
            $value->getChildren(),
            static fn ($n): bool => $n instanceof FlowSequenceNode,
        ));
        self::assertCount(1, $flows);

        $entries = array_values(array_filter(
            $flows[0]->getEntries(),
            static fn ($n): bool => $n instanceof ValueNode,
        ));
        self::assertCount(3, $entries);
        self::assertSame('a', $entries[0]->getScalar()?->getToken()->text);
        self::assertSame('b', $entries[1]->getScalar()?->getToken()->text);
        self::assertSame('c', $entries[2]->getScalar()?->getToken()->text);
    }

    public function testParsesFlowMappingWithTrailingCommaFromMinimalFixture(): void
    {
        $path = __DIR__.'/../../fixture/spec/1.2.2/flow-mapping-trailing-comma_7.4.2.yaml';
        $raw = str_replace(["\r\n", "\r"], "\n", (string) file_get_contents($path));
        $stream = (new Parser())->parse('k: '.rtrim($raw));

        $couple = $this->getOnlyCouple($stream);
        $value = $couple->getValue();
        self::assertNotNull($value);

        $flows = array_values(array_filter(
            $value->getChildren(),
            static fn ($n): bool => $n instanceof FlowMappingNode,
        ));
        self::assertCount(1, $flows);

        $flowCouples = array_values(array_filter(
            $flows[0]->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
        self::assertCount(2, $flowCouples);
        self::assertSame(['a', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $flowCouples));
        self::assertSame('1', $this->getScalarValueText($flowCouples[0]));
        self::assertSame('2', $this->getScalarValueText($flowCouples[1]));
    }

    public function testParsesFlowEmptyKeyFromMinimalFixture(): void
    {
        $path = __DIR__.'/../../fixture/spec/1.2.2/flow-empty-key_7.4.2.yaml';
        $raw = str_replace(["\r\n", "\r"], "\n", (string) file_get_contents($path));

        $source = 'k: '.rtrim($raw);
        $stream = (new Parser())->parse($source);
        self::assertSame($source, (new YamlEmitter())->emit($stream));

        $couple = $this->getOnlyCouple($stream);
        $value = $couple->getValue();
        self::assertNotNull($value);

        $flows = array_values(array_filter(
            $value->getChildren(),
            static fn ($n): bool => $n instanceof FlowMappingNode,
        ));
        self::assertCount(1, $flows);

        $flowCouples = array_values(array_filter(
            $flows[0]->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
        self::assertCount(2, $flowCouples);

        self::assertSame('foo', $flowCouples[0]->getKey()->getName()?->getToken()->text);
        self::assertNotNull($flowCouples[0]->getMappingValueIndicator());
        self::assertNotNull($flowCouples[0]->getValue());
        self::assertTrue($flowCouples[0]->getValue()->isEmpty());

        self::assertTrue($flowCouples[1]->getKey()->isEmpty());
        self::assertNotNull($flowCouples[1]->getKey()->getExplicitKeyIndicatorNode());
        self::assertNotNull($flowCouples[1]->getMappingValueIndicator());
        self::assertSame('bar', $this->getScalarValueText($flowCouples[1]));
    }

    private function getKeyText(KeyValueCoupleNode $couple): string
    {
        return (string) $couple->getKey()->getName()?->getToken()->text;
    }

    private function getOnlyCouple(StreamNode $stream): KeyValueCoupleNode
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

    private function getScalarValueText(KeyValueCoupleNode $couple): string
    {
        $valueNode = $couple->getValue();
        self::assertNotNull($valueNode);
        $scalar = $valueNode->getScalar();
        self::assertInstanceOf(ScalarNode::class, $scalar);

        return $scalar->getToken()->text;
    }
}
