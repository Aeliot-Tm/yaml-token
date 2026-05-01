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

use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\TokenHolderInterface;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Parser;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

abstract class ParserMappingTestCase extends TestCase
{
    /**
     * @return iterable<string,array{0: array<string,mixed>, 1: string }>
     */
    abstract public static function getDataForTestMapping(): iterable;

    #[DataProvider('getDataForTestMapping')]
    public function testMapping(array $expectedTokens, string $path): void
    {
        $stream = (new Parser())->parse(str_replace(["\r\n", "\r"], "\n", file_get_contents($path)));
        self::assertSame(
            $expectedTokens,
            $this->buildRepresentation($stream)
        );
    }

    private function buildRepresentation(Node $stream): array
    {
        $representedPropertyNodeIds = [];
        $properties = [];

        if ($stream instanceof TokenHolderInterface) {
            $properties['token'] = $this->representToken($stream->getToken());
        }

        if ($stream instanceof AliasNode) {
            $properties['name'] = $stream->getName();
            $properties['anchorName'] = $stream->getAnchor()?->getName();
        }

        if ($stream instanceof AnchorNode) {
            $properties['name'] = $stream->getName();
            $properties['declarationKeyText'] = $this->tryGetDeclarationKeyText($stream);
        }

        foreach ($this->getExplicitNodeProperties($stream) as $propertyName => $value) {
            if (null === $value) {
                continue;
            }

            if (\is_array($value)) {
                $properties[$propertyName] = array_map(fn (Node $n): array => $this->buildRepresentation($n), $value);
                foreach ($value as $n) {
                    $representedPropertyNodeIds[spl_object_id($n)] = true;
                }

                continue;
            }

            $properties[$propertyName] = $this->buildRepresentation($value);
            $representedPropertyNodeIds[spl_object_id($value)] = true;
        }

        $children = [];
        foreach ($stream->getChildren() as $child) {
            if (isset($representedPropertyNodeIds[spl_object_id($child)])) {
                continue;
            }

            $children[] = $this->buildRepresentation($child);
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
        if ($node instanceof KeyValueCoupleNode) {
            return [
                'indentation' => $node->getIndentation(),
                'key' => $node->getKey(),
                'mergeInstruction' => $node->getMergeInstruction(),
                'mappingValueIndicator' => $node->getMappingValueIndicator(),
                'value' => $node->getValue(),
            ];
        }

        if ($node instanceof KeyNode) {
            return [
                'explicitKeyIndicatorNode' => $node->getExplicitKeyIndicatorNode(),
                'name' => $node->getName(),
            ];
        }

        if ($node instanceof SequenceEntryNode) {
            return [
                'value' => $node->getValue(),
            ];
        }

        if ($node instanceof ValueNode) {
            return [
                'tagProperty' => $node->getTagProperty(),
                'anchor' => $node->getAnchor(),
                'alias' => $node->getAlias(),
                'scalar' => $node->getScalar(),
                'blockMapping' => $node->getBlockMapping(),
                'blockSequence' => $node->getBlockSequence(),
                'flowMapping' => $node->getFlowMapping(),
                'flowSequence' => $node->getFlowSequence(),
            ];
        }

        if ($node instanceof FlowSequenceNode) {
            return [
                'entries' => $node->getEntries(),
            ];
        }

        return [];
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

    private function tryGetDeclarationKeyText(AnchorNode $anchor): ?string
    {
        $couple = $anchor->getDeclarationCouple();
        if (null === $couple) {
            return null;
        }

        $name = $couple->getKey()->getName();
        if (!$name instanceof ScalarNode) {
            return null;
        }

        return $name->getToken()->text;
    }
}
