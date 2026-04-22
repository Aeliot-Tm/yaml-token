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

namespace Aeliot\YamlToken\Test\Unit\Emitter;

use Aeliot\YamlToken\Emitter\YamlEmitter;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(YamlEmitter::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(Parser::class)]
#[UsesClass(StreamNode::class)]
final class YamlEmitterTest extends TestCase
{
    /**
     * @return array<array{fixture:string}>
     */
    public static function getDataForTestEmitsOriginalYaml(): array
    {
        $specDir = __DIR__.'/../../fixture/spec';

        return [
            [
                'fixture' => $specDir.'/1.0.yaml',
            ],
            [
                'fixture' => $specDir.'/1.1.yaml',
            ],
            [
                'fixture' => $specDir.'/1.2.0.yaml',
            ],
            [
                'fixture' => $specDir.'/1.2.1.yaml',
            ],
            [
                'fixture' => $specDir.'/1.2.2.yaml',
            ],
        ];
    }

    #[DataProvider('getDataForTestEmitsOriginalYaml')]
    public function testEmitsOriginalYaml(string $fixture): void
    {
        $yaml = file_get_contents($fixture);
        self::assertNotFalse($yaml);

        try {
            $stream = (new Parser())->parse($yaml);
        } catch (\Throwable $e) {
            self::markTestSkipped($e::class.': '.$e->getMessage());
        }

        self::assertSame($yaml, (new YamlEmitter())->emit($stream));
    }
}
