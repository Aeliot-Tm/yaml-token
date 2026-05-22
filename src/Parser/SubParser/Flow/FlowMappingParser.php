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
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class FlowMappingParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $harvester): FlowMappingNode
    {
        $node = new FlowMappingNode();
        $token = $harvester->tokens->current();
        if (TokenType::FLOW_MAPPING_START !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('There is no expected FLOW_MAPPING_START token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $node->addChild($this->nodeFactory->createSimpleNode($token));
        $harvester->tokens->advance();

        while (true) {
            $this->consumer->collectSpaceCommentEnds($harvester->tokens, $node);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::FLOW_MAPPING_END === $token->type) {
                if (TokenType::FLOW_MAPPING_END !== $token?->type) {
                    throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_MAPPING_END token, but %s given', $token?->type->value ?? '_nothing_'));
                }

                $node->addChild($this->nodeFactory->createSimpleNode($token));
                $harvester->tokens->advance();
                $this->consumer->collectSpaceAndComments($harvester->tokens, $node);

                return $node;
            }

            if (TokenType::FLOW_ENTRY === $token->type) {
                $node->addChild($this->nodeFactory->createSimpleNode($token));
                $harvester->tokens->advance();

                continue;
            }

            if (TokenType::MERGE_INDICATOR === $token->type) {
                $node->addChild($this->registry->getFlowHost()->parseMergeInstructionAtCurrentPosition($harvester));

                continue;
            }

            $node->addChild($this->registry->getFlowMappingPairParser()->parse($harvester));
        }
    }
}
