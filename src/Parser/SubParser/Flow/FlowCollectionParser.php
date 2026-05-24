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

namespace Aeliot\YamlToken\Parser\SubParser\Flow;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\FlowNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\SubParser\Consumer;

final readonly class FlowCollectionParser
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
    ) {
    }

    /**
     * @template T of FlowNode
     *
     * @param T $node
     * @param \Closure(ParseContext): Node $parseEntry
     *
     * @return T
     */
    public function parse(
        ParseContext $parseContext,
        FlowNode $node,
        TokenType $openTokenType,
        TokenType $closeTokenType,
        \Closure $parseEntry,
    ): FlowNode {
        $token = $parseContext->tokens->current();
        if ($openTokenType !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('There is no expected %s token, but %s given', $openTokenType->value, $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $node->addChild($this->nodeFactory->createSimpleNode($token));
        $parseContext->tokens->advance();

        while (true) {
            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $node);

            $token = $parseContext->tokens->current();
            if (null === $token || $closeTokenType === $token->type) {
                if ($closeTokenType !== $token?->type) {
                    throw new UnexpectedTokenException(\sprintf('There is no expected %s token, but %s given', $closeTokenType->value, $token?->type->value ?? '_nothing_'));
                }

                $node->addChild($this->nodeFactory->createSimpleNode($token));
                $parseContext->tokens->advance();
                $this->consumer->collectSpaceAndComments($parseContext->tokens, $node);

                return $node;
            }

            if (TokenType::FLOW_ENTRY === $token->type) {
                $node->addChild($this->nodeFactory->createSimpleNode($token));
                $parseContext->tokens->advance();

                continue;
            }

            $node->addChild($parseEntry($parseContext));
        }
    }
}
