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
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class FlowMappingPairParser implements SubParserInterface
{
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private Consumer $consumer,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $harvester): KeyValueCoupleNode
    {
        $couple = new KeyValueCoupleNode();
        $couple->addChild($this->registry->getFlowHost()->getFlowEntryKeyNode($harvester));

        if ($this->tryConsumeFlowMappingValueIndicator($harvester, $couple)) {
            if ($this->isAtFlowMappingEntryBoundary($harvester)) {
                $couple->addChild(new ValueNode());
            } else {
                $couple->addChild($this->registry->getFlowHost()->parseFlowContextValue($harvester));
            }
        }

        $this->anchorPostProcessor->postProcessKeyValueCouple($harvester->anchorsRegistry, $couple);

        return $couple;
    }

    public function tryConsumeFlowMappingValueIndicator(ParseContext $harvester, KeyValueCoupleNode $couple): bool
    {
        $this->consumer->collectSpaceCommentEnds($harvester->tokens, $couple);

        $token = $harvester->tokens->current();
        if (TokenType::VALUE_INDICATOR !== $token?->type) {
            return false;
        }

        $couple->addChild(new ValueIndicatorNode($token));
        $harvester->tokens->advance();

        $this->consumer->collectTypes($harvester->tokens, [TokenType::WHITESPACE], $couple);

        return true;
    }

    private function isAtFlowMappingEntryBoundary(ParseContext $harvester): bool
    {
        $offset = 0;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return true;
            }
            if (
                TokenType::WHITESPACE === $peeked->type
                || TokenType::COMMENT === $peeked->type
                || TokenType::NEWLINE === $peeked->type
            ) {
                ++$offset;

                continue;
            }

            return \in_array($peeked->type, [TokenType::FLOW_ENTRY, TokenType::FLOW_MAPPING_END], true);
        }
    }
}
