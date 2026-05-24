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
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\SubParser\Consumer;

final readonly class FlowValueIndicatorConsumer
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    public function tryConsume(ParseContext $parseContext, KeyValueCoupleNode $couple): bool
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
