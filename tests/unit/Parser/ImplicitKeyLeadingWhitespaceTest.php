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

use Aeliot\YamlToken\Emitter\YamlEmitter;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Parser;
use Aeliot\YamlToken\Parser\ParserBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(PlainScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(WhitespaceNode::class)]
#[UsesClass(YamlEmitter::class)]
final class ImplicitKeyLeadingWhitespaceTest extends TestCase
{
    public function testParsesTabBeforeImplicitBlockKeyIntoKeyNode(): void
    {
        $path = __DIR__.'/../../fixture/go_yaml_extra/tabs-that-look-like-indentation/06/in.yaml';
        $source = str_replace(["\r\n", "\r"], "\n", (string) file_get_contents($path));

        $stream = (new ParserBuilder())->createParser()->parse($source);
        self::assertSame($source, (new YamlEmitter())->emit($stream));

        $document = $this->getOnlyDocument($stream);
        $rootCouple = $this->getKeyValueCouples($document)[0];
        self::assertSame('foo', $this->getKeyText($rootCouple));

        $fooValue = $rootCouple->getValue();
        self::assertNotNull($fooValue);
        $nestedCouples = $this->getKeyValueCouples($this->getBlockMapping($fooValue));
        self::assertCount(2, $nestedCouples);
        self::assertSame(['a', 'b'], array_map(fn (KeyValueCoupleNode $c): string => $this->getKeyText($c), $nestedCouples));
        self::assertSame('1', $this->getScalarValueText($nestedCouples[0]));
        self::assertSame('2', $this->getScalarValueText($nestedCouples[1]));

        $keyB = $nestedCouples[1]->getKey();
        self::assertNotNull($keyB);
        $leadingWhitespace = array_values(array_filter(
            $keyB->getChildren(),
            static fn (Node $child): bool => $child instanceof WhitespaceNode,
        ));
        self::assertCount(1, $leadingWhitespace);
        self::assertSame("\t", $leadingWhitespace[0]->getToken()->text);

        $name = $keyB->getName();
        self::assertInstanceOf(PlainScalarNode::class, $name);
        self::assertSame('b', $name->getToken()->text);
    }

    private function getBlockMapping(ValueNode $value): BlockMappingNode
    {
        $blockMapping = $value->getPayload();
        self::assertInstanceOf(BlockMappingNode::class, $blockMapping);

        return $blockMapping;
    }

    private function getKeyText(KeyValueCoupleNode $couple): string
    {
        $name = $couple->getKey()->getName();
        self::assertInstanceOf(PlainScalarNode::class, $name);

        return (string) $name->getToken()->text;
    }

    /**
     * @return KeyValueCoupleNode[]
     */
    private function getKeyValueCouples(Node $node): array
    {
        return array_values(array_filter(
            $node->getChildren(),
            static fn (Node $child): bool => $child instanceof KeyValueCoupleNode,
        ));
    }

    private function getOnlyDocument(StreamNode $stream): DocumentNode
    {
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn (Node $child): bool => $child instanceof DocumentNode,
        ));
        self::assertCount(1, $documents);

        return $documents[0];
    }

    private function getScalarValueText(KeyValueCoupleNode $couple): string
    {
        $valueNode = $couple->getValue();
        self::assertNotNull($valueNode);
        $scalar = $valueNode->getPayload();
        self::assertInstanceOf(PlainScalarNode::class, $scalar);

        return $scalar->getToken()->text;
    }
}
