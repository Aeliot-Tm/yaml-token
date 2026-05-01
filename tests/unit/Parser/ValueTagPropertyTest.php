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

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagBodyNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(TagBodyNode::class)]
#[UsesClass(TagNode::class)]
#[UsesClass(TagPropertyNode::class)]
#[UsesClass(ValueNode::class)]
final class ValueTagPropertyTest extends TestCase
{
    public function testBindsNonSpecificTagToMappingValue(): void
    {
        $couple = $this->getOnlyCouple((new Parser())->parse(<<<'YAML'
key: ! value
YAML));

        $value = $couple->getValue();
        self::assertNotNull($value);
        $tag = $value->getTagProperty();
        self::assertInstanceOf(TagPropertyNode::class, $tag);
        self::assertTrue($tag->isNonSpecific());
        self::assertNull($tag->getBodyNode());
    }

    public function testBindsPrimaryTagToMappingValue(): void
    {
        $couple = $this->getOnlyCouple((new Parser())->parse(<<<'YAML'
key: !local value
YAML));

        $value = $couple->getValue();
        self::assertNotNull($value);
        $tag = $value->getTagProperty();
        self::assertInstanceOf(TagPropertyNode::class, $tag);

        $handle = $tag->getHandle();
        self::assertInstanceOf(TagNode::class, $handle);
        self::assertSame(TokenType::TAG_HANDLE_PRIMARY, $handle->getToken()->type);
        self::assertSame('local', $tag->getBody());
        self::assertFalse($tag->isNonSpecific());
    }

    public function testBindsSecondaryTagToMappingValue(): void
    {
        $couple = $this->getOnlyCouple((new Parser())->parse(<<<'YAML'
key: !!str value
YAML));

        $value = $couple->getValue();
        self::assertNotNull($value);
        $tag = $value->getTagProperty();
        self::assertInstanceOf(TagPropertyNode::class, $tag);

        $handle = $tag->getHandle();
        self::assertInstanceOf(TagNode::class, $handle);
        self::assertSame(TokenType::TAG_HANDLE_SECONDARY, $handle->getToken()->type);
        self::assertSame('str', $tag->getBody());
        self::assertFalse($tag->isNonSpecific());

        $scalar = $value->getScalar();
        self::assertInstanceOf(ScalarNode::class, $scalar);
        self::assertSame('value', $scalar->getToken()->text);
    }

    public function testBindsTagOnOwnLineToIndentedBlockMappingValue(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
root:
  tagged:
    !localTag
      child: value
YAML);

        $rootCouple = $this->getOnlyCouple($stream);
        $rootValue = $rootCouple->getValue();
        self::assertNotNull($rootValue);

        $rootMapping = $this->getFirstChildOfType($rootValue, BlockMappingNode::class);
        self::assertInstanceOf(BlockMappingNode::class, $rootMapping);
    }

    public function testBindsVerbatimTagToMappingValue(): void
    {
        $couple = $this->getOnlyCouple((new Parser())->parse(<<<'YAML'
key: !<tag:yaml.org,2002:str> value
YAML));

        $value = $couple->getValue();
        self::assertNotNull($value);
        $tag = $value->getTagProperty();
        self::assertInstanceOf(TagPropertyNode::class, $tag);

        $handle = $tag->getHandle();
        self::assertInstanceOf(TagNode::class, $handle);
        self::assertSame(TokenType::TAG_HANDLE_VERBATIM, $handle->getToken()->type);
        self::assertNull($tag->getBodyNode());
        self::assertFalse($tag->isNonSpecific());
    }

    public function testThrowsWhenTwoTagsAreSpecifiedForSameValue(): void
    {
        $this->expectException(UnexpectedStateException::class);
        $this->expectExceptionMessageMatches('/^Only one tag property is supported per value node/');

        (new Parser())->parse(<<<'YAML'
key: !!str !local value
YAML);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $class
     *
     * @return T|null
     */
    private function getFirstChildOfType(ValueNode $value, string $class): ?object
    {
        foreach ($value->getChildren() as $child) {
            if ($child instanceof $class) {
                return $child;
            }
        }

        return null;
    }

    private function getOnlyCouple(StreamNode $stream): KeyValueCoupleNode
    {
        $document = $this->getOnlyDocument($stream);
        $couples = array_values(array_filter(
            $document->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));

        self::assertCount(1, $couples);

        return $couples[0];
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
