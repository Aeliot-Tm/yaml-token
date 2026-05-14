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

namespace Aeliot\YamlToken\TestHelper;

use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\TokenHolderInterface;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Token\Token;

/**
 * @template NodeLink of array{type: string, hash: string}
 * @template NodeRender of array{
 *     type: class-string<Node>,
 *     hash: string,
 *     properties: array<string, mixed>,
 *     children: list<array<string, mixed>>
 * }
 */
final class NodeTreeRepresenter
{
    /**
     * @return NodeRender
     */
    public function build(Node $stream): array
    {
        $renderLinks = [];

        return $this->getNodeRender($stream, $renderLinks);
    }

    /**
     * @param NodeLink[] $renderLinks
     *
     * @return NodeRender
     */
    private function getNodeRender(Node $stream, array &$renderLinks): array
    {
        $properties = [];

        if ($stream instanceof AliasNode) {
            $properties['name'] = $stream->getName();
            $properties['anchorName'] = $stream->getAnchor()?->getName();
        }

        if ($stream instanceof AnchorNode) {
            $properties['name'] = $stream->getName();
        }

        if ($stream instanceof TokenHolderInterface) {
            $properties['token'] = $this->representToken($stream->getToken());
        }

        $children = [];
        foreach ($stream->getChildren() as $child) {
            $children[] = $this->render($child, $renderLinks);
        }

        foreach ($this->getExplicitNodeProperties($stream) as $propertyName => $value) {
            if (null === $value) {
                continue;
            }

            if (\is_array($value)) {
                $properties[$propertyName] = [];
                foreach ($value as $propNode) {
                    $properties[$propertyName][] = $this->render($propNode, $renderLinks);
                }

                continue;
            }

            $properties[$propertyName] = $this->render($value, $renderLinks);
        }

        $hash = crc32(json_encode([
            'type' => $stream::class,
            'properties' => $properties,
            'children' => $children,
        ], \JSON_THROW_ON_ERROR));

        return [
            'type' => $stream::class,
            'hash' => $hash,
            'properties' => $properties,
            'children' => $children,
        ];
    }

    /**
     * @return array<string, Node|list<Node>|null>
     */
    private function getExplicitNodeProperties(Node $node): array
    {
        return match (true) {
            $node instanceof BlockMappingNode,
            $node instanceof BlockSequenceNode,
            $node instanceof FlowMappingNode,
            $node instanceof FlowSequenceNode => [
                'entries' => $node->getEntries(),
            ],
            $node instanceof KeyValueCoupleNode => [
                'indentation' => $node->getIndentation(),
                'key' => $node->getKey(),
                'mergeInstruction' => $node->getMergeInstruction(),
                'mappingValueIndicator' => $node->getMappingValueIndicator(),
                'value' => $node->getValue(),
            ],
            $node instanceof KeyNode => [
                'explicitKeyIndicatorNode' => $node->getExplicitKeyIndicatorNode(),
                'nodeProperties' => $node->getProperties(),
                'name' => $node->getName(),
            ],
            $node instanceof NodePropertiesNode => [
                'anchor' => $node->getAnchor(),
                'tag' => $node->getTag(),
            ],
            $node instanceof SequenceEntryNode => [
                'value' => $node->getValue(),
            ],
            $node instanceof ValueNode => [
                'nodeProperties' => $node->getProperties(),
                'alias' => $node->getAlias(),
                'blockMapping' => $node->getBlockMapping(),
                'blockSequence' => $node->getBlockSequence(),
                'flowMapping' => $node->getFlowMapping(),
                'flowSequence' => $node->getFlowSequence(),
                'keyValueCouple' => $node->getKeyValueCouple(),
                'multilinePlainScalar' => $node->getMultilinePlainScalar(),
                'scalar' => $node->getScalar(),
            ],
            default => [],
        };
    }

    /**
     * @param NodeLink[] $renderLinks
     *
     * @return NodeLink|NodeRender
     */
    private function render(Node $node, array &$renderLinks): array
    {
        $objectId = spl_object_id($node);
        $rendered = $renderLinks[$objectId] ?? null;
        if (null === $rendered) {
            $rendered = $this->getNodeRender($node, $renderLinks);
            $renderLinks[$objectId] = [
                'type' => $node::class,
                'hash' => $rendered['hash'],
            ];
        } else {
            $rendered = $renderLinks[$objectId];
        }

        return $rendered;
    }

    /**
     * @return array{type: mixed, text: string}
     */
    private function representToken(Token $token): array
    {
        return [
            'type' => $token->type,
            'text' => $token->text,
        ];
    }
}
