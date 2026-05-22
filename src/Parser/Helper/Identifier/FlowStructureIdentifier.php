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

namespace Aeliot\YamlToken\Parser\Helper\Identifier;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Parser\Dto\Harvester;

final readonly class FlowStructureIdentifier
{
    /**
     * True when a flow sequence or flow mapping at {@code $collectionStartPeekOffset} is closed and
     * the next non-layout token on the same line is {@code VALUE_INDICATOR} (block implicit key
     * whose key is a flow collection, e.g. {@code [flow]: block}).
     */
    public function isFlowCollectionFollowedByBlockValueIndicatorOnSameLine(Harvester $harvester, int $collectionStartPeekOffset): bool
    {
        $open = $harvester->tokens->peek($collectionStartPeekOffset);
        if (!\in_array($open?->type, [TokenType::FLOW_SEQUENCE_START, TokenType::FLOW_MAPPING_START], true)) {
            return false;
        }

        $depth = 0;
        $i = $collectionStartPeekOffset;
        while (true) {
            $tok = $harvester->tokens->peek($i);
            if (null === $tok) {
                return false;
            }

            if (TokenType::FLOW_SEQUENCE_START === $tok->type || TokenType::FLOW_MAPPING_START === $tok->type) {
                ++$depth;
            } elseif (TokenType::FLOW_SEQUENCE_END === $tok->type || TokenType::FLOW_MAPPING_END === $tok->type) {
                --$depth;
                if ($depth < 0) {
                    return false;
                }
                if (0 === $depth) {
                    break;
                }
            }

            ++$i;
        }

        ++$i;
        while (true) {
            $tok = $harvester->tokens->peek($i);
            if (null === $tok) {
                return false;
            }
            if (TokenType::WHITESPACE === $tok->type || TokenType::COMMENT === $tok->type) {
                ++$i;
                continue;
            }
            if (TokenType::NEWLINE === $tok->type) {
                return false;
            }

            return TokenType::VALUE_INDICATOR === $tok->type;
        }
    }

    public function isFlowMappingStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::FLOW_MAPPING_START === $token?->type;
    }

    /**
     * In flow context, checks if the current PLAIN_SCALAR is the start of a multiline
     * implicit key: PLAIN_SCALAR (NEWLINE WS* PLAIN_SCALAR)+ WS* VALUE_INDICATOR.
     */
    public function isFlowMultilinePlainKeyStart(Harvester $harvester): bool
    {
        if (TokenType::PLAIN_SCALAR !== $harvester->tokens->current()?->type) {
            return false;
        }

        $offset = 1;
        $hasContinuation = false;

        while (true) {
            while (TokenType::WHITESPACE === $harvester->tokens->peek($offset)?->type) {
                ++$offset;
            }

            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }

            if (TokenType::VALUE_INDICATOR === $peeked->type) {
                return $hasContinuation;
            }

            if (TokenType::NEWLINE !== $peeked->type) {
                return false;
            }
            ++$offset;

            while (TokenType::WHITESPACE === $harvester->tokens->peek($offset)?->type) {
                ++$offset;
            }

            if (TokenType::PLAIN_SCALAR !== $harvester->tokens->peek($offset)?->type) {
                return false;
            }
            ++$offset;
            $hasContinuation = true;
        }
    }

    public function isFlowSequenceStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::FLOW_SEQUENCE_START === $token?->type;
    }
}
