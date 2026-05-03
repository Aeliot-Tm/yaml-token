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

namespace Aeliot\YamlToken\Parser\Builder;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Driver\BuilderInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\BuilderResultInterface;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Completed;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Continued;
use Aeliot\YamlToken\Parser\Driver\BuilderResult\Delegate;
use Aeliot\YamlToken\Parser\Driver\Frame;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Flow\FlowHost;

/**
 * c-flow-mapping (YAML 1.2.2 §7.4.2). Opening {@code "{"} is consumed by {@see Parser::runFlowMappingDriver()}.
 */
final class FlowMappingBuilder implements BuilderInterface
{
    public function __construct(
        private readonly FlowHost $host,
    ) {
    }

    public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface
    {
        $node = $self->node;
        if (!$node instanceof FlowMappingNode) {
            throw new UnexpectedTokenException('FlowMappingBuilder frame node must be FlowMappingNode');
        }
        $node->addChild($child);

        return new Continued();
    }

    public function step(Harvester $harvester, Frame $self): BuilderResultInterface
    {
        $flowMappingNode = $self->node;
        if (!$flowMappingNode instanceof FlowMappingNode) {
            throw new UnexpectedTokenException('FlowMappingBuilder frame node must be FlowMappingNode');
        }

        $this->host->collectSpaceAndComments($harvester, $flowMappingNode);

        $token = $harvester->tokens->current();
        if (null === $token || TokenType::FLOW_MAPPING_END === $token->type) {
            if (TokenType::FLOW_MAPPING_END !== $token?->type) {
                throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_MAPPING_END token, but %s given', $token?->type->value ?? '_nothing_'));
            }

            $flowMappingNode->addChild($this->host->createSyntaxTokenNode($token));
            $harvester->tokens->advance();
            $this->host->collectSpaceAndComments($harvester, $flowMappingNode);

            return new Completed($flowMappingNode);
        }

        if (TokenType::FLOW_ENTRY === $token->type) {
            $flowMappingNode->addChild($this->host->createSyntaxTokenNode($token));
            $harvester->tokens->advance();

            return new Continued();
        }

        if (TokenType::MERGE_INDICATOR === $token->type) {
            $flowMappingNode->addChild($this->host->parseMergeInstructionAtCurrentPosition($harvester));

            return new Continued();
        }

        return new Delegate(new Frame(
            new FlowMappingPairBuilder($this->host),
            $self->context,
            new KeyValueCoupleNode(),
        ));
    }
}
