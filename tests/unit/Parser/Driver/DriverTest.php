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

namespace Aeliot\YamlToken\Test\Unit\Parser\Driver;

use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Driver\Driver;
use Aeliot\YamlToken\Parser\Driver\Frame;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Dto\ParseRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\TestHelper\Parser\Driver\TestRootDelegateOnceBuilder;
use Aeliot\YamlToken\TestHelper\Parser\Driver\TestRootNestedDelegateBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Driver::class)]
#[UsesClass(Frame::class)]
final class DriverTest extends TestCase
{
    public function testDelegateThenCompletedDeliversChildToParent(): void
    {
        $harvester = $this->createHarvester();
        $rootNode = new ValueNode();
        $driver = new Driver();
        $result = $driver->run($harvester, new Frame(new TestRootDelegateOnceBuilder(), new ParseContext(), $rootNode));

        self::assertSame($rootNode, $result);
        self::assertCount(1, $rootNode->getChildren());
        self::assertInstanceOf(ValueNode::class, $rootNode->getChildren()[0]);
    }

    public function testNestedDelegatesUnwindInOrder(): void
    {
        $harvester = $this->createHarvester();
        $rootNode = new ValueNode();
        $driver = new Driver();
        $result = $driver->run(
            $harvester,
            new Frame(new TestRootNestedDelegateBuilder(), new ParseContext(), $rootNode)
        );

        self::assertSame($rootNode, $result);
        $children = $rootNode->getChildren();
        self::assertCount(1, $children);
        self::assertInstanceOf(ValueNode::class, $children[0]);
        $midChildren = $children[0]->getChildren();
        self::assertCount(1, $midChildren);
        self::assertInstanceOf(ValueNode::class, $midChildren[0]);
    }

    private function createHarvester(): Harvester
    {
        $harvester = new Harvester(new TokenStreamProxy((new Lexer())->tokenize('')));
        $harvester->registry = new ParseRegistry();
        $harvester->state = new ParseState();
        $harvester->stream = new StreamNode();

        return $harvester;
    }
}
