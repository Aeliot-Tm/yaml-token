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

use Aeliot\YamlToken\Dto\Cursor;
use Aeliot\YamlToken\Enum\BlockScalarChomping;
use Aeliot\YamlToken\Enum\TokenType;
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

    private const INDENT_SIZE_TAB = 4;

    public function tokenize(string $input): TokenStream
    {
        $stream = new TokenStream();
        $cursor = new Cursor();

        $length = \strlen($input);

        while ($cursor->position < $length || null !== $cursor->pendingBlockScalarBody) {
            if ($cursor->position >= $length && $cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($cursor);

                continue;
            }
            if (null !== $cursor->pendingBlockScalarBody) {
                $stream->addToken($this->readBlockScalarBodyToken($input, $cursor, $length));

                continue;
            }
            if ($cursor->inExplicitIndentBlockScalarBody) {
                if (null === $cursor->explicitBlockScalarPendingTokens) {
                    $body = $this->readBlockScalarBodyAndApplyChomping($input, $cursor, $length);
                    $cursor->explicitBlockScalarPendingTokens = $this->splitExplicitIndentBlockBodyToTokens($body);
                }
                if ([] !== $cursor->explicitBlockScalarPendingTokens) {
                    $stream->addToken(array_shift($cursor->explicitBlockScalarPendingTokens));

                    continue;
                }
                $cursor->inExplicitIndentBlockScalarBody = false;
                $cursor->explicitBlockScalarPendingTokens = null;

                continue;
            }
            if ($cursor->position >= $length) {
                break;
            }
            $stream->addToken($this->readToken($input, $cursor, $length));
        }

        return $stream;
    }

    private function getNextChar(string $input, Cursor $cursor, int $length): ?string
    {
        $next = $cursor->position + 1;
        if ($next >= $length) {
            return null;
        }

        return $input[$next];
    }

    private function promoteBlockScalarBodyFromHeader(Cursor $cursor): void
    {
        if (null === $cursor->blockScalarChomping) {
            $cursor->blockScalarChomping = BlockScalarChomping::Clip;
        }
        $cursor->inBlockScalarHeaderLine = false;
        if ($cursor->blockScalarExplicitIndentIndicator) {
            $cursor->inExplicitIndentBlockScalarBody = true;
            $cursor->explicitBlockScalarPendingTokens = null;
            $cursor->blockScalarExplicitIndentIndicator = false;
        } else {
            $cursor->pendingBlockScalarBody = $cursor->blockScalarBodyTokenType;
        }
        $cursor->blockScalarBodyTokenType = null;
    }

    private function readToken(string $input, Cursor $cursor, int $length): Token
    {
        $char = $input[$cursor->position];
        $startLine = $cursor->line;
        $startColumn = $cursor->column;

        // NEWLINE (CRLF, CR, LF)
        if ("\r" === $char) {
            $this->advance($input, $cursor, $length);
            $cursor->currentIndent = 0;
            if ($cursor->position < $length && "\n" === $input[$cursor->position]) {
                $this->advance($input, $cursor, $length);
                if ($cursor->inBlockScalarHeaderLine) {
                    $this->promoteBlockScalarBodyFromHeader($cursor);
                }

                return new Token(TokenType::NEWLINE, "\r\n", $startLine, $startColumn);
            }
            if ($cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($cursor);
            }

            return new Token(TokenType::NEWLINE, "\r", $startLine, $startColumn);
        }
        if ("\n" === $char) {
            $this->advance($input, $cursor, $length);
            $cursor->currentIndent = 0;
            if ($cursor->inBlockScalarHeaderLine) {
                $this->promoteBlockScalarBodyFromHeader($cursor);
            }

            return new Token(TokenType::NEWLINE, "\n", $startLine, $startColumn);
        }

        // INDENTATION (spaces at line start, after newline)
        if (1 === $cursor->column && \in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $indent = $this->readIndentation($input, $cursor, $length);
            if ('' !== $indent) {
                return new Token(TokenType::INDENTATION, $indent, $startLine, $startColumn);
            }
        }

        // WHITESPACE (within line)
        if (\in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $spaces = $this->readWhitespace($input, $cursor, $length);

            return new Token(TokenType::WHITESPACE, $spaces, $startLine, $startColumn);
        }

        // BYTE_ORDER_MARK
        if ("\xEF" === $char && $cursor->position + 2 < $length
            && "\xBB" === $input[$cursor->position + 1] && "\xBF" === $input[$cursor->position + 2]) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::BYTE_ORDER_MARK, "\xEF\xBB\xBF", $startLine, $startColumn);
        }

        // DOCUMENT_START (---)
        if ($this->match($input, $cursor, $length, '---')) {
            return new Token(TokenType::DOCUMENT_START, '---', $startLine, $startColumn);
        }

        // DOCUMENT_END (...)
        if ($this->match($input, $cursor, $length, '...')) {
            return new Token(TokenType::DOCUMENT_END, '...', $startLine, $startColumn);
        }

        // COMMENT
        if ('#' === $char && $this->isCommentStart($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);
            $comment = '#'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::COMMENT, $comment, $startLine, $startColumn);
        }

        // DIRECTIVE_YAML (%YAML ...)
        if ($this->match($input, $cursor, $length, '%YAML')) {
            $directive = '%YAML'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::DIRECTIVE_YAML, $directive, $startLine, $startColumn);
        }

        // DIRECTIVE_TAG (%TAG ...)
        if ($this->match($input, $cursor, $length, '%TAG')) {
            $directive = '%TAG'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::DIRECTIVE_TAG, $directive, $startLine, $startColumn);
        }

        // DIRECTIVE (%... for other directives)
        if ('%' === $char) {
            $directive = $this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::DIRECTIVE, $directive, $startLine, $startColumn);
        }

        // FLOW indicators
        if (isset(self::FLOW_INDICATOR_TOKEN_TYPES[$char])) {
            $this->advance($input, $cursor, $length);

            return new Token(self::FLOW_INDICATOR_TOKEN_TYPES[$char], $char, $startLine, $startColumn);
        }

        // DOUBLE_QUOTED_SCALAR
        if ('"' === $char) {
            $scalar = $this->readDoubleQuotedScalar($input, $cursor, $length);

            return new Token(TokenType::DOUBLE_QUOTED_SCALAR, $scalar, $startLine, $startColumn);
        }

        // SINGLE_QUOTED_SCALAR
        if ("'" === $char) {
            $scalar = $this->readSingleQuotedScalar($input, $cursor, $length);

            return new Token(TokenType::SINGLE_QUOTED_SCALAR, $scalar, $startLine, $startColumn);
        }

        // Block scalar header line (chomping / indentation) — before SEQUENCE_ENTRY so '-' is not a list entry
        if ($cursor->inBlockScalarHeaderLine) {
            if ('+' === $char || '-' === $char) {
                $this->advance($input, $cursor, $length);
                $cursor->blockScalarChomping = '-' === $char ? BlockScalarChomping::Strip : BlockScalarChomping::Keep;

                return new Token(TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR, $char, $startLine, $startColumn);
            }
            if ($char >= '0' && $char <= '9') {
                $this->advance($input, $cursor, $length);
                $cursor->blockScalarExplicitIndentIndicator = true;

                return new Token(TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR, $char, $startLine, $startColumn);
            }
        }

        // SEQUENCE_ENTRY (-) - must check before plain scalar
        if ('-' === $char && $this->isSequenceEntry($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::SEQUENCE_ENTRY, '-', $startLine, $startColumn);
        }

        // EXPLICIT_KEY_INDICATOR (?)
        if ('?' === $char && $this->isMappingKey($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::EXPLICIT_KEY_INDICATOR, '?', $startLine, $startColumn);
        }

        // VALUE_INDICATOR (:)
        if (':' === $char && $this->isMappingValue($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::VALUE_INDICATOR, ':', $startLine, $startColumn);
        }

        // ANCHOR (&name)
        if ('&' === $char) {
            $anchor = '&'.$this->readAnchorOrAlias($input, $cursor, $length);

            return new Token(TokenType::ANCHOR, $anchor, $startLine, $startColumn);
        }

        // ALIAS (*name)
        if ('*' === $char) {
            $alias = '*'.$this->readAnchorOrAlias($input, $cursor, $length);

            return new Token(TokenType::ALIAS, $alias, $startLine, $startColumn);
        }

        // TAG (!...)
        if ('!' === $char) {
            $tag = $this->readTag($input, $cursor, $length);

            return new Token(TokenType::TAG, $tag, $startLine, $startColumn);
        }

        // FOLDED BLOCK SCALAR (>)
        if ('>' === $char && $this->isBlockScalarStart($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);
            $cursor->inBlockScalarHeaderLine = true;
            $cursor->blockScalarBodyTokenType = TokenType::FOLDED_BLOCK_SCALAR;
            $cursor->blockScalarChomping = null;
            $cursor->blockScalarExplicitIndentIndicator = false;

            return new Token(TokenType::FOLDED_BLOCK_SCALAR_INDICATOR, $char, $startLine, $startColumn);
        }

        // LITERAL BLOCK SCALAR (|)
        if ('|' === $char && $this->isBlockScalarStart($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);
            $cursor->inBlockScalarHeaderLine = true;
            $cursor->blockScalarBodyTokenType = TokenType::LITERAL_BLOCK_SCALAR;
            $cursor->blockScalarChomping = null;
            $cursor->blockScalarExplicitIndentIndicator = false;

            return new Token(TokenType::LITERAL_BLOCK_SCALAR_INDICATOR, $char, $startLine, $startColumn);
        }

        // PLAIN_SCALAR
        $plain = $this->readPlainScalar($input, $cursor, $length);
        if ('' !== $plain) {
            return new Token(TokenType::PLAIN_SCALAR, $plain, $startLine, $startColumn);
        }

        $text = $this->consumeCodePoint($input, $cursor, $length);

        return new Token(TokenType::UNRECOGNIZED, $text, $startLine, $startColumn);
    }

    private function advance(string $input, Cursor $cursor, int $length): void
    {
        if ($cursor->position >= $length) {
            return;
        }
        if ("\n" === $input[$cursor->position]) {
            ++$cursor->line;
            $cursor->column = 1;
            ++$cursor->position;

            return;
        }
        $width = $this->utf8CodePointByteWidth($input, $cursor->position, $length);
        $cursor->position += $width;
        ++$cursor->column;
    }

    /**
     * UTF-8 byte length of the code point starting at $position, without validating continuation bytes.
     * If the sequence is truncated or the leading byte is invalid, returns 1.
     */
    private function utf8CodePointByteWidth(string $input, int $position, int $length): int
    {
        if ($position >= $length) {
            return 0;
        }
        $byte = \ord($input[$position]);
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
        if ($length - $position < $expected) {
            return 1;
        }

        return $expected;
    }

    private function codePointFragmentAt(string $input, int $position, int $length): string
    {
        if ($position >= $length) {
            return '';
        }
        if ("\n" === $input[$position]) {
            return "\n";
        }
        $width = $this->utf8CodePointByteWidth($input, $position, $length);

        return substr($input, $position, $width);
    }

    private function consumeCodePoint(string $input, Cursor $cursor, int $length): string
    {
        $fragment = $this->codePointFragmentAt($input, $cursor->position, $length);
        $this->advance($input, $cursor, $length);

        return $fragment;
    }

    private function match(string $input, Cursor $cursor, int $length, string $str): bool
    {
        $len = \strlen($str);
        if ($cursor->position + $len > $length) {
            return false;
        }
        if (substr($input, $cursor->position, $len) !== $str) {
            return false;
        }
        for ($i = 0; $i < $len; ++$i) {
            $this->advance($input, $cursor, $length);
        }

        return true;
    }

    private function readIndentation(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if (' ' === $char) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                ++$cursor->currentIndent;
            } elseif ("\t" === $char) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                $cursor->currentIndent += self::INDENT_SIZE_TAB; // Tab as 4 spaces for indent tracking
            } else {
                break;
            }
        }

        return $result;
    }

    private function readWhitespace(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if (\in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            } else {
                break;
            }
        }

        return $result;
    }

    private function readUntilNewline(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if (\in_array($char, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            $result .= $this->consumeCodePoint($input, $cursor, $length);
        }

        return $result;
    }

    private function isSequenceEntry(string $input, Cursor $cursor, int $length): bool
    {
        $nextChar = $this->getNextChar($input, $cursor, $length);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_WHITESPACE, true);
    }

    private function isMappingKey(string $input, Cursor $cursor, int $length): bool
    {
        $nextChar = $this->getNextChar($input, $cursor, $length);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_WHITESPACE, true);
    }

    private function isMappingValue(string $input, Cursor $cursor, int $length): bool
    {
        $nextChar = $this->getNextChar($input, $cursor, $length);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_MAPPING_VALUE_SUFFIX, true);
    }

    /**
     * In YAML, "#" starts a comment only when separated from other tokens by whitespace.
     */
    private function isCommentStart(string $input, Cursor $cursor, int $length): bool
    {
        if ($cursor->position >= $length) {
            return false;
        }
        if ('#' !== $input[$cursor->position]) {
            return false;
        }
        if (0 === $cursor->position) {
            return true;
        }

        return \in_array($input[$cursor->position - 1], self::CHARS_WHITESPACE, true);
    }

    private function readAnchorOrAlias(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        $this->advance($input, $cursor, $length);
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if ($this->isAnchorChar($char)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
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

    private function readTag(string $input, Cursor $cursor, int $length): string
    {
        $result = '!';
        $this->advance($input, $cursor, $length);
        // Verbatim tag !<...>
        if ($cursor->position < $length && '<' === $input[$cursor->position]) {
            $result .= '<';
            $this->advance($input, $cursor, $length);
            while ($cursor->position < $length && '>' !== $input[$cursor->position]) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }
            if ($cursor->position < $length) {
                $result .= '>';
                $this->advance($input, $cursor, $length);
            }

            return $result;
        }
        // Shorthand tag
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if ($this->isTagChar($char)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            } else {
                break;
            }
        }

        return $result;
    }

    private function isTagChar(string $char): bool
    {
        return !\in_array($char, self::CHARS_ANCHOR_OR_TAG_FORBIDDEN, true);
    }

    private function readDoubleQuotedScalar(string $input, Cursor $cursor, int $length): string
    {
        $result = '"';
        $this->advance($input, $cursor, $length);
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if ('\\' === $char) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                if ($cursor->position < $length) {
                    $result .= $this->consumeCodePoint($input, $cursor, $length);
                }
            } elseif ('"' === $char) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                break;
            } else {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }
        }

        return $result;
    }

    private function readSingleQuotedScalar(string $input, Cursor $cursor, int $length): string
    {
        $result = "'";
        $this->advance($input, $cursor, $length);
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if ("'" === $char) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                if ($cursor->position < $length && "'" === $input[$cursor->position]) {
                    $result .= $this->consumeCodePoint($input, $cursor, $length);
                } else {
                    break;
                }
            } else {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }
        }

        return $result;
    }

    private function isBlockScalarStart(string $input, Cursor $cursor, int $length): bool
    {
        $nextChar = $this->getNextChar($input, $cursor, $length);
        if (null === $nextChar) {
            return true;
        }

        return \in_array($nextChar, self::CHARS_BLOCK_SCALAR_START, true);
    }

    private function readBlockScalarBody(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        $minIndent = null;

        while ($cursor->position < $length) {
            if (\in_array($input[$cursor->position], self::CHARS_LINE_BREAK, true)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                if ($cursor->position > 0 && "\r" === $input[$cursor->position - 1] && $cursor->position < $length && "\n" === $input[$cursor->position]) {
                    $result .= $this->consumeCodePoint($input, $cursor, $length);
                }

                continue;
            }

            $indentStart = $cursor->position;
            $lineIndent = 0;
            while ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                $lineIndent += "\t" === $input[$cursor->position] ? self::INDENT_SIZE_TAB : 1;
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }

            if ($cursor->position >= $length || \in_array($input[$cursor->position], self::CHARS_LINE_BREAK, true)) {
                continue;
            }

            if (null === $minIndent) {
                $minIndent = $lineIndent;
            }
            if ($lineIndent < $minIndent && '' !== $result && "\n" === substr($result, -1)) {
                $backtrack = $cursor->position - $indentStart;
                if ($backtrack > 0) {
                    $result = substr($result, 0, -$backtrack);
                    $cursor->position = $indentStart;
                    $cursor->column = max(1, $cursor->column - $backtrack);
                }
                break;
            }

            while ($cursor->position < $length && !\in_array($input[$cursor->position], self::CHARS_LINE_BREAK, true)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }
        }

        return $result;
    }

    private function readBlockScalarBodyToken(string $input, Cursor $cursor, int $length): Token
    {
        $type = $cursor->pendingBlockScalarBody;
        $cursor->pendingBlockScalarBody = null;
        $text = $this->readBlockScalarBodyAndApplyChomping($input, $cursor, $length);

        return new Token($type, $text, $cursor->line, $cursor->column);
    }

    private function readBlockScalarBodyAndApplyChomping(string $input, Cursor $cursor, int $length): string
    {
        $chomping = $cursor->blockScalarChomping ?? BlockScalarChomping::Clip;
        $text = $this->readBlockScalarBody($input, $cursor, $length);

        if (BlockScalarChomping::Strip === $chomping) {
            $suffixLen = $this->computeBlockScalarStripSuffixLength($text);
            if ($suffixLen > 0) {
                $text = substr($text, 0, -$suffixLen);
                $cursor->position -= $suffixLen;
                $this->syncCursorLineColumnFromPrefix($input, $cursor, $length);
            }
        }

        $cursor->blockScalarChomping = null;

        return $text;
    }

    /**
     * @return list<Token>
     */
    private function splitExplicitIndentBlockBodyToTokens(string $body): array
    {
        $tokens = [];
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
                $tokens[] = new Token(TokenType::INDENTATION, $indentBytes, 1, 1);
            }
            $rest = substr($line, $i);
            if ('' !== $rest) {
                $tokens[] = new Token(TokenType::PLAIN_SCALAR, $rest, 1, 1);
            }
            if (null === $nl) {
                break;
            }
            $tokens[] = new Token(TokenType::NEWLINE, substr($body, $nl['start'], $nl['len']), 1, 1);
            $offset = $nl['start'] + $nl['len'];
        }

        return $tokens;
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

    private function syncCursorLineColumnFromPrefix(string $input, Cursor $cursor, int $length): void
    {
        $pos = min($cursor->position, $length);
        $line = 1;
        $column = 1;
        $i = 0;
        while ($i < $pos) {
            $c = $input[$i];
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
                if ($i < $pos && "\n" === $input[$i]) {
                    ++$i;
                }

                continue;
            }
            $w = $this->utf8CodePointByteWidth($input, $i, $length);
            ++$column;
            $i += $w;
        }
        $cursor->line = $line;
        $cursor->column = $column;
    }

    private function readPlainScalar(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if (':' === $char && $this->isMappingValue($input, $cursor, $length)) {
                break;
            }
            if ('?' === $char && $this->isMappingKey($input, $cursor, $length)) {
                break;
            }
            if ('#' === $char && $this->isCommentStart($input, $cursor, $length)) {
                break;
            }
            if ((']' === $char || '}' === $char) && '' !== $result) {
                $nextChar = $this->getNextChar($input, $cursor, $length);
                if (null === $nextChar
                    || \in_array($nextChar, self::CHARS_WHITESPACE, true)
                    || \in_array($nextChar, [',', ']', '}', "\n", "\r"], true)) {
                    break;
                }
                $result .= $this->consumeCodePoint($input, $cursor, $length);

                continue;
            }
            if (('[' === $char || '{' === $char) && '' === $result) {
                break;
            }
            if (\in_array($char, self::CHARS_PLAIN_SCALAR_STOP, true)) {
                break;
            }
            if (\in_array($char, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                $peek = $cursor->position + 1;
                while ($peek < $length && \in_array($input[$peek], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                    ++$peek;
                }
                if ($peek >= $length
                    || \in_array($input[$peek], self::CHARS_LINE_BREAK, true)
                    || '#' === $input[$peek]
                    || \in_array($input[$peek], [',', ']', '}', '[', '{'], true)) {
                    break;
                }
            }
            $result .= $this->consumeCodePoint($input, $cursor, $length);
        }

        return $result;
    }
}
