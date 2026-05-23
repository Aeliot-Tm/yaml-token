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
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class FlowMappingPairParser
{
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private Consumer $consumer,
        private FlowStructureIdentifier $flowStructureIdentifier,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $parseContext): KeyValueCoupleNode
    {
        $couple = new KeyValueCoupleNode();
        $couple->addChild($this->registry->getKeyParser()->getKeyNode($parseContext));

        if ($this->tryConsumeFlowMappingValueIndicator($parseContext, $couple)) {
            if ($this->flowStructureIdentifier->isNextSignificantTokenOneOf(
                $parseContext,
                true,
                TokenType::FLOW_ENTRY,
                TokenType::FLOW_MAPPING_END,
            )) {
                $couple->addChild(new ValueNode());
            } else {
                $couple->addChild($this->registry->getValueParser()->parseValue($parseContext, IndentContext::createForFlow()));
            }
        }

        $this->anchorPostProcessor->postProcessKeyValueCouple($parseContext->anchorsRegistry, $couple);

        return $couple;
    }

    public function tryConsumeFlowMappingValueIndicator(ParseContext $parseContext, KeyValueCoupleNode $couple): bool
    {
        $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $couple);

        $token = $parseContext->tokens->current();
        if (TokenType::VALUE_INDICATOR !== $token?->type) {
            return false;
        }

        $couple->addChild(new ValueIndicatorNode($token));
        $parseContext->tokens->advance();

        $this->consumer->collectTypes($parseContext->tokens, [TokenType::WHITESPACE], $couple);

        return true;
    }
}
