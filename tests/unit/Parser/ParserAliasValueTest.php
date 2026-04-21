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
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(AliasNode::class)]
#[UsesClass(AnchorNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class ParserAliasValueTest extends TestCase
{
    public function testResolvesAliasValueToAnchorDeclaration(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
a: &A valueA
b: *A
YAML);

        $document = $this->getOnlyDocument($stream);
        $couples = $this->getCouples($document);
        self::assertCount(2, $couples);

        $a = $couples[0];
        $b = $couples[1];

        $aValue = $a->getValue();
        self::assertInstanceOf(ValueNode::class, $aValue);
        $aAnchor = $aValue->getAnchor();
        self::assertInstanceOf(AnchorNode::class, $aAnchor);
        self::assertSame('A', $aAnchor->getName());
        self::assertSame($a, $aAnchor->getDeclarationCouple());

        $bValue = $b->getValue();
        self::assertInstanceOf(ValueNode::class, $bValue);
        $aliases = array_values(array_filter(
            $bValue->getChildren(),
            static fn ($n): bool => $n instanceof AliasNode,
        ));
        self::assertCount(1, $aliases);
        self::assertSame('A', $aliases[0]->getName());
        self::assertSame($aAnchor, $aliases[0]->getAnchor());
    }

    public function testThrowsOnUndefinedAliasUsedAsValue(): void
    {
        $this->expectException(AnchorUndefinedException::class);
        $this->expectExceptionMessageMatches('/Undefined alias/i');

        (new Parser())->parse(<<<'YAML'
key: *missing
YAML);
    }

    /**
     * @return list<KeyValueCoupleNode>
     */
    private function getCouples(DocumentNode $document): array
    {
        return array_values(array_filter(
            $document->getChildren(),
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
