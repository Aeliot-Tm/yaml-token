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
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class FlowSequenceParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $parseContext): FlowSequenceNode
    {
        $node = new FlowSequenceNode();
        $token = $parseContext->tokens->current();
        if (TokenType::FLOW_SEQUENCE_START !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('There is no expected FLOW_SEQUENCE_START token, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $node->addChild($this->nodeFactory->createSimpleNode($token));
        $parseContext->tokens->advance();

        while (true) {
            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $node);

            $token = $parseContext->tokens->current();
            if (null === $token || TokenType::FLOW_SEQUENCE_END === $token->type) {
                if (TokenType::FLOW_SEQUENCE_END !== $token?->type) {
                    throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_SEQUENCE_END token, but %s given', $token?->type->value ?? '_nothing_'));
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

            $node->addChild($this->registry->getFlowEntryParser()->parse($parseContext));
        }
    }
}
