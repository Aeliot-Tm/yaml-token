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
#[UsesClass(StreamNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(MergeInstructionNode::class)]
#[UsesClass(AliasNode::class)]
#[UsesClass(AnchorNode::class)]
#[UsesClass(ScalarNode::class)]
final class ParserMergeInstructionTest extends TestCase
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
        self::assertSame(['a', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $rootCouples));

        $b = $rootCouples[1];
        $bValue = $this->asValueNode($b->getValue());
        $bMapping = $this->requireBlockMapping($bValue);

        $merge = $this->getOnlyMergeInstruction($bMapping);
        $aliases = $merge->getAliases();
        self::assertCount(1, $aliases);
        self::assertSame('a_alias', $aliases[0]->getName());

        $anchor = $aliases[0]->getAnchor();
        self::assertInstanceOf(AnchorNode::class, $anchor);
        self::assertSame('a_alias', $anchor->getName());

        $anchorCouple = $aliases[0]->getAnchor()->getDeclarationCouple();
        self::assertInstanceOf(KeyValueCoupleNode::class, $anchorCouple);
        self::assertSame('a', $this->keyText($anchorCouple));

        $bCouples = $this->getKeyValueCouples($bMapping);
        self::assertSame(['c'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $bCouples));
        self::assertSame('valueC', $this->scalarValueText($bCouples[0]));
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
        self::assertSame(['a', 'a2', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->keyText($c), $rootCouples));

        $a2 = $rootCouples[1];
        $b = $rootCouples[2];

        $bValue = $this->asValueNode($b->getValue());
        $bMapping = $this->requireBlockMapping($bValue);
        $merge = $this->getOnlyMergeInstruction($bMapping);
        $aliases = $merge->getAliases();
        self::assertCount(1, $aliases);
        self::assertSame('A', $aliases[0]->getName());

        $anchorCouple = $aliases[0]->getAnchor()->getDeclarationCouple();
        self::assertInstanceOf(KeyValueCoupleNode::class, $anchorCouple);
        self::assertSame($a2, $anchorCouple);
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
