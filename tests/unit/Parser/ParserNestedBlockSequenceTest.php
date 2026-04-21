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
#[UsesClass(Lexer::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(BlockSequenceNode::class)]
#[UsesClass(SequenceEntryNode::class)]
#[UsesClass(ScalarNode::class)]
final class ParserNestedBlockSequenceTest extends TestCase
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
        self::assertSame('levelA', $this->keyText($rootCouples[0]));

        $levelAValue = $this->asValueNode($rootCouples[0]->getValue());
        $levelACouples = $this->getKeyValueCouples($this->requireBlockMapping($levelAValue));
        self::assertCount(2, $levelACouples);
        self::assertSame(['levelB', 'levelC'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $levelACouples));

        $levelBValue = $this->asValueNode($levelACouples[0]->getValue());
        $seq = $levelBValue->getBlockSequence();
        self::assertInstanceOf(BlockSequenceNode::class, $seq);

        $entries = array_values(array_filter(
            $seq->getChildren(),
            static fn ($n): bool => $n instanceof SequenceEntryNode,
        ));
        self::assertCount(2, $entries);
        self::assertSame('valueA', $this->sequenceScalarText($entries[0]));
        self::assertSame('valueB', $this->sequenceScalarText($entries[1]));

        $levelCValue = $this->asValueNode($levelACouples[1]->getValue());
        $levelCScalar = $levelCValue->getScalar();
        self::assertInstanceOf(ScalarNode::class, $levelCScalar);
        self::assertSame('', $levelCScalar->getToken()->text);
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

    private function sequenceScalarText(SequenceEntryNode $entry): string
    {
        $value = $this->asValueNode($entry->getValue());
        $scalar = $value->getScalar();
        self::assertInstanceOf(ScalarNode::class, $scalar);

        return $scalar->getToken()->text;
    }
}
