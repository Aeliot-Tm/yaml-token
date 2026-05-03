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
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Parser::class)]
#[UsesClass(AnchorNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(FlowSequenceNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(ValueNode::class)]
final class AnchorInsideComplexKeyTest extends TestCase
{
    public function testAnchorInsideExplicitBlockKeyTreesToOuterCouple(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
? [ &a foo, bar ]
: value
YAML);

        $couple = $this->getOnlyCouple($stream);
        $anchor = $this->findFirstAnchor($couple->getKey());

        self::assertInstanceOf(AnchorNode::class, $anchor);
        self::assertSame('a', $anchor->getName());
        self::assertSame($couple, $anchor->getDeclarationCouple());
    }

    public function testAnchorInsideFlowSequenceKeyTreesToOuterCouple(): void
    {
        $stream = (new Parser())->parse(<<<'YAML'
[ &a foo, bar ]: value
YAML);

        $couple = $this->getOnlyCouple($stream);
        $anchor = $this->findFirstAnchor($couple->getKey());

        self::assertInstanceOf(AnchorNode::class, $anchor);
        self::assertSame('a', $anchor->getName());
        self::assertSame($couple, $anchor->getDeclarationCouple());
    }

    private function findFirstAnchor(Node $node): ?AnchorNode
    {
        if ($node instanceof AnchorNode) {
            return $node;
        }
        foreach ($node->getChildren() as $child) {
            $found = $this->findFirstAnchor($child);
            if (null !== $found) {
                return $found;
            }
        }

        return null;
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
