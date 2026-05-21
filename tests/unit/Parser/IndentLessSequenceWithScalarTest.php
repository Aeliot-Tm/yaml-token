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

use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use Aeliot\YamlToken\Parser\ParserBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
final class IndentLessSequenceWithScalarTest extends TestCase
{
    public function testParsesIndentlessSequenceAsMappingValue(): void
    {
        $yaml = (string) file_get_contents(__DIR__.'/../../fixture/invalid/indent_less_sequence_with_scalar.yaml');
        $stream = (new ParserBuilder())->createParser()->parse($yaml);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertCount(1, $rootCouples);

        $aValue = $rootCouples[0]->getValue();
        self::assertNotNull($aValue);
        $aCouples = $this->getKeyValueCouples($this->getBlockMapping($aValue));
        self::assertCount(1, $aCouples);

        $bValue = $aCouples[0]->getValue();
        self::assertNotNull($bValue);
        $seq = $bValue->getPayload();
        self::assertInstanceOf(BlockSequenceNode::class, $seq);

        /** @var BlockSequenceEntryNode[] $entries */
        $entries = array_values(array_filter(
            $seq->getChildren(),
            static fn ($n): bool => $n instanceof BlockSequenceEntryNode,
        ));
        self::assertCount(1, $entries);
        $scalar = $entries[0]->getValue()->getPayload();
        self::assertInstanceOf(PlainScalarNode::class, $scalar);
        self::assertSame('value', $scalar->getToken()->text);
    }

    private function getBlockMapping(ValueNode $value): BlockMappingNode
    {
        $blockMapping = $value->getPayload();
        self::assertInstanceOf(BlockMappingNode::class, $blockMapping);

        return $blockMapping;
    }

    /**
     * @return KeyValueCoupleNode[]
     */
    private function getKeyValueCouples(?Node $node): array
    {
        self::assertNotNull($node);

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
}
