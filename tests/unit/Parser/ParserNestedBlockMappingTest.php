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

use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(ScalarNode::class)]
final class ParserNestedBlockMappingTest extends TestCase
{
    public function testParsesNestedBlockMappingTwoLevels(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
    propA: valueA
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertCount(1, $rootCouples);
        self::assertSame('levelA', $this->keyText($rootCouples[0]));

        $levelAValue = $this->asValueNode($rootCouples[0]->getValue());
        $levelAMapping = $levelAValue->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $levelAMapping);

        $levelACouples = $this->getKeyValueCouples($levelAMapping);
        self::assertCount(1, $levelACouples);
        self::assertSame('levelB', $this->keyText($levelACouples[0]));

        $levelBValue = $this->asValueNode($levelACouples[0]->getValue());
        $levelBMapping = $levelBValue->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $levelBMapping);

        $levelBCouples = $this->getKeyValueCouples($levelBMapping);
        self::assertCount(1, $levelBCouples);
        self::assertSame('propA', $this->keyText($levelBCouples[0]));
        self::assertSame('valueA', $this->scalarValueText($levelBCouples[0]));
    }

    public function testParsesNestedBlockMappingFourLevels(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
    levelC:
      propA: valueA
      propB: valueB
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertSame('levelA', $this->keyText($rootCouples[0]));

        $levelAValue = $this->asValueNode($rootCouples[0]->getValue());
        $levelB = $this->getKeyValueCouples($this->requireBlockMapping($levelAValue))[0];
        self::assertSame('levelB', $this->keyText($levelB));

        $levelBValue = $this->asValueNode($levelB->getValue());
        $levelC = $this->getKeyValueCouples($this->requireBlockMapping($levelBValue))[0];
        self::assertSame('levelC', $this->keyText($levelC));

        $levelCValue = $this->asValueNode($levelC->getValue());
        $props = $this->getKeyValueCouples($this->requireBlockMapping($levelCValue));
        self::assertCount(2, $props);
        self::assertSame(['propA', 'propB'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $props));
        self::assertSame('valueA', $this->scalarValueText($props[0]));
        self::assertSame('valueB', $this->scalarValueText($props[1]));
    }

    public function testParsesNestedBlockMappingWithSiblingNodesAtDifferentLevels(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
    levelC:
      propA: valueA
      propB: valueB
    levelD: valueD
  levelE: valueE
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertCount(1, $rootCouples);
        self::assertSame('levelA', $this->keyText($rootCouples[0]));

        $levelAValue = $this->asValueNode($rootCouples[0]->getValue());
        $levelACouples = $this->getKeyValueCouples($this->requireBlockMapping($levelAValue));
        self::assertCount(2, $levelACouples);
        self::assertSame(['levelB', 'levelE'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $levelACouples));
        self::assertSame('valueE', $this->scalarValueText($levelACouples[1]));

        $levelBValue = $this->asValueNode($levelACouples[0]->getValue());
        $levelBCouples = $this->getKeyValueCouples($this->requireBlockMapping($levelBValue));
        self::assertCount(2, $levelBCouples);
        self::assertSame(['levelC', 'levelD'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $levelBCouples));
        self::assertSame('valueD', $this->scalarValueText($levelBCouples[1]));

        $levelCValue = $this->asValueNode($levelBCouples[0]->getValue());
        $props = $this->getKeyValueCouples($this->requireBlockMapping($levelCValue));
        self::assertCount(2, $props);
        self::assertSame(['propA', 'propB'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $props));
        self::assertSame('valueA', $this->scalarValueText($props[0]));
        self::assertSame('valueB', $this->scalarValueText($props[1]));
    }

    public function testThrowsOnIndentNotMultipleOfFirstIndent(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessageMatches('/Indentation must be multiple of/i');

        (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
   levelC:
    propA: valueA
YAML);
    }

    public function testThrowsWhenIndentIncreasesAfterPreviousKeyHasScalarValue(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessageMatches('/Unexpected indentation/i');

        (new Parser())->parse(<<<'YAML'
levelA:
  levelB: valueB
    levelC: valueC
YAML);
    }

    private function getOnlyDocument(StreamNode $stream): DocumentNode
    {
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn ($n): bool => $n instanceof DocumentNode,
        ));

        self::assertCount(1, $documents);

        return $documents[0];
    }

    /**
     * @return KeyValueCoupleNode[]
     */
    private function getKeyValueCouples(object $node): array
    {
        $children = $node->getChildren();

        return array_values(array_filter(
            $children,
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
    }

    private function keyText(KeyValueCoupleNode $couple): string
    {
        return $couple->getKey()->getName()->getToken()->text;
    }

    private function scalarValueText(KeyValueCoupleNode $couple): string
    {
        $valueNode = $this->asValueNode($couple->getValue());
        $scalar = $valueNode->getScalar();
        self::assertInstanceOf(ScalarNode::class, $scalar);

        return $scalar->getToken()->text;
    }

    private function asValueNode(object $node): ValueNode
    {
        self::assertInstanceOf(ValueNode::class, $node);

        return $node;
    }

    private function requireBlockMapping(ValueNode $value): BlockMappingNode
    {
        $blockMapping = $value->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $blockMapping);

        return $blockMapping;
    }
}
