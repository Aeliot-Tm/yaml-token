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
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use Aeliot\YamlToken\Parser\ParserBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(PlainScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class BareDocumentNodePropertiesTest extends TestCase
{
    public function testMergesAnchorTagAndScalarSplitAcrossBareDocumentLines(): void
    {
        $value = $this->getOnlyBareDocumentValue((new ParserBuilder())->createParser()->parse(<<<'YAML'
---
&a1
!!str
scalar1
YAML));

        self::assertInstanceOf(AnchorNode::class, $value->getAnchor());
        self::assertSame('a1', $value->getAnchor()->getName());
        self::assertInstanceOf(TagNode::class, $value->getTag());
        self::assertSame('!!str', $value->getTag()->getToken()->text);

        $payload = $value->getPayload();
        self::assertInstanceOf(PlainScalarNode::class, $payload);
        self::assertSame('scalar1', $payload->getToken()->text);
    }

    public function testMergesTagAnchorAndScalarSplitAcrossBareDocumentLines(): void
    {
        $value = $this->getOnlyBareDocumentValue((new ParserBuilder())->createParser()->parse(<<<'YAML'
---
!!str
&a2
scalar2
YAML));

        self::assertInstanceOf(TagNode::class, $value->getTag());
        self::assertSame('!!str', $value->getTag()->getToken()->text);
        self::assertInstanceOf(AnchorNode::class, $value->getAnchor());
        self::assertSame('a2', $value->getAnchor()->getName());

        $payload = $value->getPayload();
        self::assertInstanceOf(PlainScalarNode::class, $payload);
        self::assertSame('scalar2', $payload->getToken()->text);
    }

    public function testMergesAnchorWithTagAndScalarOnNextBareDocumentLine(): void
    {
        $value = $this->getOnlyBareDocumentValue((new ParserBuilder())->createParser()->parse(<<<'YAML'
---
&a3
!!str scalar3
YAML));

        self::assertInstanceOf(AnchorNode::class, $value->getAnchor());
        self::assertSame('a3', $value->getAnchor()->getName());
        self::assertInstanceOf(TagNode::class, $value->getTag());
        self::assertSame('!!str', $value->getTag()->getToken()->text);

        $payload = $value->getPayload();
        self::assertInstanceOf(PlainScalarNode::class, $payload);
        self::assertSame('scalar3', $payload->getToken()->text);
    }

    private function getOnlyBareDocumentValue(StreamNode $stream): ValueNode
    {
        $document = $this->getOnlyDocument($stream);
        $values = array_values(array_filter(
            $document->getChildren(),
            static fn ($node): bool => $node instanceof ValueNode,
        ));

        self::assertCount(1, $values);

        return $values[0];
    }

    private function getOnlyDocument(StreamNode $stream): DocumentNode
    {
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn ($node): bool => $node instanceof DocumentNode,
        ));

        self::assertCount(1, $documents);

        return $documents[0];
    }
}
