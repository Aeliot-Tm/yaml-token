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
use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Dto\Cursor;
use Aeliot\YamlToken\Lexer\Dto\Harvester;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Lexer
{
    /**
     * @var list<string>
     */
    private const CHARS_ANCHOR_OR_TAG_FORBIDDEN = [...self::CHARS_WHITESPACE, '[', ']', '{', '}', ',', ':', '#', "\0"];

    /**
     * @var list<string>
     */
    private const CHARS_BLOCK_SCALAR_START = [...self::CHARS_WHITESPACE, '+', '-', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

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
    private const CHARS_MAPPING_VALUE_SUFFIX = [...self::CHARS_WHITESPACE, '#', '[', '{', '"', "'"];

    /**
     * @var list<string>
     */
    private const CHARS_PLAIN_SCALAR_STOP = [...self::CHARS_LINE_BREAK, ',', ']', '}'];

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
                $body = $this->readBlockScalarBodyAndApplyChomping($harvester);
                $this->splitExplicitIndentBlockBodyToTokens($harvester, $body);
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
                $this->tokenizeExplicitTag($harvester);

                continue;
            }

            $this->readToken($harvester);
        }

        return $harvester->stream;
    }

    private function getNextChar(Harvester $harvester): ?string
    {
        $next = $harvester->cursor->position + 1;
        if ($next >= $harvester->length) {
            return null;
        }

        return $harvester->input[$next];
    }

    private function promoteBlockScalarBodyFromHeader(Cursor $cursor): void
    {
        if (null === $cursor->blockScalarChomping) {
            $cursor->blockScalarChomping = BlockScalarChomping::Clip;
        }
        $cursor->inBlockScalarHeaderLine = false;
        if ($cursor->blockScalarExplicitIndentIndicator) {
            $cursor->inExplicitIndentBlockScalarBody = true;
            $cursor->blockScalarExplicitIndentIndicator = false;
        } else {
            $cursor->pendingBlockScalarBody = $cursor->blockScalarBodyTokenType;
        }
        $cursor->blockScalarBodyTokenType = null;
    }

    private function readToken(Harvester $harvester): void
    {
        $char = $harvester->input[$harvester->cursor->position];
        $startLine = $harvester->cursor->line;
        $startColumn = $harvester->cursor->column;

        // NEWLINE (CRLF, CR, LF)
        if ("\r" === $char) {
            $this->advance($harvester);
            $harvester->cursor->currentIndent = 0;
            if ($harvester->cursor->position < $harvester->length && "\n" === $harvester->input[$harvester->cursor->position]) {
                $this->advance($harvester);
                if ($harvester->cursor->inBlockScalarHeaderLine) {
                    $this->promoteBlockScalarBodyFromHeader($harvester->cursor);
                }

                $harvester->stream->addToken(new Token(TokenType::NEWLINE, "\r\n", $startLine, $startColumn));

                return;
            }
            if ($harvester->cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($harvester->cursor);
            }

            $harvester->stream->addToken(new Token(TokenType::NEWLINE, "\r", $startLine, $startColumn));

            return;
        }
        if ("\n" === $char) {
            $this->advance($harvester);
            $harvester->cursor->currentIndent = 0;
            if ($harvester->cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($harvester->cursor);
            }

            $harvester->stream->addToken(new Token(TokenType::NEWLINE, "\n", $startLine, $startColumn));

            return;
        }

        // INDENTATION (spaces at line start, after newline; tab starts WHITESPACE — not valid YAML indent)
        if (1 === $harvester->cursor->column && ' ' === $char) {
            $indent = $this->readIndentation($harvester);
            if ('' !== $indent) {
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
            $harvester->stream->addToken(new Token(TokenType::DOCUMENT_START, '---', $startLine, $startColumn));

            return;
        }

        // DOCUMENT_END (...)
        if ($this->match($harvester, '...')) {
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

        // DIRECTIVE_TAG (%TAG ...) — split into parts in {@see tokenizeTagDirectiveLine} when applicable
        if ($this->match($harvester, '%TAG')) {
            $directive = '%TAG'.$this->readUntilNewline($harvester);
            $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_TAG, $directive, $startLine, $startColumn));

            return;
        }

        // DIRECTIVE (%... for other directives)
        if ('%' === $char) {
            $directive = $this->readUntilNewline($harvester);
            $harvester->stream->addToken(new Token(TokenType::DIRECTIVE, $directive, $startLine, $startColumn));

            return;
        }

        // FLOW indicators
        if (isset(self::FLOW_INDICATOR_TOKEN_TYPES[$char])) {
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(self::FLOW_INDICATOR_TOKEN_TYPES[$char], $char, $startLine, $startColumn));

            return;
        }

        // DOUBLE_QUOTED_SCALAR
        if ('"' === $char) {
            $scalar = $this->readDoubleQuotedScalar($harvester);
            $harvester->stream->addToken(new Token(TokenType::DOUBLE_QUOTED_SCALAR, $scalar, $startLine, $startColumn));

            return;
        }

        // SINGLE_QUOTED_SCALAR
        if ("'" === $char) {
            $scalar = $this->readSingleQuotedScalar($harvester);
            $harvester->stream->addToken(new Token(TokenType::SINGLE_QUOTED_SCALAR, $scalar, $startLine, $startColumn));

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
                $harvester->cursor->blockScalarExplicitIndentIndicator = true;
                $harvester->stream->addToken(new Token(TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR, $char, $startLine, $startColumn));

                return;
            }
        }

        // SEQUENCE_ENTRY (-) - must check before plain scalar
        if ('-' === $char && $this->isSequenceEntry($harvester)) {
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
            $this->advance($harvester);
            $harvester->stream->addToken(new Token(TokenType::VALUE_INDICATOR, ':', $startLine, $startColumn));

            return;
        }

        // ANCHOR (&name)
        if ('&' === $char) {
            $anchor = '&'.$this->readAnchorOrAlias($harvester);
            $harvester->stream->addToken(new Token(TokenType::ANCHOR, $anchor, $startLine, $startColumn));

            return;
        }

        // ALIAS (*name)
        if ('*' === $char) {
            $alias = '*'.$this->readAnchorOrAlias($harvester);
            $harvester->stream->addToken(new Token(TokenType::ALIAS, $alias, $startLine, $startColumn));

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

            return;
        }

        // PLAIN_SCALAR
        $plain = $this->readPlainScalar($harvester);
        if ('' !== $plain) {
            $harvester->stream->addToken(new Token(TokenType::PLAIN_SCALAR, $plain, $startLine, $startColumn));

            return;
        }

        $text = $this->consumeCodePoint($harvester);
        $harvester->stream->addToken(new Token(TokenType::UNRECOGNIZED, $text, $startLine, $startColumn));
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

    private function consumeCodePoint(Harvester $harvester): string
    {
        $fragment = $this->codePointFragmentAt($harvester, $harvester->cursor->position);
        $this->advance($harvester);

        return $fragment;
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

    private function shouldTokenizeYamlDirectiveAsParts(Harvester $harvester): bool
    {
        return '%YAML' === substr($harvester->input, $harvester->cursor->position, 5);
    }

    private function tokenizeYamlDirectiveLine(Harvester $harvester): void
    {
        $directiveYamlLine = $harvester->cursor->line;
        $directiveYamlColumn = $harvester->cursor->column;
        if (!$this->match($harvester, '%YAML')) {
            return;
        }
        $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_YAML, '%YAML', $directiveYamlLine, $directiveYamlColumn));

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

    /**
     * Split `%TAG` lines into `DIRECTIVE_TAG`, `DIRECTIVE_TAG_HANDLE`, `DIRECTIVE_TAG_PREFIX` only when the keyword
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

    private function tokenizeTagDirectiveLine(Harvester $harvester): void
    {
        $directiveTagLine = $harvester->cursor->line;
        $directiveTagColumn = $harvester->cursor->column;
        if (!$this->match($harvester, '%TAG')) {
            return;
        }
        $harvester->stream->addToken(new Token(TokenType::DIRECTIVE_TAG, '%TAG', $directiveTagLine, $directiveTagColumn));

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

        if ($harvester->cursor->position < $harvester->length && \in_array($harvester->input[$harvester->cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $harvester->cursor->line;
            $wsColumn = $harvester->cursor->column;
            $ws = $this->readWhitespace($harvester);
            $harvester->stream->addToken(new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn));
        }

        if ($harvester->cursor->position < $harvester->length && '#' === $harvester->input[$harvester->cursor->position] && $this->isCommentStart($harvester)) {
            $commentLine = $harvester->cursor->line;
            $commentColumn = $harvester->cursor->column;
            $this->advance($harvester);
            $comment = '#'.$this->readUntilNewline($harvester);
            $harvester->stream->addToken(new Token(TokenType::COMMENT, $comment, $commentLine, $commentColumn));
        }
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

    private function isSequenceEntry(Harvester $harvester): bool
    {
        $nextChar = $this->getNextChar($harvester);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_WHITESPACE, true);
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
     * ':' introduces a mapping value when the byte at $colonPosition is ':' and the following byte, if any,
     * matches {@see self::CHARS_MAPPING_VALUE_SUFFIX} or end of input.
     */
    private function isColonMappingValueIndicator(Harvester $harvester, int $colonPosition): bool
    {
        if ($colonPosition >= $harvester->length || ':' !== $harvester->input[$colonPosition]) {
            return false;
        }
        $afterColon = $colonPosition + 1;
        if ($afterColon >= $harvester->length) {
            return true;
        }

        return \in_array($harvester->input[$afterColon], self::CHARS_MAPPING_VALUE_SUFFIX, true);
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

    private function isAnchorChar(string $char): bool
    {
        return !\in_array($char, self::CHARS_ANCHOR_OR_TAG_FORBIDDEN, true);
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
            $harvester->stream->addToken(new Token(TokenType::TAG_NON_SPECIFIC, '!', $bangLine, $bangColumn));

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
            $harvester->stream->addToken(new Token(TokenType::TAG_HANDLE_VERBATIM, $verbatimText, $bangLine, $bangColumn));

            return;
        }

        if ('!' === $next) {
            $this->advance($harvester);
            $suffixLine = $harvester->cursor->line;
            $suffixColumn = $harvester->cursor->column;
            $suffix = $this->readTagShorthandSuffix($harvester);

            $harvester->stream->addToken(new Token(TokenType::TAG_HANDLE_SECONDARY, '!!', $bangLine, $bangColumn));
            $harvester->stream->addToken(new Token(TokenType::TAG_BODY, $suffix, $suffixLine, $suffixColumn));

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
            $suffixLine = $harvester->cursor->line;
            $suffixColumn = $harvester->cursor->column;
            $suffix = $this->readTagShorthandSuffix($harvester);

            $harvester->stream->addToken(new Token(TokenType::TAG_HANDLE_NAMED, $handleText, $bangLine, $bangColumn));
            $harvester->stream->addToken(new Token(TokenType::TAG_BODY, $suffix, $suffixLine, $suffixColumn));

            return;
        }

        $suffixLine = $harvester->cursor->line;
        $suffixColumn = $harvester->cursor->column;
        $suffix = $this->readTagShorthandSuffix($harvester);
        if ('' === $suffix) {
            $harvester->stream->addToken(new Token(TokenType::TAG_NON_SPECIFIC, '!', $bangLine, $bangColumn));

            return;
        }

        $harvester->stream->addToken(new Token(TokenType::TAG_HANDLE_PRIMARY, '!', $bangLine, $bangColumn));
        $harvester->stream->addToken(new Token(TokenType::TAG_BODY, $suffix, $suffixLine, $suffixColumn));
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

    private function readTagShorthandSuffix(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (',' === $char && $this->tagCommaStartsRegistrationYear($harvester, $harvester->cursor->position)) {
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

    /**
     * After "!", comma + four ASCII digits begin the registration date in global tag shorthand (YAML 1.0 style).
     */
    private function tagCommaStartsRegistrationYear(Harvester $harvester, int $commaPosition): bool
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

    private function isTagChar(string $char): bool
    {
        return !\in_array($char, self::CHARS_ANCHOR_OR_TAG_FORBIDDEN, true);
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

    private function isBlockScalarStart(Harvester $harvester): bool
    {
        $nextChar = $this->getNextChar($harvester);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_BLOCK_SCALAR_START, true);
    }

    private function readBlockScalarBody(Harvester $harvester): string
    {
        $result = '';
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
                $minIndent = $lineIndent;
            }
            if ($lineIndent < $minIndent && '' !== $result && "\n" === substr($result, -1)) {
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

    private function readBlockScalarBodyToken(Harvester $harvester): void
    {
        $type = $harvester->cursor->pendingBlockScalarBody;
        $harvester->cursor->pendingBlockScalarBody = null;
        $text = $this->readBlockScalarBodyAndApplyChomping($harvester);
        $harvester->stream->addToken(new Token($type, $text, $harvester->cursor->line, $harvester->cursor->column));
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

    private function splitExplicitIndentBlockBodyToTokens(Harvester $harvester, string $body): void
    {
        $len = \strlen($body);
        $offset = 0;
        while ($offset < $len) {
            $nl = $this->findNextLineBreakInString($body, $offset, $len);
            $lineEnd = null !== $nl ? $nl['start'] : $len;
            $line = substr($body, $offset, $lineEnd - $offset);
            $lineLen = \strlen($line);
            $i = 0;
            $indentBytes = '';
            while ($i < $lineLen && \in_array($line[$i], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                $indentBytes .= $line[$i];
                ++$i;
            }
            if ('' !== $indentBytes) {
                $harvester->stream->addToken(new Token(TokenType::INDENTATION, $indentBytes, 1, 1));
            }
            $rest = substr($line, $i);
            if ('' !== $rest) {
                $harvester->stream->addToken(new Token(TokenType::PLAIN_SCALAR, $rest, 1, 1));
            }
            if (null === $nl) {
                break;
            }
            $harvester->stream->addToken(new Token(TokenType::NEWLINE, substr($body, $nl['start'], $nl['len']), 1, 1));
            $offset = $nl['start'] + $nl['len'];
        }
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

    private function blockScalarLineHasNonSpaceTabContent(string $line): bool
    {
        return 1 === preg_match('/[^ \t]/', $line);
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

    private function readPlainScalar(Harvester $harvester): string
    {
        $result = '';
        while ($harvester->cursor->position < $harvester->length) {
            $char = $harvester->input[$harvester->cursor->position];
            if (':' === $char && $this->isMappingValue($harvester)) {
                break;
            }
            if ('?' === $char && $this->isMappingKey($harvester)) {
                break;
            }
            if ('#' === $char && $this->isCommentStart($harvester)) {
                break;
            }
            if ((']' === $char || '}' === $char) && '' !== $result) {
                $nextChar = $this->getNextChar($harvester);
                if (null === $nextChar
                    || \in_array($nextChar, self::CHARS_WHITESPACE, true)
                    || \in_array($nextChar, [',', ']', '}', "\n", "\r"], true)) {
                    break;
                }
                $result .= $this->consumeCodePoint($harvester);

                continue;
            }
            if (('[' === $char || '{' === $char) && '' === $result) {
                break;
            }
            if (\in_array($char, self::CHARS_PLAIN_SCALAR_STOP, true)) {
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
                    || \in_array($harvester->input[$peek], [',', ']', '}', '[', '{'], true)) {
                    break;
                }
            }
            $result .= $this->consumeCodePoint($harvester);
        }

        return $result;
    }
}
