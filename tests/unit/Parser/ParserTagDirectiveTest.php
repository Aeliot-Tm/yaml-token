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
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(TagDirectiveNode::class)]
final class ParserTagDirectiveTest extends TestCase
{
    /**
     * @return array<array{fixture:string, expectedHandle:string, expectedPrefix:string}>
     */
    public static function getDataForTestParsesTagDirective(): array
    {
        return [
            [
                'expectedHandle' => '!',
                'expectedPrefix' => 'tag:yaml.org,2002:',
                'fixture' => __DIR__.'/../../fixture/spec/1.2.2/directive-tag_6.8.yaml',
            ],
            [
                'expectedHandle' => '!',
                'expectedPrefix' => 'tag:yaml.org,2002:',
                'fixture' => __DIR__.'/../../fixture/spec/1.1/directive-tag_7.1.yaml',
            ],
        ];
    }

    #[DataProvider('getDataForTestParsesTagDirective')]
    public function testParsesTagDirective(string $expectedHandle, string $expectedPrefix, string $fixture): void
    {
        $yaml = file_get_contents($fixture);
        self::assertNotFalse($yaml);

        $stream = (new Parser())->parse($yaml);
        $documents = $this->getDocumentNodes($stream);
        self::assertNotEmpty($documents);

        /** @var TagDirectiveNode[] $directives */
        $directives = array_values(array_filter(
            $documents[0]->getChildren(),
            static fn ($n): bool => $n instanceof TagDirectiveNode,
        ));
        self::assertCount(1, $directives);
        self::assertSame('%TAG', $directives[0]->getKeywordToken()->text);
        self::assertSame($expectedHandle, $directives[0]->getHandle());
        self::assertSame($expectedPrefix, $directives[0]->getPrefix());
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
