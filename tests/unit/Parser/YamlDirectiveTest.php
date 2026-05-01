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

use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Node\YamlDirectiveVersionNode;
use Aeliot\YamlToken\Parser\Exception\UnexpectedEndException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(YamlDirectiveNode::class)]
#[UsesClass(YamlDirectiveVersionNode::class)]
final class YamlDirectiveTest extends TestCase
{
    /**
     * @return array<array<string>>
     */
    public static function getDataForTestThrowsAtEndOfFile(): array
    {
        return [['%YAML'], ['%YAML:'], ['%YAML '], ['%YAML : ']];
    }

    /**
     * @return array<array<string>>
     */
    public static function getDataForTestWhenNoVersion(): array
    {
        return [["%YAML\n"], ["%YAML # no version\n"]];
    }

    public function testParsesYamlDirectiveWithColonSeparator(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../fixture/spec_extra/1.0/directive_4.3.2.yaml');
        self::assertNotFalse($yaml);

        $stream = (new Parser())->parse($yaml);
        $documents = $this->getDocumentNodes($stream);
        self::assertNotEmpty($documents);

        $first = $documents[0];
        $directive = $first->getChildren()[0];
        self::assertInstanceOf(YamlDirectiveNode::class, $directive);
        self::assertSame('%YAML', $directive->getToken()->text);
        $versionNodes = array_values(array_filter(
            $directive->getChildren(),
            static fn ($n): bool => $n instanceof YamlDirectiveVersionNode,
        ));
        self::assertCount(1, $versionNodes);
        self::assertSame('1.0', $versionNodes[0]->getToken()->text);
    }

    public function testParsesYamlDirectiveWithSpaceSeparator(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../fixture/spec/1.2.2/directive_6.8.yaml');
        self::assertNotFalse($yaml);

        $stream = (new Parser())->parse($yaml);
        $documents = $this->getDocumentNodes($stream);
        self::assertGreaterThanOrEqual(2, \count($documents));

        $first = $documents[0];
        $children = $first->getChildren();
        self::assertNotEmpty($children);
        self::assertInstanceOf(YamlDirectiveNode::class, $children[0]);
        $directive = $children[0];
        self::assertSame('%YAML', $directive->getToken()->text);
        $versionNodes = array_values(array_filter(
            $directive->getChildren(),
            static fn ($n): bool => $n instanceof YamlDirectiveVersionNode,
        ));
        self::assertCount(1, $versionNodes);
        self::assertSame('1.2', $versionNodes[0]->getToken()->text);

        $second = $documents[1];
        $secondChildren = $second->getChildren();
        self::assertNotEmpty($secondChildren);
        self::assertInstanceOf(DocumentStartNode::class, $secondChildren[0]);

        $couples = array_values(array_filter(
            $secondChildren,
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
        self::assertCount(1, $couples);
        $name = $couples[0]->getKey()->getName();
        self::assertInstanceOf(ScalarNode::class, $name);
        self::assertSame('key', $name->getToken()->text);
    }

    public function testParsesMultipleYamlDirectivesWithTrailingComment(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
%YAML 1.2 # ok
%YAML 1.2
YAML);

        $documents = $this->getDocumentNodes($stream);
        self::assertCount(1, $documents);

        $directives = array_values(array_filter(
            $documents[0]->getChildren(),
            static fn ($n): bool => $n instanceof YamlDirectiveNode,
        ));
        self::assertCount(2, $directives);
    }

    #[DataProvider('getDataForTestWhenNoVersion')]
    public function testThrowsWhenNoVersion(string $yaml): void
    {
        $this->expectException(UnexpectedTokenException::class);
        $this->expectExceptionMessageMatches('/^Expected YAML directive version before newline or comment/');

        (new Parser())->parse($yaml);
    }

    #[DataProvider('getDataForTestThrowsAtEndOfFile')]
    public function testThrowsAtEndOfFile(string $yaml): void
    {
        $this->expectException(UnexpectedEndException::class);
        $this->expectExceptionMessageMatches('/^Unexpected end of token stream: YAML directive version is required/');

        (new Parser())->parse($yaml);
    }

    /**
     * @return list<DocumentNode>
     */
    private function getDocumentNodes(StreamNode $stream): array
    {
        return array_values(array_filter(
            $stream->getChildren(),
            static fn ($n): bool => $n instanceof DocumentNode,
        ));
    }
}
