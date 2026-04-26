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
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
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
        self::assertSame('levelA', $this->getKeyText($rootCouples[0]));

        $levelAValue = $rootCouples[0]->getValue();
        self::assertNotNull($levelAValue);
        $levelAMapping = $levelAValue->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $levelAMapping);

        $levelACouples = $this->getKeyValueCouples($levelAMapping);
        self::assertCount(1, $levelACouples);
        self::assertSame('levelB', $this->getKeyText($levelACouples[0]));

        $levelBValue = $levelACouples[0]->getValue();
        self::assertNotNull($levelBValue);
        $levelBMapping = $levelBValue->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $levelBMapping);

        $levelBCouples = $this->getKeyValueCouples($levelBMapping);
        self::assertCount(1, $levelBCouples);
        self::assertSame('propA', $this->getKeyText($levelBCouples[0]));
        self::assertSame('valueA', $this->getScalarValueText($levelBCouples[0]));
    }

    public function testParsesNestedBlockMappingWhenParentValueHasInlineComment(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
levelA:
  levelB: # just a comment
    propA: valueA
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertCount(1, $rootCouples);
        self::assertSame('levelA', $this->getKeyText($rootCouples[0]));

        $levelAValue = $rootCouples[0]->getValue();
        self::assertNotNull($levelAValue);
        $levelACouples = $this->getKeyValueCouples($this->getBlockMapping($levelAValue));
        self::assertCount(1, $levelACouples);
        self::assertSame('levelB', $this->getKeyText($levelACouples[0]));

        $levelBValue = $levelACouples[0]->getValue();
        self::assertNotNull($levelBValue);
        $levelBMapping = $this->getBlockMapping($levelBValue);
        $levelBCouples = $this->getKeyValueCouples($levelBMapping);
        self::assertCount(1, $levelBCouples);
        self::assertSame('propA', $this->getKeyText($levelBCouples[0]));
        self::assertSame('valueA', $this->getScalarValueText($levelBCouples[0]));
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
        self::assertSame('levelA', $this->getKeyText($rootCouples[0]));

        $levelAValue = $rootCouples[0]->getValue();
        self::assertNotNull($levelAValue);
        $levelB = $this->getKeyValueCouples($this->getBlockMapping($levelAValue))[0];
        self::assertSame('levelB', $this->getKeyText($levelB));

        $levelBValue = $levelB->getValue();
        self::assertNotNull($levelBValue);
        $levelC = $this->getKeyValueCouples($this->getBlockMapping($levelBValue))[0];
        self::assertSame('levelC', $this->getKeyText($levelC));

        $levelCValue = $levelC->getValue();
        self::assertNotNull($levelCValue);
        $props = $this->getKeyValueCouples($this->getBlockMapping($levelCValue));
        self::assertCount(2, $props);
        self::assertSame(['propA', 'propB'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $props));
        self::assertSame('valueA', $this->getScalarValueText($props[0]));
        self::assertSame('valueB', $this->getScalarValueText($props[1]));
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
        self::assertSame('levelA', $this->getKeyText($rootCouples[0]));

        $levelAValue = $rootCouples[0]->getValue();
        self::assertNotNull($levelAValue);
        $levelACouples = $this->getKeyValueCouples($this->getBlockMapping($levelAValue));
        self::assertCount(2, $levelACouples);
        self::assertSame(['levelB', 'levelE'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $levelACouples));
        self::assertSame('valueE', $this->getScalarValueText($levelACouples[1]));

        $levelBValue = $levelACouples[0]->getValue();
        self::assertNotNull($levelBValue);
        $levelBCouples = $this->getKeyValueCouples($this->getBlockMapping($levelBValue));
        self::assertCount(2, $levelBCouples);
        self::assertSame(['levelC', 'levelD'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $levelBCouples));
        self::assertSame('valueD', $this->getScalarValueText($levelBCouples[1]));

        $levelCValue = $levelBCouples[0]->getValue();
        self::assertNotNull($levelCValue);
        $props = $this->getKeyValueCouples($this->getBlockMapping($levelCValue));
        self::assertCount(2, $props);
        self::assertSame(['propA', 'propB'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $props));
        self::assertSame('valueA', $this->getScalarValueText($props[0]));
        self::assertSame('valueB', $this->getScalarValueText($props[1]));
    }

    public function testThrowsOnInconsistentSiblingIndentationInNestedBlockMapping(): void
    {
        $this->expectException(IndentationInvalidException::class);
        $this->expectExceptionMessageMatches('/Unexpected indentation/i');

        (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
   propA: valueA
    propB: valueB
YAML);
    }

    public function testThrowsWhenIndentIncreasesAfterPreviousKeyHasScalarValue(): void
    {
        $this->expectException(IndentationInvalidException::class);
        $this->expectExceptionMessageMatches('/Unexpected indentation/i');

        (new Parser())->parse(<<<'YAML'
levelA:
  levelB: valueB
    levelC: valueC
YAML);
    }

    private function getBlockMapping(ValueNode $value): BlockMappingNode
    {
        $blockMapping = $value->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $blockMapping);

        return $blockMapping;
    }

    private function getKeyText(KeyValueCoupleNode $couple): string
    {
        return (string) $couple->getKey()->getName()?->getToken()->text;
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

    private function getOnlyDocument(StreamNode $stream): DocumentNode
    {
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn ($n): bool => $n instanceof DocumentNode,
        ));

        self::assertCount(1, $documents);

        return $documents[0];
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
