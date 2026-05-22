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
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class BlockStructureIdentifier
{
    public function __construct(
        private FlowStructureIdentifier $flowStructureIdentifier,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodePropertyIdentifier $nodePropertyIdentifier,
    ) {
    }

    public function isBlockScalarStartAtDocumentRoot(ParseContext $parseContext): bool
    {
        $offset = 0;
        while (true) {
            $token = $parseContext->tokens->peek($offset);
            if (null === $token) {
                return false;
            }
            if (TokenType::INDENTATION === $token->type || TokenType::WHITESPACE === $token->type) {
                ++$offset;
                continue;
            }

            return \in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true);
        }
    }

    /**
     * YAML 1.2.2 §6.4 / §6.6: detects a line that is either entirely empty
     * (l-empty) or contains only a comment (l-comment), possibly with
     * leading whitespace. Such a line's leading INDENTATION token is part
     * of s-separate-in-line, not of block s-indent(n), and must not be
     * registered as the document's indent step nor validated against it.
     */
    public function isKeyValueCoupleStart(ParseContext $parseContext): bool
    {
        $contentPeekOffset = 0;
        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $contentPeekOffset = 1;
            $token = $parseContext->tokens->peek(1);
        }

        if (
            TokenType::EXPLICIT_KEY_INDICATOR === $token->type
            || TokenType::ALIAS === $token->type
            || TokenType::VALUE_INDICATOR === $token->type
            || $token->type->isMergeIndicator()
        ) {
            return true;
        }

        if (\in_array($token?->type, [TokenType::FLOW_SEQUENCE_START, TokenType::FLOW_MAPPING_START], true)) {
            return $this->flowStructureIdentifier->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($parseContext, $contentPeekOffset);
        }

        if (\in_array($token->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            $scalarLineOffset = TokenType::INDENTATION === $parseContext->tokens->current()?->type ? 1 : 0;

            return $this->multilineContinuationHelper
                ->isImplicitYamlKeyOnContinuationLine($parseContext->tokens, $scalarLineOffset);
        }

        return $this->nodePropertyIdentifier->isNodePropertyToken($token)
            && (
                $this->nodePropertyIdentifier->isNodePropertiesFollowedByImplicitYamlKeyOnSameLine($parseContext)
                || $this->nodePropertyIdentifier->isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine($parseContext)
            );
    }

    public function isKeyValueCoupleStartAllowingNodeProperties(ParseContext $parseContext): bool
    {
        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $parseContext->tokens->peek(1);
        }

        if ($this->nodePropertyIdentifier->isNodePropertyToken($token)) {
            return true;
        }

        return $this->isKeyValueCoupleStart($parseContext);
    }

    public function isSequenceStart(ParseContext $parseContext): bool
    {
        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $parseContext->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
    }
}
