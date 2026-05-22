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

    public function parse(ParseContext $parseContext): KeyValueCoupleNode
    {
        $couple = new KeyValueCoupleNode();
        $couple->addChild($this->registry->getFlowHost()->getFlowEntryKeyNode($parseContext));

        if ($this->tryConsumeFlowMappingValueIndicator($parseContext, $couple)) {
            if ($this->isAtFlowMappingEntryBoundary($parseContext)) {
                $couple->addChild(new ValueNode());
            } else {
                $couple->addChild($this->registry->getFlowHost()->parseFlowContextValue($parseContext));
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

    private function isAtFlowMappingEntryBoundary(ParseContext $parseContext): bool
    {
        $offset = 0;
        while (true) {
            $peeked = $parseContext->tokens->peek($offset);
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
