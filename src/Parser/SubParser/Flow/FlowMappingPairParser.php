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
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;

final readonly class FlowMappingPairParser
{
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private FlowPairValueConsumer $flowPairValueConsumer,
        private FlowValueIndicatorConsumer $flowValueIndicatorConsumer,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $parseContext): KeyValueCoupleNode
    {
        $couple = new KeyValueCoupleNode();
        $couple->addChild($this->registry->getKeyParser()->getKeyNode($parseContext));

        if ($this->flowValueIndicatorConsumer->tryConsume($parseContext, $couple)) {
            $this->flowPairValueConsumer->parseValueOrEmpty($parseContext, $couple, TokenType::FLOW_ENTRY, TokenType::FLOW_MAPPING_END);
        }

        $this->anchorPostProcessor->postProcessKeyValueCouple($parseContext->anchorsRegistry, $couple);

        return $couple;
    }
}
