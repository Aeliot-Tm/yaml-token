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
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class BlockScalarTest extends TestCase
{
    /**
     * @return array<array{fixture:string, expected:string}>
     */
    public static function getDataForTestParsesBlockScalars(): array
    {
        return [
            [
                'expected' => "  Line one\n  Line two\n  Line three\n",
                'fixture' => __DIR__.'/../../fixture/spec/1.2.2/literal-block_8.1.2.yaml',
            ],
            [
                'expected' => "  This is a long line\n  that folds into space.\n\n  New paragraph here.\n",
                'fixture' => __DIR__.'/../../fixture/spec/1.2.2/folded-block_8.1.3.yaml',
            ],
        ];
    }

    #[DataProvider('getDataForTestParsesBlockScalars')]
    public function testParsesBlockScalars(string $fixture, string $expected): void
    {
        $yaml = file_get_contents($fixture);
        self::assertNotFalse($yaml);

        $stream = (new Parser())->parse($yaml);
        $couple = $this->getOnlyCouple($stream);

        $value = $couple->getValue();
        self::assertNotNull($value);

        $scalar = $value->getScalar();
        self::assertInstanceOf(ScalarNode::class, $scalar);
        self::assertSame($expected, $scalar->getToken()->text);
    }

    private function getOnlyCouple(StreamNode $stream): KeyValueCoupleNode
    {
        $documents = array_values(array_filter(
            $stream->getChildren(),
            static fn ($n): bool => $n instanceof DocumentNode,
        ));
        self::assertCount(1, $documents);

        $couples = array_values(array_filter(
            $documents[0]->getChildren(),
            static fn ($n): bool => $n instanceof KeyValueCoupleNode,
        ));
        self::assertCount(1, $couples);

        return $couples[0];
    }
}
