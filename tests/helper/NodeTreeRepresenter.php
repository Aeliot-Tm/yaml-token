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
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\TokenHolderInterface;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Token\Token;

final class NodeTreeRepresenter
{
    /**
     * @return array{type: class-string<Node>, properties: array<string, mixed>, children: list<array<string, mixed>>}
     */
    public function build(Node $stream): array
    {
        $representedPropertyNodeIds = [];
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

        foreach ($this->getExplicitNodeProperties($stream) as $propertyName => $value) {
            if (null === $value) {
                continue;
            }

            if (\is_array($value)) {
                $properties[$propertyName] = array_map(fn (Node $n): array => $this->build($n), $value);
                foreach ($value as $n) {
                    $representedPropertyNodeIds[spl_object_id($n)] = true;
                }

                continue;
            }

            $properties[$propertyName] = $this->build($value);
            $representedPropertyNodeIds[spl_object_id($value)] = true;
        }

        $children = [];
        foreach ($stream->getChildren() as $child) {
            if (isset($representedPropertyNodeIds[spl_object_id($child)])) {
                continue;
            }

            $children[] = $this->build($child);
        }

        return [
            'type' => $stream::class,
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
            $node instanceof BlockMappingNode => [
                'entries' => $node->getEntries(),
            ],
            $node instanceof BlockSequenceNode => [
                'entries' => $node->getEntries(),
            ],
            $node instanceof FlowMappingNode => [
                'entries' => $node->getEntries(),
            ],
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
                'name' => $node->getName(),
                'nodeProperties' => $node->getProperties(),
            ],
            $node instanceof NodePropertiesNode => [
                'anchor' => $node->getAnchor(),
                'tag' => $node->getTag(),
            ],
            $node instanceof SequenceEntryNode => [
                'value' => $node->getValue(),
            ],
            $node instanceof ValueNode => [
                'alias' => $node->getAlias(),
                'blockMapping' => $node->getBlockMapping(),
                'blockSequence' => $node->getBlockSequence(),
                'flowMapping' => $node->getFlowMapping(),
                'flowSequence' => $node->getFlowSequence(),
                'keyValueCouple' => $node->getKeyValueCouple(),
                'multilinePlainScalar' => $node->getMultilinePlainScalar(),
                'nodeProperties' => $node->getProperties(),
                'scalar' => $node->getScalar(),
            ],
            default => [],
        };
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
