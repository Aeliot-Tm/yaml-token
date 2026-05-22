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

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Flow\FlowHost;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Parser
{
    public function __construct(
        private MultilineContinuationHelper $multilineContinuationHelper,
        private ParserRegistry $parserRegistry,
    ) {
        $this->parserRegistry->setBlockParserBridge(
            function (Harvester $h, ValueNode $v): void {
                $this->parserRegistry->getNodePropertiesParser()->collectValueProperties($h, $v);
            },
            fn (Harvester $h, int $offset): bool => $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($h, $offset),
            fn (Harvester $h): bool => $this->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $this->isKeyValueCoupleStartAllowingNodeProperties($h),
            fn (Harvester $h, int $offset): bool => $this->isNodePropertiesFollowedByImplicitKeyFromOffset($h, $offset),
            fn (Harvester $h, bool $allowFlowSeparation = false): bool => $this->isScalarFollowedByValueIndicator($h, $allowFlowSeparation),
            fn (Harvester $h, int $indent): BlockMappingNode => $this->parserRegistry->getBlockMappingParser()->parseBlockMappingValue($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $this->parserRegistry->getBlockSequenceParser()->parseBlockSequenceValue($h, $indent),
            fn (Harvester $h, int $indent): BlockMappingNode => $this->parserRegistry->getCompactBlockMappingParser()->parseCompactBlockMapping($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $this->parserRegistry->getCompactBlockSequenceParser()->parseCompactBlockSequence($h, $indent),
            fn (Harvester $h): MergeInstructionNode => $this->parserRegistry
                ->getMergeInstructionParser()
                ->parseMergeInstructionAtCurrentPosition($h),
            fn (Harvester $h, int $parentIndentLen): ValueNode => $this->parserRegistry->getValueParser()->parseValue($h, $parentIndentLen),
        );

        $this->parserRegistry->setDocumentParserBridge(
            fn (Harvester $h): bool => $this->isBlockScalarStartAtDocumentRoot($h),
            fn (Harvester $h): bool => $this->isFlowMappingStart($h),
            fn (Harvester $h): bool => $this->isFlowSequenceStart($h),
            fn (Harvester $h): bool => $this->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $this->isNodePropertyAtDocumentRoot($h),
            fn (Harvester $h): bool => $this->isSequenceStart($h),
        );
    }

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    public function parseStream(TokenStream $tokens): StreamNode
    {
        $harvester = new Harvester(new TokenStreamProxy($tokens));
        $harvester->flowHost = $this->createFlowHost();
        $harvester->anchorsRegistry = new AnchorsRegistry();
        $harvester->state = new ParseState();
        $harvester->parseContext = new ParseContext($harvester->tokens, $harvester->anchorsRegistry, $harvester->state);

        return $this->parserRegistry->getStreamParser()->parseStream($harvester);
    }

    private function createFlowHost(): FlowHost
    {
        return new FlowHost(
            fn (Harvester $h): KeyNode => $this->parserRegistry->getKeyParser()->getKeyNode($h),
            fn (Harvester $h): bool => $this->isFlowMultilinePlainKeyStart($h),
            fn (Harvester $h): bool => $this->isScalarFollowedByValueIndicator($h, true),
            fn (Harvester $h): ValueNode => $this->parserRegistry->getValueParser()->parseValue($h, EspecialIndent::FLOW_COLLECTION_VALUE_PARENT->value),
            fn (Harvester $h): MergeInstructionNode => $this->parserRegistry
                ->getMergeInstructionParser()
                ->parseMergeInstructionAtCurrentPosition($h),
        );
    }

    private function isBlockScalarStartAtDocumentRoot(Harvester $harvester): bool
    {
        $offset = 0;
        while (true) {
            $token = $harvester->tokens->peek($offset);
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
     * True when a flow sequence or flow mapping at {@code $collectionStartPeekOffset} is closed and
     * the next non-layout token on the same line is {@code VALUE_INDICATOR} (block implicit key
     * whose key is a flow collection, e.g. {@code [flow]: block}).
     */
    private function isFlowCollectionFollowedByBlockValueIndicatorOnSameLine(Harvester $harvester, int $collectionStartPeekOffset): bool
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

    private function isFlowMappingStart(Harvester $harvester): bool
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
    private function isFlowMultilinePlainKeyStart(Harvester $harvester): bool
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

    private function isFlowSequenceStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::FLOW_SEQUENCE_START === $token?->type;
    }

    /**
     * YAML 1.2.2 §6.4 / §6.6: detects a line that is either entirely empty
     * (l-empty) or contains only a comment (l-comment), possibly with
     * leading whitespace. Such a line's leading INDENTATION token is part
     * of s-separate-in-line, not of block s-indent(n), and must not be
     * registered as the document's indent step nor validated against it.
     */
    private function isKeyValueCoupleStart(Harvester $harvester): bool
    {
        $contentPeekOffset = 0;
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $contentPeekOffset = 1;
            $token = $harvester->tokens->peek(1);
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
            return $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($harvester, $contentPeekOffset);
        }

        if (\in_array($token->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            $scalarLineOffset = TokenType::INDENTATION === $harvester->tokens->current()?->type ? 1 : 0;

            return $this->multilineContinuationHelper
                ->isImplicitYamlKeyOnContinuationLine($harvester->tokens, $scalarLineOffset);
        }

        return $this->isNodePropertyToken($token)
            && (
                $this->isNodePropertiesFollowedByImplicitYamlKeyOnSameLine($harvester)
                || $this->isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine($harvester)
            );
    }

    /**
     * True when the line begins with c-ns-properties (anchor/tag), then — still before
     * NEWLINE — a flow mapping or flow sequence whose closing bracket is followed on the
     * same line by {@code VALUE_INDICATOR} (block implicit key whose key is a tagged or
     * anchored flow collection, e.g. {@code &k [a]: b}).
     */
    private function isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine(Harvester $harvester): bool
    {
        $offset = 0;
        if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
            $offset = 1;
        }

        if (!$this->isNodePropertyToken($harvester->tokens->peek($offset))) {
            return false;
        }

        $sawProperty = false;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
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
            if (TokenType::ANCHOR === $peeked->type || TokenType::TAG === $peeked->type) {
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

        return $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($harvester, $offset);
    }

    /**
     * True when the line begins with c-ns-properties (anchor/tag), then — still before
     * NEWLINE — an implicit YAML key (scalar followed by VALUE_INDICATOR). Distinguishes
     * "&a: key: value" from a properties-only prefix line whose value continues below.
     */
    private function isNodePropertiesFollowedByImplicitYamlKeyOnSameLine(Harvester $harvester): bool
    {
        $offset = 0;
        if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
            $offset = 1;
        }

        if (!$this->isNodePropertyToken($harvester->tokens->peek($offset))) {
            return false;
        }

        return $this->isNodePropertiesFollowedByImplicitKeyFromOffset($harvester, $offset);
    }

    /**
     * Whether c-ns-properties at {@code $offset} are followed on the same line by an implicit YAML key
     * (scalar then VALUE_INDICATOR before NEWLINE).
     *
     * @param int $offset Peek offset to the first TAG or ANCHOR on the line
     */
    private function isNodePropertiesFollowedByImplicitKeyFromOffset(Harvester $harvester, int $offset): bool
    {
        while (true) {
            $token = $harvester->tokens->peek($offset);
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
            if (TokenType::ANCHOR === $token->type || TokenType::TAG === $token->type) {
                ++$offset;
                continue;
            }

            // Key node whose name is empty but carries c-ns-properties, e.g. "&a : value".
            if (TokenType::VALUE_INDICATOR === $token->type) {
                return true;
            }

            if (!$token->type->isScalar()) {
                return false;
            }

            $peekOffset = $offset + 1;
            while (true) {
                $peeked = $harvester->tokens->peek($peekOffset);
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

    private function isKeyValueCoupleStartAllowingNodeProperties(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        if ($this->isNodePropertyToken($token)) {
            return true;
        }

        return $this->isKeyValueCoupleStart($harvester);
    }

    /**
     * YAML 1.2.2 §8.2 rule [200] s-l+block-collection(n,c): before the block
     * sequence or block mapping body a node may carry c-ns-properties(n+1,c)
     * (tag and/or anchor, rule [96]) — optionally on their own line. At the
     * bare document root this is reached via rule [211] l-bare-document ::=
     * s-l+block-node(-1, block-in) (§9.1.3) → [196] → [198] → [200].
     *
     * Detects such a node-property prefix at the document root by peeking past
     * a possible leading INDENTATION token.
     */
    private function isNodePropertyAtDocumentRoot(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            return false;
        }
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return null !== $token && \in_array($token->type, [
            TokenType::ANCHOR,
            TokenType::TAG,
        ], true);
    }

    private function isNodePropertyToken(?Token $token): bool
    {
        if (null === $token) {
            return false;
        }

        return \in_array($token->type, [
            TokenType::ANCHOR,
            TokenType::TAG,
        ], true);
    }

    /**
     * Implicit YAML key detector (YAML 1.2.2 rule [154] ns-s-implicit-yaml-key):
     * current token is a scalar and the next significant token is ':' (VALUE_INDICATOR).
     * Used for flow-pair entries (§7.4.1 [139]) and compact block-mapping in a sequence (§8.2.1 [185]).
     *
     * When {@code $allowFlowSeparation} is true (flow collections only), COMMENT and NEWLINE tokens may
     * appear between the scalar and ':' (YAML test suite K3WX / flow line breaks).
     */
    private function isScalarFollowedByValueIndicator(Harvester $harvester, bool $allowFlowSeparation = false): bool
    {
        $token = $harvester->tokens->current();
        if (null === $token || !$token->type->isScalar()) {
            return false;
        }

        $offset = 1;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
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

    private function isSequenceStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
    }
}
