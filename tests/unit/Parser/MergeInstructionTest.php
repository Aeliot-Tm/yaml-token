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
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(AliasNode::class)]
#[UsesClass(AnchorNode::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(MergeInstructionNode::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class MergeInstructionTest extends TestCase
{
    public function testParsesMergeInstructionAsMappingChildNotCouple(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
a: &a_alias
  a1: valueA1
b:
  <<: *a_alias
  c: valueC
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertSame(['a', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $rootCouples));

        $b = $rootCouples[1];
        $bValue = $b->getValue();
        self::assertNotNull($bValue);
        $bMapping = $this->getBlockMapping($bValue);

        $merge = $this->getOnlyMergeInstruction($bMapping);
        $aliases = $merge->getAliases();
        self::assertCount(1, $aliases);
        self::assertSame('a_alias', $aliases[0]->getName());

        $anchor = $aliases[0]->getAnchor();
        self::assertInstanceOf(AnchorNode::class, $anchor);
        self::assertSame('a_alias', $anchor->getName());

        $anchorCouple = $aliases[0]->getAnchor()->getDeclarationCouple();
        self::assertInstanceOf(KeyValueCoupleNode::class, $anchorCouple);
        self::assertSame('a', $this->getKeyText($anchorCouple));

        $bCouples = $this->getKeyValueCouples($bMapping);
        self::assertSame(['c'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $bCouples));
        self::assertSame('valueC', $this->getScalarValueText($bCouples[0]));
    }

    public function testThrowsOnUndefinedAliasInMergeInstruction(): void
    {
        $this->expectException(AnchorUndefinedException::class);
        $this->expectExceptionMessageMatches('/Undefined alias/i');

        (new Parser())->parse(<<<'YAML'
b:
  <<: *missing
  c: valueC
YAML);
    }

    public function testUsesMostRecentAnchorDeclarationWhenOverridden(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
a: &A {k: v1}
a2: &A {k: v2}
b:
  <<: *A
YAML);

        $document = $this->getOnlyDocument($stream);
        $rootCouples = $this->getKeyValueCouples($document);
        self::assertSame(['a', 'a2', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $rootCouples));

        [, $a2, $b] = $rootCouples;

        $bValue = $b->getValue();
        self::assertNotNull($bValue);
        $bMapping = $this->getBlockMapping($bValue);
        $merge = $this->getOnlyMergeInstruction($bMapping);
        $aliases = $merge->getAliases();
        self::assertCount(1, $aliases);
        self::assertSame('A', $aliases[0]->getName());

        $anchorCouple = $aliases[0]->getAnchor()->getDeclarationCouple();
        self::assertInstanceOf(KeyValueCoupleNode::class, $anchorCouple);
        self::assertSame($a2, $anchorCouple);
    }

    private function getBlockMapping(ValueNode $value): BlockMappingNode
    {
        $blockMapping = $value->getBlockMapping();
        self::assertInstanceOf(BlockMappingNode::class, $blockMapping);

        return $blockMapping;
    }

    private function getKeyText(KeyValueCoupleNode $couple): string
    {
        $name = $couple->getKey()->getName();
        self::assertInstanceOf(ScalarNode::class, $name);

        return (string) $name->getToken()->text;
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

    private function getOnlyMergeInstruction(object $node): MergeInstructionNode
    {
        $children = $node->getChildren();
        $instructions = array_values(array_filter(
            $children,
            static fn ($n): bool => $n instanceof MergeInstructionNode,
        ));

        self::assertCount(1, $instructions);

        return $instructions[0];
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
