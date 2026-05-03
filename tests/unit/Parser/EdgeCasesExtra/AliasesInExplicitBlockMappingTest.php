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

namespace Aeliot\YamlToken\Test\Unit\Parser\EdgeCasesExtra;

use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
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
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
final class AliasesInExplicitBlockMappingTest extends TestCase
{
    public function testResolvesAliasToAnchorDeclaredOnExplicitKey(): void
    {
        $input = (string) file_get_contents(__DIR__.'/../../../fixture/go_yaml_extra/aliases-in-explicit-block-mapping/in.yaml');
        self::assertNotSame('', $input);

        $stream = (new Parser())->parse($input);
        $document = $this->getOnlyDocument($stream);
        $couples = $this->getCouples($document);

        self::assertCount(2, $couples);
        [$explicitKeyCouple, $emptyKeyCouple] = $couples;

        $explicitKey = $explicitKeyCouple->getKey();
        self::assertNotNull($explicitKey->getExplicitKeyIndicatorNode());
        self::assertInstanceOf(ScalarNode::class, $explicitKey->getName());

        $declaredAnchor = $explicitKey->getAnchor();
        self::assertInstanceOf(AnchorNode::class, $declaredAnchor);
        self::assertSame('a', $declaredAnchor->getName());
        self::assertSame($explicitKeyCouple, $declaredAnchor->getDeclarationCouple());

        $emptyKey = $emptyKeyCouple->getKey();
        self::assertNull($emptyKey->getName());

        $value = $emptyKeyCouple->getValue();
        self::assertNotNull($value);
        $aliases = array_values(array_filter(
            $value->getChildren(),
            static fn ($n): bool => $n instanceof AliasNode,
        ));
        /* @var list<AliasNode> $aliases */
        self::assertCount(1, $aliases);
        self::assertSame('a', $aliases[0]->getName());
        self::assertSame($declaredAnchor, $aliases[0]->getAnchor());
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
