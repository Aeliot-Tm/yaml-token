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
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class FlowSequenceParser
{
    public function __construct(
        private FlowCollectionParser $flowCollectionParser,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $parseContext): FlowSequenceNode
    {
        return $this->flowCollectionParser->parse(
            $parseContext,
            new FlowSequenceNode(),
            TokenType::FLOW_SEQUENCE_START,
            TokenType::FLOW_SEQUENCE_END,
            fn (ParseContext $ctx) => $this->registry->getFlowEntryParser()->parse($ctx),
        );
    }
}
