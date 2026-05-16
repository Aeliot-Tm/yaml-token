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

namespace Aeliot\YamlToken\Lexer;

use Aeliot\YamlToken\Enum\BlockScalarChomping;
use Aeliot\YamlToken\Enum\FlowMapPhase;
use Aeliot\YamlToken\Enum\FlowSequencePhase;
use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Dto\Cursor;
use Aeliot\YamlToken\Lexer\Dto\FlowMapFrame;
use Aeliot\YamlToken\Lexer\Dto\FlowSequenceFrame;
use Aeliot\YamlToken\Lexer\Dto\Harvester;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Lexer
{
    /**
     * @var list<string>
     */
    private const CHARS_ANCHOR_OR_TAG_FORBIDDEN = [...self::CHARS_WHITESPACE, '[', ']', '{', '}', ',', '#', "\0"];

    /**
     * @var list<string>
     */
    private const CHARS_BLOCK_SCALAR_START = [...self::CHARS_WHITESPACE, '+', '-', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    /**
     * YAML 1.2.2 §6.3 / rule [23] c-flow-indicator. Used to disambiguate plain scalars in flow context
     * where rule [129] ns-plain-safe-in forbids these chars right after a ':'.
     *
     * @var list<string>
     */
    private const CHARS_FLOW_INDICATORS = [',', '[', ']', '{', '}'];

    /**
     * @var list<string>
     */
    private const CHARS_HORIZONTAL_WHITESPACE = [' ', "\t"];

    /**
     * @var list<string>
     */
    private const CHARS_LINE_BREAK = ["\n", "\r"];

    /**
     * @var list<string>
     */
    private const CHARS_WHITESPACE = [...self::CHARS_HORIZONTAL_WHITESPACE, ...self::CHARS_LINE_BREAK];

    /**
     * @var array<string, TokenType>
     */
    private const FLOW_INDICATOR_TOKEN_TYPES = [
        '[' => TokenType::FLOW_SEQUENCE_START,
        ']' => TokenType::FLOW_SEQUENCE_END,
        '{' => TokenType::FLOW_MAPPING_START,
        '}' => TokenType::FLOW_MAPPING_END,
        ',' => TokenType::FLOW_ENTRY,
    ];

    /**
     * Minimum indent delta (spaces) on a continuation line before a leading {@code -} is treated as a nested
     * block sequence entry rather than plain scalar content (YAML Test Suite AB8U / go-yaml lenient disambiguation).
     */
    private const MIN_NESTED_BLOCK_COLLECTION_INDENT_DELTA = 2;

    public function tokenize(string $input): TokenStream
    {
        $harvester = new Harvester($input);

        while ($harvester->cursor->position < $harvester->length || null !== $harvester->cursor->pendingBlockScalarBody) {
            if ($harvester->cursor->position >= $harvester->length && $harvester->cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($harvester->cursor);

                continue;
            }

            if (null !== $harvester->cursor->pendingBlockScalarBody) {
                $this->readBlockScalarBodyToken($harvester);

                continue;
            }

            if ($harvester->cursor->inExplicitIndentBlockScalarBody) {
                $type = $harvester->cursor->blockScalarBodyTokenType ?? TokenType::LITERAL_BLOCK_SCALAR;
                $harvester->cursor->blockScalarBodyTokenType = null;
                $body = $this->readBlockScalarBodyAndApplyChomping($harvester);
                $harvester->stream->addToken(new Token($type, $body, $harvester->cursor->line, $harvester->cursor->column));
                $harvester->cursor->inExplicitIndentBlockScalarBody = false;

                continue;
            }

            if ($harvester->cursor->position >= $harvester->length) {
                break;
            }

            if ($this->shouldTokenizeYamlDirectiveAsParts($harvester)) {
                $this->tokenizeYamlDirectiveLine($harvester);

                continue;
            }

            if ($this->shouldTokenizeTagDirectiveAsParts($harvester)) {
                $this->tokenizeTagDirectiveLine($harvester);

                continue;
            }

            // TAG (!...) — see {@see tokenizeExplicitTag} in {@see tokenize}
            if ($harvester->cursor->position < $harvester->length && '!' === $harvester->input[$harvester->cursor->position]) {
                if ($harvester->cursor->suppressExplicitTagForBang) {
                    $this->readToken($harvester);
                } else {
                    $this->tokenizeExplicitTag($harvester);
                }

                continue;
            }

            $this->readToken($harvester);
        }

        return $harvester->stream;
    }

    private function advance(Harvester $harvester): void
    {
        if ($harvester->cursor->position >= $harvester->length) {
            return;
        }
        if ("\n" === $harvester->input[$harvester->cursor->position]) {
            ++$harvester->cursor->line;
            $harvester->cursor->column = 1;
            ++$harvester->cursor->position;

            return;
        }
        $width = $this->utf8CodePointByteWidth($harvester, $harvester->cursor->position);
        $harvester->cursor->position += $width;
        ++$harvester->cursor->column;
    }

    private function applyBlockPlainContinuationIndentRules(Harvester $harvester, string $indent): void
    {
        if (
            !$harvester->cursor->awaitingBlockPlainContinuation
            || null === $harvester->cursor->plainScalarContinuationBaseIndent
        ) {
            return;
        }
        $n = \strlen($indent);
        if ($n > $harvester->cursor->plainScalarContinuationBaseIndent) {
            $harvester->cursor->suppressAnchorAlias = true;
            $harvester->cursor->suppressExplicitTagForBang = true;
        } else {
            $this->resetBlockMappingPlainState($harvester->cursor);
        }
    }

    private function blockScalarLineHasNonSpaceTabContent(string $line): bool
    {
        return 1 === preg_match('/[^ \t]/', $line);
    }

    private function codePointFragmentAt(Harvester $harvester, int $position): string
    {
        if ($position >= $harvester->length) {
            return '';
        }
        if ("\n" === $harvester->input[$position]) {
            return "\n";
        }
        $width = $this->utf8CodePointByteWidth($harvester, $position);

        return substr($harvester->input, $position, $width);
    }

    /**
     * Strip chomping (YAML 1.0 / 1.2): exclude the final line break after the last non-empty line and any
     * trailing empty lines. Bytes from the first such line break onward are detached and re-tokenized
     * (e.g. {@see TokenType::NEWLINE}, {@see TokenType::INDENTATION}).
     */
    private function computeBlockScalarStripSuffixLength(string $result): int
    {
        if ('' === $result) {
            return 0;
        }

        $len = \strlen($result);
        $offset = 0;
        $lastNonEmptyContentEnd = null;

        while ($offset < $len) {
            $nl = $this->findNextLineBreakInString($result, $offset, $len);
            if (null === $nl) {
                $lineContent = substr($result, $offset);
                if ($this->blockScalarLineHasNonSpaceTabContent($lineContent)) {
                    $lastNonEmptyContentEnd = $len;
                }
                break;
            }

            $lineContent = substr($result, $offset, $nl['start'] - $offset);
            if ($this->blockScalarLineHasNonSpaceTabContent($lineContent)) {
                $lastNonEmptyContentEnd = $nl['start'];
            }
            $offset = $nl['start'] + $nl['len'];
        }

        if (null === $lastNonEmptyContentEnd) {
            return 0;
        }

        return $len - $lastNonEmptyContentEnd;
    }

    private function consumeCodePoint(Harvester $harvester): string
    {
        $fragment = $this->codePointFragmentAt($harvester, $harvester->cursor->position);
        $this->advance($harvester);

        return $fragment;
    }

    /**
     * @return array{start: int, len: int}|null
     */
    private function findNextLineBreakInString(string $input, int $offset, int $length): ?array
    {
        for ($i = $offset; $i < $length; ++$i) {
            if ("\n" === $input[$i]) {
                return ['start' => $i, 'len' => 1];
            }
            if ("\r" === $input[$i]) {
                if ($i + 1 < $length && "\n" === $input[$i + 1]) {
                    return ['start' => $i, 'len' => 2];
                }

                return ['start' => $i, 'len' => 1];
            }
        }

        return null;
    }

    private function getLastSignificantToken(Harvester $harvester): ?Token
    {
        $tokens = $harvester->stream->getTokens();
        for ($i = \count($tokens) - 1; $i >= 0; --$i) {
            $token = $tokens[$i];
            if (TokenType::WHITESPACE !== $token->type) {
                return $token;
            }
        }

        return null;
    }

    private function getNextChar(Harvester $harvester): ?string
    {
        $next = $harvester->cursor->position + 1;
        if ($next >= $harvester->length) {
            return null;
        }

        return $harvester->input[$next];
    }

    private function isAnchorChar(string $char): bool
    {
        return !\in_array($char, self::CHARS_ANCHOR_OR_TAG_FORBIDDEN, true);
    }

    private function isBlockScalarStart(Harvester $harvester): bool
    {
        $nextChar = $this->getNextChar($harvester);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_BLOCK_SCALAR_START, true);
    }

    /**
     * ':' introduces a mapping value when the byte at $colonPosition is ':' and the following byte, if any,
     * is end of input, a whitespace, or — only inside a flow collection — a c-flow-indicator
     * (',', '[', ']', '{', '}').
     *
     * Rationale: per YAML 1.2.2 §7.3.3 rule [130] ns-plain-char(c), a ':' inside a plain scalar may be
     * followed by any ns-plain-safe(c) char. In block context (rule [128] ns-plain-safe-out = ns-char),
     * that includes every non-whitespace char, so e.g. ":{", ":[", ':"', ":'", ":#" must stay part of
     * the scalar. In flow context (rule [129] ns-plain-safe-in = ns-char - c-flow-indicator), the
     * c-flow-indicator chars terminate the scalar and ':' becomes a value indicator. Additionally,
     * when {@see Cursor::$flowCollectionStack} top map is in phase {@see FlowMapPhase::Colon} (K3WX)
     * or top sequence is in phase {@see FlowSequencePhase::Colon} (rule [153] JSON-style key),
     * ':' is a value indicator even if the value is adjacent (e.g. {@code :bar}).
     */
    private function isColonMappingValueIndicator(Harvester $harvester, int $colonPosition): bool
    {
        if ($colonPosition >= $harvester->length || ':' !== $harvester->input[$colonPosition]) {
            return false;
        }
        if ($this->isFlowExpectsValueSeparatorColon($harvester->cursor)) {
            return true;
        }
        $afterColon = $colonPosition + 1;
        if ($afterColon >= $harvester->length) {
            return true;
        }
        $next = $harvester->input[$afterColon];
        if (\in_array($next, self::CHARS_WHITESPACE, true)) {
            return true;
        }

        return $harvester->cursor->flowDepth > 0
            && \in_array($next, self::CHARS_FLOW_INDICATORS, true);
    }

    /**
     * In YAML, "#" starts a comment only when separated from other tokens by whitespace.
     */
    private function isCommentStart(Harvester $harvester): bool
    {
        if ($harvester->cursor->position >= $harvester->length) {
            return false;
        }
        if ('#' !== $harvester->input[$harvester->cursor->position]) {
            return false;
        }
        if (0 === $harvester->cursor->position) {
            return true;
        }

        return \in_array($harvester->input[$harvester->cursor->position - 1], self::CHARS_WHITESPACE, true);
    }

    private function isFlowExpectsValueSeparatorColon(Cursor $cursor): bool
    {
        $top = end($cursor->flowCollectionStack) ?: null;
        if ($top instanceof FlowMapFrame && FlowMapPhase::Colon === $top->phase) {
            return true;
        }

        return $top instanceof FlowSequenceFrame && FlowSequencePhase::Colon === $top->phase;
    }

    private function isMappingKey(Harvester $harvester): bool
    {
        $nextChar = $this->getNextChar($harvester);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_WHITESPACE, true);
    }

    private function isMappingValue(Harvester $harvester): bool
    {
        return $this->isColonMappingValueIndicator($harvester, $harvester->cursor->position);
    }

    /**
     * Plain sequence «<<» for the YAML 1.1 merge key: only when followed by optional horizontal whitespace and ':' as a value indicator.
     */
    private function isMergeKeyPlainSequence(Harvester $harvester): bool
    {
        if ($harvester->cursor->position + 2 > $harvester->length) {
            return false;
        }
        if ('<' !== $harvester->input[$harvester->cursor->position] || '<' !== $harvester->input[$harvester->cursor->position + 1]) {
            return false;
        }
        $pos = $harvester->cursor->position + 2;
        while ($pos < $harvester->length && \in_array($harvester->input[$pos], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            ++$pos;
        }
        if ($pos >= $harvester->length) {
            return false;
        }

        return $this->isColonMappingValueIndicator($harvester, $pos);
    }

    /**
     * True when {@code -} on the current line continues a block plain scalar (AB8U-style wrong indent),
     * not a structural block sequence entry.
     */
    private function isDashBlockPlainContinuationLine(Harvester $harvester): bool
    {
        if (0 !== $harvester->cursor->flowDepth) {
            return false;
        }
        if (
            !$harvester->cursor->awaitingBlockPlainContinuation
            || null === $harvester->cursor->plainScalarContinuationBaseIndent
        ) {
            return false;
        }
        $indentDelta = $harvester->cursor->currentIndent - $harvester->cursor->plainScalarContinuationBaseIndent;
        if ($indentDelta <= 0) {
            return false;
        }

        return $indentDelta < self::MIN_NESTED_BLOCK_COLLECTION_INDENT_DELTA;
    }

    private function isSequenceEntry(Harvester $harvester): bool
    {
        $nextChar = $this->getNextChar($harvester);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_WHITESPACE, true);
    }

    private function isTagChar(string $char): bool
    {
        return !\in_array($char, self::CHARS_ANCHOR_OR_TAG_FORBIDDEN, true);
    }

    /**
     * After "!", comma + four ASCII digits begin the registration date in global tag shorthand (YAML 1.0 style).
     */
    private function isTagCommaStartsRegistrationYear(Harvester $harvester, int $commaPosition): bool
    {
        if ($commaPosition + 5 > $harvester->length) {
            return false;
        }
        for ($i = 1; $i <= 4; ++$i) {
            if (!ctype_digit($harvester->input[$commaPosition + $i])) {
                return false;
            }
        }

        return true;
    }

    private function isTagHandleNameChar(string $char): bool
    {
        if ('-' === $char) {
            return true;
        }
        if ($char >= '0' && $char <= '9') {
            return true;
        }
        if ($char >= 'A' && $char <= 'Z') {
            return true;
        }
        if ($char >= 'a' && $char <= 'z') {
            return true;
        }

        return false;
    }

    private function match(Harvester $harvester, string $str): bool
    {
        $len = \strlen($str);
        if ($harvester->cursor->position + $len > $harvester->length) {
            return false;
        }
        if (substr($harvester->input, $harvester->cursor->position, $len) !== $str) {
            return false;
        }
        for ($i = 0; $i < $len; ++$i) {
            $this->advance($harvester);
        }

        return true;
    }

    /**
     * Lines starting at column 1 without leading spaces have logical indent 0; sibling mapping keys at the
     * root close multiline-plain continuation when indentation does not exceed the key line indent.
     */
    private function maybeEndBlockPlainContinuationAtUnindentedLineStart(Harvester $harvester): void
    {
        if (1 !== $harvester->cursor->column) {
            return;
        }
        $char = $harvester->input[$harvester->cursor->position];
        if (
            \in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)
            || !$harvester->cursor->awaitingBlockPlainContinuation
            || (
                null === $harvester->cursor->plainScalarContinuationBaseIndent
                && null === $harvester->cursor->blockMappingKeyIndent
            )
        ) {
            return;
        }
        $this->resetBlockMappingPlainState($harvester->cursor);
    }

    private function onEmittedNewlineAfterBlockPlainScalar(Harvester $harvester, ?Token $significantBeforeBreak): void
    {
        $harvester->cursor->suppressAnchorAlias = false;
        $harvester->cursor->suppressExplicitTagForBang = false;
        if (
            null !== $significantBeforeBreak
            && TokenType::PLAIN_SCALAR === $significantBeforeBreak->type
            && (
                null !== $harvester->cursor->blockMappingKeyIndent
                || null !== $harvester->cursor->plainScalarContinuationBaseIndent
            )
        ) {
            $harvester->cursor->awaitingBlockPlainContinuation = true;
        }
    }

    private function onFlowCollectionClosed(Harvester $harvester): void
    {
        $stack = &$harvester->cursor->flowCollectionStack;
        if ([] === $stack) {
            return;
        }
        array_pop($stack);
        if ([] === $stack) {
            return;
        }
        $i = \count($stack) - 1;
        $parent = $stack[$i];
        if ($parent instanceof FlowSequenceFrame) {
            if (FlowSequencePhase::Entry === $parent->phase) {
                $parent->phase = FlowSequencePhase::Colon;
            }

            return;
        }
        if (!$parent instanceof FlowMapFrame) {
            return;
        }
        if (FlowMapPhase::Key === $parent->phase) {
            $parent->phase = FlowMapPhase::Colon;
        } elseif (FlowMapPhase::Value === $parent->phase) {
            $parent->phase = FlowMapPhase::Sep;
        }
    }

    private function onFlowEntryCommaEmitted(Harvester $harvester): void
    {
        $stack = &$harvester->cursor->flowCollectionStack;
        if ([] === $stack) {
            return;
        }
        $i = \count($stack) - 1;
        $top = $stack[$i];
        if ($top instanceof FlowSequenceFrame) {
            $top->phase = FlowSequencePhase::Entry;

            return;
        }
        if (!$top instanceof FlowMapFrame || FlowMapPhase::Sep !== $top->phase) {
            return;
        }
        $top->phase = FlowMapPhase::Key;
    }

    private function onFlowMapScalarLikeNodeEmitted(Harvester $harvester, TokenType $type): void
    {
        if (!\in_array($type, [
            TokenType::ALIAS,
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::MERGE_INDICATOR,
            TokenType::PLAIN_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
        ], true)) {
            return;
        }
        $stack = &$harvester->cursor->flowCollectionStack;
        if ([] === $stack) {
            return;
        }
        $i = \count($stack) - 1;
        $top = $stack[$i];
        if ($top instanceof FlowSequenceFrame) {
            if (
                FlowSequencePhase::Entry === $top->phase
                && \in_array($type, [TokenType::DOUBLE_QUOTED_SCALAR, TokenType::SINGLE_QUOTED_SCALAR], true)
            ) {
                $top->phase = FlowSequencePhase::Colon;
            }

            return;
        }
        if (!$top instanceof FlowMapFrame) {
            return;
        }
        if (FlowMapPhase::Key === $top->phase) {
            $top->phase = FlowMapPhase::Colon;
        } elseif (FlowMapPhase::Value === $top->phase) {
            $top->phase = FlowMapPhase::Sep;
        }
    }

    private function onFlowMappingValueIndicatorEmitted(Harvester $harvester): void
    {
        $stack = &$harvester->cursor->flowCollectionStack;
        if ([] === $stack) {
            return;
        }
        $i = \count($stack) - 1;
        $top = $stack[$i];
        if ($top instanceof FlowSequenceFrame) {
            if (FlowSequencePhase::Colon === $top->phase) {
                $top->phase = FlowSequencePhase::Value;
            }

            return;
        }
        if (!$top instanceof FlowMapFrame || FlowMapPhase::Colon !== $top->phase) {
            return;
        }
        $top->phase = FlowMapPhase::Value;
    }

    private function promoteBlockScalarBodyFromHeader(Cursor $cursor): void
    {
        if (null === $cursor->blockScalarChomping) {
            $cursor->blockScalarChomping = BlockScalarChomping::Clip;
        }
        $cursor->inBlockScalarHeaderLine = false;
        $parentIndent = $cursor->blockScalarValueParentIndent ?? 0;
        $cursor->blockScalarValueParentIndent = null;
        if ($cursor->blockScalarExplicitIndentIndicator) {
            $cursor->inExplicitIndentBlockScalarBody = true;
            $cursor->blockScalarExplicitIndentIndicator = false;
            $additional = $cursor->blockScalarAdditionalIndentFromIndicator ?? 0;
            $cursor->blockScalarAdditionalIndentFromIndicator = null;
            $cursor->blockScalarExplicitContentMinIndent = $parentIndent + $additional;
        } else {
            $cursor->blockScalarAdditionalIndentFromIndicator = null;
            $cursor->pendingBlockScalarBody = $cursor->blockScalarBodyTokenType;
            $cursor->blockScalarBodyTokenType = null;
        }
    }

    private function readAnchorOrAlias(Harvester $harvester): string
    {
        $result = '';
        $this->advance($harvester);
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if ($this->isAnchorChar($char)) {
                $result .= $this->consumeCodePoint($harvester);
            } else {
                break;
            }
        }

        return $result;
    }

    private function readBlockScalarBody(Harvester $harvester): string
    {
        $result = '';
        $explicitFloor = $harvester->cursor->blockScalarExplicitContentMinIndent;
        if (null !== $explicitFloor) {
            $harvester->cursor->blockScalarExplicitContentMinIndent = null;
        }
        $minIndent = null;

        while ($harvester->cursor->position < $harvester->length) {
            if (\in_array($harvester->input[$harvester->cursor->position], self::CHARS_LINE_BREAK, true)) {
                $result .= $this->consumeCodePoint($harvester);
                if ($harvester->cursor->position > 0 && "\r" === $harvester->input[$harvester->cursor->position - 1] && $harvester->cursor->position < $harvester->length && "\n" === $harvester->input[$harvester->cursor->position]) {
                    $result .= $this->consumeCodePoint($harvester);
                }

                continue;
            }

            $indentStart = $harvester->cursor->position;
            $lineIndent = 0;
            // YAML structural indent is space-only; tabs are still copied into the body but do not add to lineIndent.
            while ($harvester->cursor->position < $harvester->length && \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                if (' ' === $harvester->input[$harvester->cursor->position]) {
                    ++$lineIndent;
                }
                $result .= $this->consumeCodePoint($harvester);
            }

            if ($harvester->cursor->position >= $harvester->length || \in_array($harvester->input[$harvester->cursor->position], self::CHARS_LINE_BREAK, true)) {
                continue;
            }

            if (null === $minIndent) {
                if (null !== $explicitFloor) {
                    // When the first content line is much deeper than the explicit floor, shallower lines end the body
                    // (e.g. go_yaml/literal-scalars); otherwise the floor alone governs (more-indented-lines fixture).
                    $minIndent = ($lineIndent - $explicitFloor >= 2) ? $lineIndent : $explicitFloor;
                } else {
                    $minIndent = $lineIndent;
                }
            } elseif ($lineIndent < $minIndent && '' !== $result) {
                // After reading this line's leading whitespace, $result often ends with spaces, not a newline;
                // still treat a shallower indent than the block content as end-of-body (YAML 1.2.2 section 8.1.1).
                $backtrack = $harvester->cursor->position - $indentStart;
                if ($backtrack > 0) {
                    $result = substr($result, 0, -$backtrack);
                    $harvester->cursor->position = $indentStart;
                    $harvester->cursor->column = max(1, $harvester->cursor->column - $backtrack);
                }
                break;
            }

            while ($harvester->cursor->position < $harvester->length && !\in_array($harvester->input[$harvester->cursor->position], self::CHARS_LINE_BREAK, true)) {
                $result .= $this->consumeCodePoint($harvester);
            }
        }

        return $result;
    }

    private function readBlockScalarBodyAndApplyChomping(Harvester $harvester): string
    {
        $chomping = $harvester->cursor->blockScalarChomping ?? BlockScalarChomping::Clip;
        $text = $this->readBlockScalarBody($harvester);

        if (BlockScalarChomping::Strip === $chomping) {
            $suffixLen = $this->computeBlockScalarStripSuffixLength($text);
            if ($suffixLen > 0) {
                $text = substr($text, 0, -$suffixLen);
                $harvester->cursor->position -= $suffixLen;
                $this->syncCursorLineColumnFromPrefix($harvester);
            }
        }

        $harvester->cursor->blockScalarChomping = null;

        return $text;
    }

    private function readBlockScalarBodyToken(Harvester $harvester): void
    {
        $type = $harvester->cursor->pendingBlockScalarBody;
        $harvester->cursor->pendingBlockScalarBody = null;
        $text = $this->readBlockScalarBodyAndApplyChomping($harvester);
        $harvester->stream->addToken(new Token($type, $text, $harvester->cursor->line, $harvester->cursor->column));
    }

    private function readDoubleQuotedScalar(Harvester $harvester): string
    {
        $result = '"';
        $this->advance($harvester);
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if ('\\' === $char) {
                $result .= $this->consumeCodePoint($harvester);
                if ($harvester->cursor->position < $harvester->length) {
                    $result .= $this->consumeCodePoint($harvester);
                }
            } elseif ('"' === $char) {
                $result .= $this->consumeCodePoint($harvester);
                break;
            } else {
                $result .= $this->consumeCodePoint($harvester);
            }
        }

        return $result;
    }

    private function readIndentation(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (' ' === $char) {
                $result .= $this->consumeCodePoint($harvester);
                ++$harvester->cursor->currentIndent;
            } else {
                break;
            }
        }

        return $result;
    }

    private function readPlainScalar(Harvester $harvester): string
    {
        $result = '';
        $inFlow = $harvester->cursor->flowDepth > 0;
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (':' === $char && $this->isMappingValue($harvester)) {
                break;
            }
            if ('?' === $char && '' === $result && $this->isMappingKey($harvester)) {
                break;
            }
            if ('#' === $char && $this->isCommentStart($harvester)) {
                break;
            }
            if ($inFlow && (']' === $char || '}' === $char) && '' !== $result) {
                $nextChar = $this->getNextChar($harvester);
                if (null === $nextChar
                    || \in_array($nextChar, self::CHARS_WHITESPACE, true)
                    || \in_array($nextChar, [',', ':', ']', '}', "\n", "\r"], true)) {
                    break;
                }
                $result .= $this->consumeCodePoint($harvester);

                continue;
            }
            if (('[' === $char || '{' === $char) && '' === $result) {
                break;
            }
            if (\in_array($char, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            if ($inFlow && \in_array($char, [',', ']', '}'], true)) {
                break;
            }
            if (\in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                $peek = $harvester->cursor->position + 1;
                while ($peek < $harvester->length && \in_array($harvester->input[$peek], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                    ++$peek;
                }
                if ($peek >= $harvester->length
                    || \in_array($harvester->input[$peek], self::CHARS_LINE_BREAK, true)
                    || '#' === $harvester->input[$peek]
                    || (':' === $harvester->input[$peek] && $this->isColonMappingValueIndicator($harvester, $peek))
                    || ($inFlow && \in_array($harvester->input[$peek], [',', ']', '}', '[', '{'], true))) {
                    break;
                }
            }
            $result .= $this->consumeCodePoint($harvester);
        }

        return $result;
    }

    private function readSingleQuotedScalar(Harvester $harvester): string
    {
        $result = "'";
        $this->advance($harvester);
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if ("'" === $char) {
                $result .= $this->consumeCodePoint($harvester);
                if ($harvester->cursor->position < $harvester->length && "'" === $harvester->input[$harvester->cursor->position]) {
                    $result .= $this->consumeCodePoint($harvester);
                } else {
                    break;
                }
            } else {
                $result .= $this->consumeCodePoint($harvester);
            }
        }

        return $result;
    }

    private function readTagDirectiveHandle(Harvester $harvester): string
    {
        if ($harvester->cursor->position >= $harvester->length || '!' !== $harvester->input[$harvester->cursor->position]) {
            return '';
        }
        $this->advance($harvester);
        if ($harvester->cursor->position < $harvester->length && '!' === $harvester->input[$harvester->cursor->position]) {
            $this->advance($harvester);

            return '!!';
        }
        if ($harvester->cursor->position >= $harvester->length || \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            return '!';
        }
        $savedPosition = $harvester->cursor->position;
        $savedLine = $harvester->cursor->line;
        $savedColumn = $harvester->cursor->column;
        $middle = '';
        while ($harvester->cursor->position < $harvester->length) {
            $c = $harvester->input[$harvester->cursor->position];
            if ('!' === $c) {
                $this->advance($harvester);

                return '!'.$middle.'!';
            }
            if (\in_array($c, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                break;
            }
            if (!$this->isTagChar($c)) {
                break;
            }
            $middle .= $this->consumeCodePoint($harvester);
        }
        $harvester->cursor->position = $savedPosition;
        $harvester->cursor->line = $savedLine;
        $harvester->cursor->column = $savedColumn;

        return '!';
    }

    private function readTagDirectivePrefix(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $c = $harvester->input[$harvester->cursor->position];
            if (\in_array($c, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            if (\in_array($c, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                break;
            }
            if ('#' === $c && $this->isCommentStart($harvester)) {
                break;
            }
            $result .= $this->consumeCodePoint($harvester);
        }

        return $result;
    }

    private function readTagShorthandSuffix(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (',' === $char && $this->isTagCommaStartsRegistrationYear($harvester, $harvester->cursor->position)) {
                $result .= $this->consumeCodePoint($harvester);
                for ($i = 0; $i < 4; ++$i) {
                    $result .= $this->consumeCodePoint($harvester);
                }

                continue;
            }
            if ($this->isTagChar($char)) {
                $result .= $this->consumeCodePoint($harvester);
            } else {
                break;
            }
        }

        return $result;
    }

    private function readToken(Harvester $harvester): void
    {
        $char = $harvester->input[$harvester->cursor->position];
        $startLine = $harvester->cursor->line;
        $startColumn = $harvester->cursor->column;

        $this->maybeEndBlockPlainContinuationAtUnindentedLineStart($harvester);

        // NEWLINE (CRLF, CR, LF)
        if ("\r" === $char) {
            $significantBeforeBreak = $this->getLastSignificantToken($harvester);
            $this->advance($harvester);
            $harvester->cursor->currentIndent = 0;
            if ($harvester->cursor->position < $harvester->length && "\n" === $harvester->input[$harvester->cursor->position]) {
                $this->advance($harvester);
                if ($harvester->cursor->inBlockScalarHeaderLine) {
                    $this->promoteBlockScalarBodyFromHeader($harvester->cursor);
                }

                $harvester->stream->addToken(new Token(TokenType::NEWLINE, "\r\n", $startLine, $startColumn));
                $this->onEmittedNewlineAfterBlockPlainScalar($harvester, $significantBeforeBreak);

                return;
            }
            if ($harvester->cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($harvester->cursor);
            }

            $harvester->stream->addToken(new Token(TokenType::NEWLINE, "\r", $startLine, $startColumn));
            $this->onEmittedNewlineAfterBlockPlainScalar($harvester, $significantBeforeBreak);

            return;
        }
        if ("\n" === $char) {
            $significantBeforeBreak = $this->getLastSignificantToken($harvester);
            $this->advance($harvester);
            $harvester->cursor->currentIndent = 0;
            if ($harvester->cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($harvester->cursor);
            }

            $harvester->stream->addToken(new Token(TokenType::NEWLINE, "\n", $startLine, $startColumn));
            $this->onEmittedNewlineAfterBlockPlainScalar($harvester, $significantBeforeBreak);

            return;
        }

        // INDENTATION (spaces at line start, after newline; tab starts WHITESPACE — not valid YAML indent)
        if (1 === $harvester->cursor->column && ' ' === $char) {
            $indent = $this->readIndentation($harvester);
            if ('' !== $indent) {
                // Blank lines may contain spaces; they must not create structural INDENTATION tokens.
                if ($harvester->cursor->position >= $harvester->length
                    || \in_array($harvester->input[$harvester->cursor->position], self::CHARS_LINE_BREAK, true)) {
                    $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $indent, $startLine, $startColumn));

                    return;
                }

                if ($harvester->cursor->flowDepth > 0) {
                    $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $indent, $startLine, $startColumn));

                    return;
                }
                $this->applyBlockPlainContinuationIndentRules($harvester, $indent);
                $harvester->stream->addToken(new Token(TokenType::INDENTATION, $indent, $startLine, $startColumn));

                return;
            }
        }

        // WHITESPACE (within line)
        if (\in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $spaces = $this->readWhitespace($harvester);
            $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $spaces, $startLine, $startColumn));

            return;
        }

        // BYTE_ORDER_MARK
        if ("\xEF" === $char && $harvester->cursor->position + 2 < $harvester->length
            && "\xBB" === $harvester->input[$harvester->cursor->position + 1] && "\xBF" === $harvester->input[$harvester->cursor->position + 2]) {
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::BYTE_ORDER_MARK, "\xEF\xBB\xBF", $startLine, $startColumn));

            return;
        }

        // DOCUMENT_START (---)
        if ($this->match($harvester, '---')) {
            $this->resetBlockMappingPlainState($harvester->cursor);
            $harvester->cursor->flowCollectionStack = [];
            $harvester->cursor->plainScalarContinuationBaseIndent = 0;
            $harvester->stream->addToken(new Token(TokenType::DOCUMENT_START, '---', $startLine, $startColumn));

            return;
        }

        // DOCUMENT_END (...)
        if ($this->match($harvester, '...')) {
            $this->resetBlockMappingPlainState($harvester->cursor);
            $harvester->cursor->flowCollectionStack = [];
            $harvester->stream->addToken(new Token(TokenType::DOCUMENT_END, '...', $startLine, $startColumn));

            return;
        }

        // COMMENT
        if ('#' === $char && $this->isCommentStart($harvester)) {
            $this->advance($harvester);
            $comment = '#'.$this->readUntilNewline($harvester);
            $harvester->stream->addToken(new Token(TokenType::COMMENT, $comment, $startLine, $startColumn));

            return;
        }

        // DIRECTIVE (%... directive line) — only at line start.
        if ('%' === $char && 1 === $harvester->cursor->column) {
            $directive = $this->readUntilNewline($harvester);
            $harvester->stream->addToken(new Token(TokenType::DIRECTIVE, $directive, $startLine, $startColumn));

            return;
        }

        // FLOW indicators. "{" and "[" always open a flow context. "}", "]" and "," act as
        // structural tokens only inside an open flow context; in block context they are valid
        // plain-scalar content (YAML 1.2 §7.3.3) and must fall through to the plain-scalar reader.
        if (isset(self::FLOW_INDICATOR_TOKEN_TYPES[$char])) {
            if ('{' === $char || '[' === $char) {
                $this->advance($harvester);
                ++$harvester->cursor->flowDepth;
                if (1 === $harvester->cursor->flowDepth) {
                    $this->resetBlockMappingPlainState($harvester->cursor);
                }
                if ('{' === $char) {
                    $harvester->cursor->flowCollectionStack[] = new FlowMapFrame(FlowMapPhase::Key);
                } else {
                    $harvester->cursor->flowCollectionStack[] = new FlowSequenceFrame(FlowSequencePhase::Entry);
                }
                $harvester->stream->addToken(new Token(self::FLOW_INDICATOR_TOKEN_TYPES[$char], $char, $startLine, $startColumn));

                return;
            }
            if ($harvester->cursor->flowDepth > 0) {
                $this->advance($harvester);
                if ('}' === $char || ']' === $char) {
                    $this->onFlowCollectionClosed($harvester);
                    --$harvester->cursor->flowDepth;
                } else {
                    $this->onFlowEntryCommaEmitted($harvester);
                }
                $harvester->stream->addToken(new Token(self::FLOW_INDICATOR_TOKEN_TYPES[$char], $char, $startLine, $startColumn));

                return;
            }
        }

        // DOUBLE_QUOTED_SCALAR
        if ('"' === $char) {
            $scalar = $this->readDoubleQuotedScalar($harvester);
            $harvester->stream->addToken(new Token(TokenType::DOUBLE_QUOTED_SCALAR, $scalar, $startLine, $startColumn));
            $this->onFlowMapScalarLikeNodeEmitted($harvester, TokenType::DOUBLE_QUOTED_SCALAR);

            return;
        }

        // SINGLE_QUOTED_SCALAR
        if ("'" === $char) {
            $scalar = $this->readSingleQuotedScalar($harvester);
            $harvester->stream->addToken(new Token(TokenType::SINGLE_QUOTED_SCALAR, $scalar, $startLine, $startColumn));
            $this->onFlowMapScalarLikeNodeEmitted($harvester, TokenType::SINGLE_QUOTED_SCALAR);

            return;
        }

        // Block scalar header line (chomping / indentation) — before SEQUENCE_ENTRY so '-' is not a list entry
        if ($harvester->cursor->inBlockScalarHeaderLine) {
            if ('+' === $char || '-' === $char) {
                $this->advance($harvester);
                $harvester->cursor->blockScalarChomping = '-' === $char ? BlockScalarChomping::Strip : BlockScalarChomping::Keep;
                $harvester->stream->addToken(new Token(TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR, $char, $startLine, $startColumn));

                return;
            }
            if ($char >= '0' && $char <= '9') {
                $this->advance($harvester);
                $harvester->cursor->blockScalarAdditionalIndentFromIndicator = (int) $char;
                $harvester->cursor->blockScalarExplicitIndentIndicator = true;
                $harvester->stream->addToken(new Token(TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR, $char, $startLine, $startColumn));

                return;
            }
        }

        // SEQUENCE_ENTRY (-) - must check before plain scalar
        if ('-' === $char && $this->isSequenceEntry($harvester) && !$this->isDashBlockPlainContinuationLine($harvester)) {
            if (0 === $harvester->cursor->flowDepth) {
                $this->resetBlockMappingPlainState($harvester->cursor);
                $harvester->cursor->plainScalarContinuationBaseIndent = $harvester->cursor->currentIndent;
                $harvester->cursor->awaitingBlockPlainContinuation = false;
            }
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::SEQUENCE_ENTRY, '-', $startLine, $startColumn));

            return;
        }

        // EXPLICIT_KEY_INDICATOR (?)
        if ('?' === $char && $this->isMappingKey($harvester)) {
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::EXPLICIT_KEY_INDICATOR, '?', $startLine, $startColumn));

            return;
        }

        // VALUE_INDICATOR (:)
        if (':' === $char && $this->isMappingValue($harvester)) {
            if (0 === $harvester->cursor->flowDepth) {
                $harvester->cursor->blockMappingKeyIndent = $harvester->cursor->currentIndent;
                $harvester->cursor->plainScalarContinuationBaseIndent = $harvester->cursor->currentIndent;
                $harvester->cursor->awaitingBlockPlainContinuation = false;
                $harvester->cursor->suppressAnchorAlias = false;
                $harvester->cursor->suppressExplicitTagForBang = false;
                $lastSignificant = $this->getLastSignificantToken($harvester);
                if (null !== $lastSignificant && TokenType::PLAIN_SCALAR === $lastSignificant->type && $lastSignificant->line === $startLine) {
                    $harvester->cursor->blockScalarValueParentIndent = $lastSignificant->column - 1;
                } else {
                    $harvester->cursor->blockScalarValueParentIndent = null;
                }
            }
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::VALUE_INDICATOR, ':', $startLine, $startColumn));
            $this->onFlowMappingValueIndicatorEmitted($harvester);

            return;
        }

        // ANCHOR (&name)
        if ('&' === $char && !$harvester->cursor->suppressAnchorAlias) {
            $anchor = '&'.$this->readAnchorOrAlias($harvester);
            $harvester->stream->addToken(new Token(TokenType::ANCHOR, $anchor, $startLine, $startColumn));

            return;
        }

        // ALIAS (*name)
        if ('*' === $char && !$harvester->cursor->suppressAnchorAlias) {
            $alias = '*'.$this->readAnchorOrAlias($harvester);
            $harvester->stream->addToken(new Token(TokenType::ALIAS, $alias, $startLine, $startColumn));
            $this->onFlowMapScalarLikeNodeEmitted($harvester, TokenType::ALIAS);

            return;
        }

        // FOLDED BLOCK SCALAR (>)
        if ('>' === $char && $this->isBlockScalarStart($harvester)) {
            $this->advance($harvester);
            $harvester->cursor->inBlockScalarHeaderLine = true;
            $harvester->cursor->blockScalarBodyTokenType = TokenType::FOLDED_BLOCK_SCALAR;
            $harvester->cursor->blockScalarChomping = null;
            $harvester->cursor->blockScalarExplicitIndentIndicator = false;
            $harvester->stream->addToken(new Token(TokenType::FOLDED_BLOCK_SCALAR_INDICATOR, $char, $startLine, $startColumn));

            return;
        }

        // LITERAL BLOCK SCALAR (|)
        if ('|' === $char && $this->isBlockScalarStart($harvester)) {
            $this->advance($harvester);
            $harvester->cursor->inBlockScalarHeaderLine = true;
            $harvester->cursor->blockScalarBodyTokenType = TokenType::LITERAL_BLOCK_SCALAR;
            $harvester->cursor->blockScalarChomping = null;
            $harvester->cursor->blockScalarExplicitIndentIndicator = false;
            $harvester->stream->addToken(new Token(TokenType::LITERAL_BLOCK_SCALAR_INDICATOR, $char, $startLine, $startColumn));

            return;
        }

        // MERGE_INDICATOR (YAML 1.1 merge key << before :)
        if ($this->isMergeKeyPlainSequence($harvester)) {
            $this->advance($harvester);
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::MERGE_INDICATOR, '<<', $startLine, $startColumn));
            $this->onFlowMapScalarLikeNodeEmitted($harvester, TokenType::MERGE_INDICATOR);

            return;
        }

        // PLAIN_SCALAR
        $plain = $this->readPlainScalar($harvester);
        if ('' !== $plain) {
            $harvester->stream->addToken(new Token(TokenType::PLAIN_SCALAR, $plain, $startLine, $startColumn));
            $this->onFlowMapScalarLikeNodeEmitted($harvester, TokenType::PLAIN_SCALAR);

            return;
        }

        $text = $this->consumeCodePoint($harvester);
        $harvester->stream->addToken(new Token(TokenType::UNRECOGNIZED, $text, $startLine, $startColumn));
    }

    private function readUntilNewline(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (\in_array($char, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            $result .= $this->consumeCodePoint($harvester);
        }

        return $result;
    }

    private function readWhitespace(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (\in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                $result .= $this->consumeCodePoint($harvester);
            } else {
                break;
            }
        }

        return $result;
    }

    private function readYamlDirectiveVersion(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $c = $harvester->input[$harvester->cursor->position];
            if (\in_array($c, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            if (\in_array($c, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                break;
            }
            if ('#' === $c && $this->isCommentStart($harvester)) {
                break;
            }
            $result .= $this->consumeCodePoint($harvester);
        }

        return $result;
    }

    private function resetBlockMappingPlainState(Cursor $cursor): void
    {
        $cursor->awaitingBlockPlainContinuation = false;
        $cursor->blockMappingKeyIndent = null;
        $cursor->plainScalarContinuationBaseIndent = null;
        $cursor->suppressAnchorAlias = false;
        $cursor->suppressExplicitTagForBang = false;
    }

    /**
     * Split `%TAG` lines into `DIRECTIVE_TAG_INDICATOR`, `DIRECTIVE_TAG_HANDLE`, `DIRECTIVE_TAG_PREFIX` only when the keyword
     * is followed by a handle (starts with `!`) or horizontal whitespace / EOF — not when followed immediately by a
     * line break (whole-line token as before).
     */
    private function shouldTokenizeTagDirectiveAsParts(Harvester $harvester): bool
    {
        if ($harvester->cursor->position + 4 > $harvester->length) {
            return false;
        }
        if ('%TAG' !== substr($harvester->input, $harvester->cursor->position, 4)) {
            return false;
        }
        if ($harvester->cursor->position + 4 >= $harvester->length) {
            return true;
        }
        $after = $harvester->input[$harvester->cursor->position + 4];

        return \in_array($after, self::CHARS_HORIZONTAL_WHITESPACE, true) || '!' === $after;
    }

    private function shouldTokenizeYamlDirectiveAsParts(Harvester $harvester): bool
    {
        return '%YAML' === substr($harvester->input, $harvester->cursor->position, 5)
        && (
            ($harvester->cursor->position + 5 >= $harvester->length)
            || \in_array(
                $harvester->input[$harvester->cursor->position + 5] ?? null,
                [...self::CHARS_HORIZONTAL_WHITESPACE, ...self::CHARS_LINE_BREAK, ':'],
                true,
            )
        );
    }

    private function syncCursorLineColumnFromPrefix(Harvester $harvester): void
    {
        $pos = min($harvester->cursor->position, $harvester->length);
        $line = 1;
        $column = 1;
        $i = 0;
        while ($i < $pos) {
            $c = $harvester->input[$i];
            if ("\n" === $c) {
                ++$line;
                $column = 1;
                ++$i;

                continue;
            }
            if ("\r" === $c) {
                ++$line;
                $column = 1;
                ++$i;
                if ($i < $pos && "\n" === $harvester->input[$i]) {
                    ++$i;
                }

                continue;
            }
            $w = $this->utf8CodePointByteWidth($harvester, $i);
            ++$column;
            $i += $w;
        }
        $harvester->cursor->line = $line;
        $harvester->cursor->column = $column;
    }

    /**
     * Explicit tag property at a node: `!<...>` verbatim, shorthand (`!`, `!!`, `!name!`) + suffix, or non-specific `!`.
     * Tokens are appended to {@see Harvester::$stream}. Does not apply to `%TAG` directive lines (handled in {@see tokenizeTagDirectiveLine}).
     */
    private function tokenizeExplicitTag(Harvester $harvester): void
    {
        $bangLine = $harvester->cursor->line;
        $bangColumn = $harvester->cursor->column;
        $this->advance($harvester);

        if ($harvester->cursor->position >= $harvester->length) {
            $harvester->stream->addToken(new Token(TokenType::TAG, '!', $bangLine, $bangColumn));

            return;
        }

        $next = $harvester->input[$harvester->cursor->position];

        if ('<' === $next) {
            $this->advance($harvester);

            $body = '';
            while ($harvester->cursor->position < $harvester->length && '>' !== $harvester->input[$harvester->cursor->position]) {
                $body .= $this->consumeCodePoint($harvester);
            }
            $closeText = '';
            if ($harvester->cursor->position < $harvester->length && '>' === $harvester->input[$harvester->cursor->position]) {
                $closeText = '>';
                $this->advance($harvester);
            }

            $verbatimText = '!<'.$body.$closeText;
            $harvester->stream->addToken(new Token(TokenType::TAG, $verbatimText, $bangLine, $bangColumn));

            return;
        }

        if ('!' === $next) {
            $this->advance($harvester);
            $suffix = $this->readTagShorthandSuffix($harvester);
            $harvester->stream->addToken(new Token(TokenType::TAG, '!!'.$suffix, $bangLine, $bangColumn));

            return;
        }

        $firstBangPos = $harvester->cursor->position - 1;
        $nameStart = $harvester->cursor->position;
        $j = $nameStart;
        while ($j < $harvester->length && $this->isTagHandleNameChar($harvester->input[$j])) {
            ++$j;
        }
        if ($j < $harvester->length && '!' === $harvester->input[$j] && $j > $nameStart) {
            $handleEnd = $j;
            while ($harvester->cursor->position <= $handleEnd) {
                $this->advance($harvester);
            }
            $handleText = substr($harvester->input, $firstBangPos, $handleEnd - $firstBangPos + 1);
            $suffix = $this->readTagShorthandSuffix($harvester);

            $harvester->stream->addToken(new Token(TokenType::TAG, $handleText.$suffix, $bangLine, $bangColumn));

            return;
        }

        $suffix = $this->readTagShorthandSuffix($harvester);
        if ('' === $suffix) {
            $harvester->stream->addToken(new Token(TokenType::TAG, '!', $bangLine, $bangColumn));

            return;
        }

        $harvester->stream->addToken(new Token(TokenType::TAG, '!'.$suffix, $bangLine, $bangColumn));
    }

    private function tokenizeTagDirectiveLine(Harvester $harvester): void
    {
        $directiveTagLine = $harvester->cursor->line;
        $directiveTagColumn = $harvester->cursor->column;
        if (!$this->match($harvester, '%TAG')) {
            return;
        }
        $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_TAG_INDICATOR, '%TAG', $directiveTagLine, $directiveTagColumn));

        if ($harvester->cursor->position < $harvester->length && \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $harvester->cursor->line;
            $wsColumn = $harvester->cursor->column;
            $ws = $this->readWhitespace($harvester);
            $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn));
        }

        $handleLine = $harvester->cursor->line;
        $handleColumn = $harvester->cursor->column;
        $handle = $this->readTagDirectiveHandle($harvester);
        $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_TAG_HANDLE, $handle, $handleLine, $handleColumn));

        if ($harvester->cursor->position < $harvester->length && \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $harvester->cursor->line;
            $wsColumn = $harvester->cursor->column;
            $ws = $this->readWhitespace($harvester);
            $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn));
        }

        $prefixLine = $harvester->cursor->line;
        $prefixColumn = $harvester->cursor->column;
        $prefix = $this->readTagDirectivePrefix($harvester);
        $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_TAG_PREFIX, $prefix, $prefixLine, $prefixColumn));
    }

    private function tokenizeYamlDirectiveLine(Harvester $harvester): void
    {
        $directiveYamlLine = $harvester->cursor->line;
        $directiveYamlColumn = $harvester->cursor->column;
        if (!$this->match($harvester, '%YAML')) {
            return;
        }
        $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_YAML_INDICATOR, '%YAML', $directiveYamlLine, $directiveYamlColumn));

        if ($harvester->cursor->position < $harvester->length && \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $harvester->cursor->line;
            $wsColumn = $harvester->cursor->column;
            $ws = $this->readWhitespace($harvester);
            $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn));
        }

        if ($harvester->cursor->position < $harvester->length && ':' === $harvester->input[$harvester->cursor->position]) {
            $colonLine = $harvester->cursor->line;
            $colonColumn = $harvester->cursor->column;
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::VALUE_INDICATOR, ':', $colonLine, $colonColumn));
        }

        if ($harvester->cursor->position < $harvester->length && \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $harvester->cursor->line;
            $wsColumn = $harvester->cursor->column;
            $ws = $this->readWhitespace($harvester);
            $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn));
        }

        $versionLine = $harvester->cursor->line;
        $versionColumn = $harvester->cursor->column;
        $version = $this->readYamlDirectiveVersion($harvester);
        if ('' !== $version) {
            $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_YAML_VERSION, $version, $versionLine, $versionColumn));
        }
    }

    /**
     * UTF-8 byte length of the code point starting at $position, without validating continuation bytes.
     * If the sequence is truncated or the leading byte is invalid, returns 1.
     */
    private function utf8CodePointByteWidth(Harvester $harvester, int $position): int
    {
        if ($position >= $harvester->length) {
            return 0;
        }
        $byte = \ord($harvester->input[$position]);
        if ($byte < 0x80) {
            return 1;
        }
        if (0x80 === ($byte & 0xC0)) {
            return 1;
        }
        $expected = 0;
        if (0xC0 === ($byte & 0xE0)) {
            $expected = 2;
        } elseif (0xE0 === ($byte & 0xF0)) {
            $expected = 3;
        } elseif (0xF0 === ($byte & 0xF8)) {
            $expected = 4;
        } else {
            return 1;
        }
        if ($harvester->length - $position < $expected) {
            return 1;
        }

        return $expected;
    }
}
