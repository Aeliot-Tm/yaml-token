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
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class NodePropertyIdentifier
{
    public function __construct(
        private FlowStructureIdentifier $flowStructureIdentifier,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    /**
     * YAML 1.2.2 §8.2 rule [200] s-l+block-collection(n,c): before the block
     * sequence or block mapping body a node may carry c-ns-properties(n+1,c)
     * (tag and/or anchor, rule [96]) — optionally on their own line. At the
     * bare document root this is reached via rule [211] l-bare-document ::=
     * s-l+block-node(-1, block-in) (§9.1.3) → [196] → [198] → [200].
     *
     * Detects such a node-property prefix at the document root by peeking past
     * a possible leading INDENT token.
     */
    public function isNodePropertyAtDocumentRoot(ParseContext $parseContext): bool
    {
        $token = $parseContext->tokens->peek($this->resolveLineContentPeekOffset($parseContext->tokens));

        return null !== $token && \in_array($token->type, [
            TokenType::ANCHOR_PROPERTY,
            TokenType::TAG,
        ], true);
    }

    public function isNodePropertyToken(?Token $token): bool
    {
        if (null === $token) {
            return false;
        }

        return \in_array($token->type, [
            TokenType::ANCHOR_PROPERTY,
            TokenType::TAG,
        ], true);
    }

    /**
     * True when c-ns-properties at {@code $offset} are followed on the same line by a flow
     * mapping or flow sequence whose closing bracket is followed by {@code VALUE_INDICATOR}.
     *
     * @param int $offset Peek offset to the first TAG or ANCHOR_PROPERTY on the line
     */
    public function isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyFromOffset(ParseContext $parseContext, int $offset): bool
    {
        if (!$this->isNodePropertyToken($parseContext->tokens->peek($offset))) {
            return false;
        }

        $sawProperty = false;
        while (true) {
            $peeked = $parseContext->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }
            if (TokenType::NEWLINE === $peeked->type) {
                return false;
            }
            if (TokenType::WHITESPACE === $peeked->type || TokenType::COMMENT === $peeked->type) {
                ++$offset;
                continue;
            }
            if (TokenType::ANCHOR_PROPERTY === $peeked->type || TokenType::TAG === $peeked->type) {
                $sawProperty = true;
                ++$offset;
                continue;
            }

            break;
        }

        if (!$sawProperty) {
            return false;
        }

        if (!\in_array($peeked->type, [TokenType::FLOW_MAPPING_START, TokenType::FLOW_SEQUENCE_START], true)) {
            return false;
        }

        return $this->flowStructureIdentifier->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($parseContext, $offset);
    }

    /**
     * True when the line begins with c-ns-properties (anchor/tag), then — still before
     * NEWLINE — a flow mapping or flow sequence whose closing bracket is followed on the
     * same line by {@code VALUE_INDICATOR} (block implicit key whose key is a tagged or
     * anchored flow collection, e.g. {@code &k [a]: b}).
     */
    public function isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine(ParseContext $parseContext): bool
    {
        return $this->isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyFromOffset(
            $parseContext,
            $this->resolveLineContentPeekOffset($parseContext->tokens),
        );
    }

    /**
     * Whether c-ns-properties at {@code $offset} are followed on the same line by an implicit YAML key
     * (scalar then VALUE_INDICATOR before NEWLINE).
     *
     * @param int $offset Peek offset to the first TAG or ANCHOR_PROPERTY on the line
     */
    public function isNodePropertiesFollowedByImplicitKeyFromOffset(ParseContext $parseContext, int $offset): bool
    {
        while (true) {
            $token = $parseContext->tokens->peek($offset);
            if (null === $token) {
                return false;
            }
            if (TokenType::NEWLINE === $token->type) {
                return false;
            }
            if (TokenType::WHITESPACE === $token->type || TokenType::COMMENT === $token->type) {
                ++$offset;
                continue;
            }
            if (TokenType::ANCHOR_PROPERTY === $token->type || TokenType::TAG === $token->type) {
                ++$offset;
                continue;
            }

            if (TokenType::VALUE_INDICATOR === $token->type) {
                return true;
            }

            if (!$token->type->isScalar()) {
                return false;
            }

            $peekOffset = $offset + 1;
            while (true) {
                $peeked = $parseContext->tokens->peek($peekOffset);
                if (null === $peeked) {
                    return false;
                }
                if (TokenType::NEWLINE === $peeked->type) {
                    return false;
                }
                if (TokenType::WHITESPACE !== $peeked->type) {
                    return TokenType::VALUE_INDICATOR === $peeked->type;
                }
                ++$peekOffset;
            }
        }
    }

    /**
     * True when the line begins with c-ns-properties (anchor/tag), then — still before
     * NEWLINE — an implicit YAML key (scalar followed by VALUE_INDICATOR). Distinguishes
     * "&a: key: value" from a properties-only prefix line whose value continues below.
     */
    public function isNodePropertiesFollowedByImplicitYamlKeyOnSameLine(ParseContext $parseContext): bool
    {
        $offset = $this->resolveLineContentPeekOffset($parseContext->tokens);
        if (!$this->isNodePropertyToken($parseContext->tokens->peek($offset))) {
            return false;
        }

        return $this->isNodePropertiesFollowedByImplicitKeyFromOffset($parseContext, $offset);
    }

    private function resolveLineContentPeekOffset(TokenStreamInterface $tokens): int
    {
        $offset = 0;
        if (TokenType::INDENT === $tokens->current()?->type) {
            $offset = 1;
        }

        return $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $offset);
    }
}
