# Node Traversal

Post-parse utilities for walking the parser node tree depth-first.

## Purpose

`NodeTraverser` visits every node reachable via `Node::getChildren()` in document order.
Use it for read-only analysis of a parsed YAML stream (for example collecting `CommentNode`
instances or building a context stack in a consumer such as TODO Registrar).

The API is intentionally similar to `nikic/php-parser` visitors, but the traverser does not
mutate or replace nodes.

## Components

| Class / interface | Role |
|-------------------|------|
| `NodeTraverser` | Runs registered visitors over a tree rooted at any `Node` (typically `StreamNode`). |
| `NodeTraverserInterface` | Contract for the traverser (`addVisitor`, `removeVisitor`, `traverse`). |
| `NodeVisitorInterface` | Visitor hooks (`beforeTraverse`, `enterNode`, `leaveNode`, `afterTraverse`). |
| `NodeVisitorAbstract` | Empty default implementations of all visitor methods. |
| `NodeVisitorSignal` | Enum returned from `enterNode()` / `leaveNode()` to control the walk. |

Traversal classes live under `src/Traversal/`. `NodeVisitorSignal` lives under `src/Enum/`.

## Visitor lifecycle

For each traversal of `$root`:

1. `beforeTraverse($root)` — every visitor, in registration order.
2. Depth-first walk: `enterNode($node)` on the way down, `leaveNode($node)` on the way up.
3. `afterTraverse($root)` — every visitor, in reverse registration order.

Children are taken only from `getChildren()`. Typed accessors on composite nodes
(`KeyValueCoupleNode::getKey()`, `ValueNode::getPayload()`, and so on) are not used separately;
those nodes are already present in the children list.

## Control signals

Return a `NodeVisitorSignal` case from `enterNode()` or `leaveNode()` to control the walk:

| Case | Set on | Effect |
|------|--------|--------|
| `DontTraverseChildren` | `enterNode()` | Skip children of the current node; still call `leaveNode()` for it. |
| `StopTraversal` | `enterNode()` or `leaveNode()` | Abort the walk immediately. `leaveNode()` is not called for the node that stopped on `enterNode()`. `afterTraverse()` is still invoked. |

Return `null` to continue normally.

## Example

```php
use Aeliot\YamlToken\Enum\NodeVisitorSignal;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\ParserBuilder;
use Aeliot\YamlToken\Traversal\NodeTraverser;
use Aeliot\YamlToken\Traversal\NodeVisitorAbstract;

$stream = (new ParserBuilder())->createParser()->parse($yaml);

$collector = new class () extends NodeVisitorAbstract {
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
```

To skip descending into a subtree:

```php
public function enterNode(Node $node): ?NodeVisitorSignal
{
    if ($node instanceof SomeNode) {
        return NodeVisitorSignal::DontTraverseChildren;
    }

    return null;
}
```

## Tests

Unit tests: `tests/unit/Traversal/NodeTraverserTest.php`.

Run:

```bash
docker compose exec php-cli composer bin-phpunit -- --filter NodeTraverserTest
```
