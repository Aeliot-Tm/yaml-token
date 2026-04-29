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
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(BlockSequenceNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(SequenceEntryNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class NestedBlockSequenceTest extends TestCase
{
    public function testParsesSimpleNestedBlockSequenceUnderKey(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
    - valueA
    - valueB
  levelC:
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertCount(1, $rootCouples);
        self::assertSame('levelA', $this->getKeyText($rootCouples[0]));

        $levelAValue = $rootCouples[0]->getValue();
        self::assertNotNull($levelAValue);
        $levelACouples = $this->getKeyValueCouples($this->getBlockMapping($levelAValue));
        self::assertCount(2, $levelACouples);
        self::assertSame(['levelB', 'levelC'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $levelACouples));

        $levelBValue = $levelACouples[0]->getValue();
        self::assertNotNull($levelBValue);
        $seq = $levelBValue->getBlockSequence();
        self::assertInstanceOf(BlockSequenceNode::class, $seq);

        $entries = array_values(array_filter(
            $seq->getChildren(),
            static fn ($n): bool => $n instanceof SequenceEntryNode,
        ));
        self::assertCount(2, $entries);
        self::assertSame('valueA', $this->getSequenceScalarText($entries[0]));
        self::assertSame('valueB', $this->getSequenceScalarText($entries[1]));

        $levelCValue = $levelACouples[1]->getValue();
        self::assertNotNull($levelCValue);
        $levelCScalar = $levelCValue->getScalar();
        self::assertNull($levelCScalar);
    }

    public function testThrowsWhenSequenceIndentationIsGreaterThanBaseIndent(): void
    {
        $this->expectException(IndentationInvalidException::class);
        $this->expectExceptionMessageMatches('/Unexpected indentation/i');

        (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
    - valueA
      - valueB
YAML);
    }

    public function testThrowsWhenSequenceIndentationIsLessThanBaseIndent(): void
    {
        $this->expectException(IndentationInvalidException::class);
        $this->expectExceptionMessageMatches('/Unexpected indentation/i');

        (new Parser())->parse(<<<'YAML'
levelA:
  levelB:
      - valueA
    - valueB
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

    private function getSequenceScalarText(SequenceEntryNode $entry): string
    {
        $value = $entry->getValue();
        $scalar = $value->getScalar();
        self::assertInstanceOf(ScalarNode::class, $scalar);

        return $scalar->getToken()->text;
    }
}
