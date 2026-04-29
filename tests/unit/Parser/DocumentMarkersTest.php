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
use Aeliot\YamlToken\Node\ByteOrderNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(ByteOrderNode::class)]
#[UsesClass(DocumentEndNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(StreamNode::class)]
final class DocumentMarkersTest extends TestCase
{
    public function testParsesByteOrderMarkAsStreamChild(): void
    {
        $stream = (new Parser())->parse("\xEF\xBB\xBFkey: value\n");

        $children = $stream->getChildren();
        self::assertNotEmpty($children);
        self::assertInstanceOf(ByteOrderNode::class, $children[0]);
        self::assertSame("\xEF\xBB\xBF", $children[0]->getToken()->text);
    }

    public function testParsesDocumentEndMarker(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../fixture/spec/1.2.2/document-end_9.1.yaml');
        self::assertNotFalse($yaml);

        $stream = (new Parser())->parse($yaml);
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn ($n): bool => $n instanceof DocumentNode,
        ));
        self::assertNotEmpty($documents);

        $endMarkers = array_values(array_filter(
            $documents[0]->getChildren(),
            static fn ($n): bool => $n instanceof DocumentEndNode,
        ));
        self::assertCount(1, $endMarkers);
        self::assertSame('...', $endMarkers[0]->getToken()->text);
    }
}
