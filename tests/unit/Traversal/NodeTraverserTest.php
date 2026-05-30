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

namespace Aeliot\YamlToken\Test\Unit\Traversal;

use Aeliot\YamlToken\Enum\NodeVisitorSignal;
use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\ParserBuilder;
use Aeliot\YamlToken\TestStub\Traversal\RecordingVisitor;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Traversal\NodeTraverser;
use Aeliot\YamlToken\Traversal\NodeTraverserInterface;
use Aeliot\YamlToken\Traversal\NodeVisitorAbstract;
use Aeliot\YamlToken\Traversal\NodeVisitorInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NodeTraverser::class)]
#[UsesClass(NodeVisitorAbstract::class)]
#[UsesClass(NodeVisitorInterface::class)]
#[UsesClass(NodeVisitorSignal::class)]
final class NodeTraverserTest extends TestCase
{
    public function testAfterTraverseIsCalledWhenEnterNodeStopsTraversal(): void
    {
        $root = new StreamNode();
        $visitor = new class() extends NodeVisitorAbstract {
            public int $afterTraverseCount = 0;

            public function afterTraverse(Node $root): ?Node
            {
                ++$this->afterTraverseCount;

                return null;
            }

            public function enterNode(Node $node): ?NodeVisitorSignal
            {
                return NodeVisitorSignal::StopTraversal;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($root);

        self::assertSame(1, $visitor->afterTraverseCount);
    }

    public function testDontTraverseChildrenSkipsDescendantsButCallsLeaveNode(): void
    {
        $root = new StreamNode();
        $document = new DocumentNode();
        $scalar = new PlainScalarNode(new Token(TokenType::PLAIN_SCALAR, 'value', 1, 1));
        $root->addChild($document);
        $document->addChild($scalar);

        $visitor = new class() extends NodeVisitorAbstract {
            /** @var list<string> */
            public array $events = [];

            public function enterNode(Node $node): ?NodeVisitorSignal
            {
                $this->events[] = 'enter:'.$node::class;

                if ($node instanceof StreamNode) {
                    return NodeVisitorSignal::DontTraverseChildren;
                }

                return null;
            }

            public function leaveNode(Node $node): ?NodeVisitorSignal
            {
                $this->events[] = 'leave:'.$node::class;

                return null;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($root);

        self::assertSame(
            [
                'enter:'.StreamNode::class,
                'leave:'.StreamNode::class,
            ],
            $visitor->events,
        );
    }

    public function testEnterAndLeaveFollowDepthFirstOrder(): void
    {
        $root = new StreamNode();
        $document = new DocumentNode();
        $scalar = new PlainScalarNode(new Token(TokenType::PLAIN_SCALAR, 'value', 1, 1));
        $root->addChild($document);
        $document->addChild($scalar);

        $visitor = new RecordingVisitor();
        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($root);

        self::assertSame(
            [
                'before:'.StreamNode::class,
                'enter:'.StreamNode::class,
                'enter:'.DocumentNode::class,
                'enter:'.PlainScalarNode::class,
                'leave:'.PlainScalarNode::class,
                'leave:'.DocumentNode::class,
                'leave:'.StreamNode::class,
                'after:'.StreamNode::class,
            ],
            $visitor->events,
        );
    }

    public function testMultipleVisitorsReceiveEventsInRegistrationOrder(): void
    {
        $root = new StreamNode();
        $document = new DocumentNode();
        $root->addChild($document);

        $first = new RecordingVisitor('first');
        $second = new RecordingVisitor('second');

        $traverser = new NodeTraverser();
        $traverser->addVisitor($first);
        $traverser->addVisitor($second);
        $traverser->traverse($root);

        self::assertSame(
            [
                'first:before:'.StreamNode::class,
                'first:enter:'.StreamNode::class,
                'first:enter:'.DocumentNode::class,
                'first:leave:'.DocumentNode::class,
                'first:leave:'.StreamNode::class,
                'first:after:'.StreamNode::class,
            ],
            $first->events,
        );
        self::assertSame(
            [
                'second:before:'.StreamNode::class,
                'second:enter:'.StreamNode::class,
                'second:enter:'.DocumentNode::class,
                'second:leave:'.DocumentNode::class,
                'second:leave:'.StreamNode::class,
                'second:after:'.StreamNode::class,
            ],
            $second->events,
        );
    }

    public function testParsesAllCommentNodesFromFixture(): void
    {
        $fixturePath = __DIR__.'/../../fixture/edge_cases/comment_for_each_in_sequence.yaml';
        $yaml = file_get_contents($fixturePath);
        self::assertNotFalse($yaml);

        $parser = (new ParserBuilder())->createParser();
        $stream = $parser->parse($yaml);

        $collector = new class() extends NodeVisitorAbstract {
            /** @var list<CommentNode> */
            public array $comments = [];

            public function enterNode(Node $node): ?NodeVisitorSignal
            {
                if ($node instanceof CommentNode) {
                    $this->comments[] = $node;
                }

                return null;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($collector);
        $traverser->traverse($stream);

        self::assertCount(3, $collector->comments);
        self::assertSame('# Comment for A', $collector->comments[0]->getToken()->text);
        self::assertSame('# Comment for B', $collector->comments[1]->getToken()->text);
        self::assertSame('# Comment for C', $collector->comments[2]->getToken()->text);
    }

    public function testRemoveVisitorStopsReceivingEvents(): void
    {
        $root = new StreamNode();
        $visitor = new RecordingVisitor();
        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->removeVisitor($visitor);
        $traverser->traverse($root);

        self::assertSame([], $visitor->events);
    }

    public function testStopTraversalOnEnterSkipsLeaveNodeForCurrentNode(): void
    {
        $root = new StreamNode();
        $document = new DocumentNode();
        $root->addChild($document);

        $visitor = new class() extends NodeVisitorAbstract {
            /** @var list<string> */
            public array $events = [];

            public function enterNode(Node $node): ?NodeVisitorSignal
            {
                $this->events[] = 'enter:'.$node::class;

                if ($node instanceof DocumentNode) {
                    return NodeVisitorSignal::StopTraversal;
                }

                return null;
            }

            public function leaveNode(Node $node): ?NodeVisitorSignal
            {
                $this->events[] = 'leave:'.$node::class;

                return null;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($root);

        self::assertSame(
            [
                'enter:'.StreamNode::class,
                'enter:'.DocumentNode::class,
            ],
            $visitor->events,
        );
    }

    public function testStopTraversalOnLeaveAbortsRemainingNodes(): void
    {
        $root = new StreamNode();
        $firstDocument = new DocumentNode();
        $secondDocument = new DocumentNode();
        $root->addChild($firstDocument);
        $root->addChild($secondDocument);

        $visitor = new class() extends NodeVisitorAbstract {
            /** @var list<string> */
            public array $events = [];

            public function enterNode(Node $node): ?NodeVisitorSignal
            {
                $this->events[] = 'enter:'.$node::class;

                return null;
            }

            public function leaveNode(Node $node): ?NodeVisitorSignal
            {
                $this->events[] = 'leave:'.$node::class;

                if ($node instanceof DocumentNode) {
                    return NodeVisitorSignal::StopTraversal;
                }

                return null;
            }
        };

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($root);

        self::assertSame(
            [
                'enter:'.StreamNode::class,
                'enter:'.DocumentNode::class,
                'leave:'.DocumentNode::class,
            ],
            $visitor->events,
        );
    }

    public function testTraverserImplementsInterface(): void
    {
        self::assertInstanceOf(NodeTraverserInterface::class, new NodeTraverser());
    }
}
