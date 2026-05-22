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

namespace Aeliot\YamlToken\Parser\SubParser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class MergeInstructionParser implements SubParserInterface
{
    /**
     * @param \Closure(ParseContext, int): ValueNode $parseValue
     */
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
        private \Closure $parseValue,
    ) {
    }

    public function parseMergeInstructionAtCurrentPosition(ParseContext $parseContext): MergeInstructionNode
    {
        $mergeInstruction = new MergeInstructionNode();

        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION === $token?->type) {
            $mergeInstruction->addChild(new IndentationNode($token));
            $parseContext->tokens->advance();
            $token = $parseContext->tokens->current();
        }

        if (TokenType::MERGE_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('There is no expected MERGE_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }
        $mergeInstruction->addChild($this->nodeFactory->createSimpleNode($token));
        $parseContext->tokens->advance();

        $this->consumer->collectTypes($parseContext->tokens, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $mergeInstruction);

        $value = ($this->parseValue)($parseContext, EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value);
        $mergeInstruction->addChild($value);

        $aliases = $this->collectMergeAliases($value);
        foreach ($aliases as $alias) {
            $mergeInstruction->addAlias($alias);
        }

        return $mergeInstruction;
    }

    /**
     * @return list<AliasNode>
     */
    private function collectMergeAliases(ValueNode $value): array
    {
        $directAliases = array_values(array_filter(
            $value->getChildren(),
            static fn (Node $n): bool => $n instanceof AliasNode,
        ));
        if ($directAliases) {
            /* @var list<AliasNode> $directAliases */
            return $directAliases;
        }

        $flowSequence = null;
        foreach ($value->getChildren() as $child) {
            if ($child instanceof FlowSequenceNode) {
                $flowSequence = $child;
                break;
            }
        }
        if (null === $flowSequence) {
            throw new UnexpectedStateException('Merge value must be an alias or a flow sequence of aliases');
        }

        $aliases = [];
        foreach ($flowSequence->getEntries() as $entry) {
            $entryAliases = array_values(array_filter(
                $entry->getChildren(),
                static fn (Node $n): bool => $n instanceof AliasNode,
            ));
            if (1 !== \count($entryAliases)) {
                $references = array_map(static fn (AliasNode $a): string => $a->getToken()->text, $entryAliases);
                throw new UnexpectedStateException(\sprintf('Each merge sequence entry must contain exactly one alias but %d given: %s', \count($references), implode(', ', $references)));
            }
            $aliases[] = $entryAliases[0];
        }

        return $aliases;
    }
}
