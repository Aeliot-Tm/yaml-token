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
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;

final readonly class FlowPairValueConsumer
{
    public function __construct(
        private FlowStructureIdentifier $flowStructureIdentifier,
        private ParserRegistry $registry,
    ) {
    }

    public function parseValueOrEmpty(
        ParseContext $parseContext,
        KeyValueCoupleNode $couple,
        TokenType ...$emptyTerminators,
    ): void {
        if ($this->flowStructureIdentifier->isNextSignificantTokenOneOf($parseContext, true, ...$emptyTerminators)) {
            $couple->addChild(new ValueNode());
        } else {
            $couple->addChild($this->registry->getValueParser()->parseValue($parseContext, IndentContext::createForFlow()));
        }
    }
}
