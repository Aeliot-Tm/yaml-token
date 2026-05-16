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
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
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
 * c-flow-sequence (YAML 1.2.2 §7.4.1). Opening {@code [} is consumed by {@see Parser::runFlowSequenceDriver()}.
 */
final class FlowSequenceBuilder implements BuilderInterface
{
    public function __construct(
        private readonly FlowHost $host,
    ) {
    }

    public function onChildCompleted(Harvester $harvester, Frame $self, Node $child): BuilderResultInterface
    {
        $node = $self->node;
        if (!$node instanceof FlowSequenceNode) {
            throw new UnexpectedTokenException('FlowSequenceBuilder frame node must be FlowSequenceNode');
        }
        $node->addChild($child);

        return new Continued();
    }

    public function step(Harvester $harvester, Frame $self): BuilderResultInterface
    {
        $flowSequenceNode = $self->node;
        if (!$flowSequenceNode instanceof FlowSequenceNode) {
            throw new UnexpectedTokenException('FlowSequenceBuilder frame node must be FlowSequenceNode');
        }

        $this->host->collectSpaceAndComments($harvester, $flowSequenceNode);

        $token = $harvester->tokens->current();
        if (null === $token || TokenType::FLOW_SEQUENCE_END === $token->type) {
            if (TokenType::FLOW_SEQUENCE_END !== $token?->type) {
                throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_SEQUENCE_END token, but %s given', $token?->type->value ?? '_nothing_'));
            }

            $flowSequenceNode->addChild($this->host->createSyntaxTokenNode($token));
            $harvester->tokens->advance();
            $this->host->collectSpaceAndComments($harvester, $flowSequenceNode);

            return new Completed($flowSequenceNode);
        }

        if (TokenType::FLOW_ENTRY === $token->type) {
            $flowSequenceNode->addChild($this->host->createSyntaxTokenNode($token));
            $harvester->tokens->advance();

            return new Continued();
        }

        return new Delegate(new Frame(
            new FlowEntryBuilder($this->host),
            new ValueNode(),
        ));
    }
}
