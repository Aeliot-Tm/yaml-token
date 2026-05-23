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
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class KeyIdentifier
{
    /**
     * Implicit YAML key detector (YAML 1.2.2 rule [154] ns-s-implicit-yaml-key):
     * current token is a scalar and the next significant token is ':' (VALUE_INDICATOR).
     * Used for flow-pair entries (§7.4.1 [139]) and compact block-mapping in a sequence (§8.2.1 [185]).
     *
     * When {@code $allowFlowSeparation} is true (flow collections only), COMMENT and NEWLINE tokens may
     * appear between the scalar and ':' (YAML test suite K3WX / flow line breaks).
     */
    public function isScalarFollowedByValueIndicator(ParseContext $parseContext, bool $allowFlowSeparation = false): bool
    {
        $token = $parseContext->tokens->current();
        if (null === $token || !$token->type->isScalar()) {
            return false;
        }

        $offset = 1;
        while (true) {
            $peeked = $parseContext->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }
            if (TokenType::WHITESPACE === $peeked->type) {
                ++$offset;
                continue;
            }
            if ($allowFlowSeparation && \in_array($peeked->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                ++$offset;
                continue;
            }

            return TokenType::VALUE_INDICATOR === $peeked->type;
        }
    }
}
