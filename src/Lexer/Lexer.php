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
use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Lexer
{
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
        $stream = new TokenStream();
        $cursor = new Cursor();

        $length = \strlen($input);

        while ($cursor->position < $length) {
            $token = $this->readToken($input, $cursor, $length);
            if (null !== $token) {
                $stream->addToken($token);
            }
        }

        return $stream;
    }

    private function readToken(string $input, Cursor $cursor, int $length): ?Token
    {
        $char = $input[$cursor->position];
        $startLine = $cursor->line;
        $startColumn = $cursor->column;

        // NEWLINE (CRLF, CR, LF)
        if ("\r" === $char) {
            $this->advance($input, $cursor, $length);
            if ($cursor->position < $length && "\n" === $input[$cursor->position]) {
                $this->advance($input, $cursor, $length);

                return new Token(TokenType::NEWLINE, "\r\n", $startLine, $startColumn);
            }

            return new Token(TokenType::NEWLINE, "\r", $startLine, $startColumn);
        }
        if ("\n" === $char) {
            $this->advance($input, $cursor, $length);
            $cursor->currentIndent = 0;

            return new Token(TokenType::NEWLINE, "\n", $startLine, $startColumn);
        }

        // INDENTATION (spaces at line start, after newline)
        if (1 === $cursor->column && (' ' === $char || "\t" === $char)) {
            $indent = $this->readIndentation($input, $cursor, $length);
            if ('' !== $indent) {
                return new Token(TokenType::INDENTATION, $indent, $startLine, $startColumn);
            }
        }

        // WHITESPACE (within line)
        if (' ' === $char || "\t" === $char) {
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
        if ('#' === $char) {
            $this->advance($input, $cursor, $length);
            $comment = '#'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::COMMENT, $comment, $startLine, $startColumn);
        }

        // YAML_DIRECTIVE (%YAML ...)
        if ($this->match($input, $cursor, $length, '%YAML')) {
            $directive = '%YAML'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::YAML_DIRECTIVE, $directive, $startLine, $startColumn);
        }

        // TAG_DIRECTIVE (%TAG ...)
        if ($this->match($input, $cursor, $length, '%TAG')) {
            $directive = '%TAG'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::TAG_DIRECTIVE, $directive, $startLine, $startColumn);
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

        // SEQUENCE_ENTRY (-) - must check before plain scalar
        if ('-' === $char && $this->isSequenceEntry($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::SEQUENCE_ENTRY, '-', $startLine, $startColumn);
        }

        // MAPPING_KEY (?)
        if ('?' === $char && $this->isMappingKey($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::MAPPING_KEY, '?', $startLine, $startColumn);
        }

        // MAPPING_VALUE (:)
        if (':' === $char && $this->isMappingValue($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::MAPPING_VALUE, ':', $startLine, $startColumn);
        }

        // ANCHOR (&name)
        if ('&' === $char) {
            $anchor = $this->readAnchor($input, $cursor, $length);

            return new Token(TokenType::ANCHOR, $anchor, $startLine, $startColumn);
        }

        // ALIAS (*name)
        if ('*' === $char) {
            $alias = $this->readAlias($input, $cursor, $length);

            return new Token(TokenType::ALIAS, $alias, $startLine, $startColumn);
        }

        // TAG (!...)
        if ('!' === $char) {
            $tag = $this->readTag($input, $cursor, $length);

            return new Token(TokenType::TAG, $tag, $startLine, $startColumn);
        }

        // BLOCK SCALAR (| or >)
        if (('|' === $char || '>' === $char) && $this->isBlockScalarStart($input, $cursor, $length)) {
            $scalar = '|' === $char
                ? $this->readLiteralBlockScalar($input, $cursor, $length)
                : $this->readFoldedBlockScalar($input, $cursor, $length);
            $type = '|' === $char ? TokenType::LITERAL_BLOCK_SCALAR : TokenType::FOLDED_BLOCK_SCALAR;

            return new Token($type, $scalar, $startLine, $startColumn);
        }

        // PLAIN_SCALAR
        $plain = $this->readPlainScalar($input, $cursor, $length);
        if ('' !== $plain) {
            return new Token(TokenType::PLAIN_SCALAR, $plain, $startLine, $startColumn);
        }

        // Unknown character - advance to avoid infinite loop
        $this->advance($input, $cursor, $length);

        return null;
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
                $cursor->currentIndent += 4; // Tab as 4 spaces for indent tracking
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
            if (' ' === $char || "\t" === $char) {
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
            if ("\n" === $char || "\r" === $char) {
                break;
            }
            $result .= $this->consumeCodePoint($input, $cursor, $length);
        }

        return $result;
    }

    private function isSequenceEntry(string $input, Cursor $cursor, int $length): bool
    {
        $next = $cursor->position + 1;
        if ($next >= $length) {
            return true;
        }
        $nextChar = $input[$next];

        return ' ' === $nextChar || "\t" === $nextChar || "\n" === $nextChar || "\r" === $nextChar;
    }

    private function isMappingKey(string $input, Cursor $cursor, int $length): bool
    {
        $next = $cursor->position + 1;
        if ($next >= $length) {
            return true;
        }
        $nextChar = $input[$next];

        return ' ' === $nextChar || "\t" === $nextChar || "\n" === $nextChar || "\r" === $nextChar;
    }

    private function isMappingValue(string $input, Cursor $cursor, int $length): bool
    {
        $next = $cursor->position + 1;
        if ($next >= $length) {
            return true;
        }
        $nextChar = $input[$next];

        return ' ' === $nextChar || "\t" === $nextChar || "\n" === $nextChar || "\r" === $nextChar
            || '#' === $nextChar || '[' === $nextChar || '{' === $nextChar || '"' === $nextChar || "'" === $nextChar;
    }

    private function readAnchor(string $input, Cursor $cursor, int $length): string
    {
        $result = '&';
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

    private function readAlias(string $input, Cursor $cursor, int $length): string
    {
        $result = '*';
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
        return ' ' !== $char && "\t" !== $char && "\n" !== $char && "\r" !== $char
            && '[' !== $char && ']' !== $char && '{' !== $char && '}' !== $char && ',' !== $char
            && ':' !== $char && '#' !== $char && "\0" !== $char;
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
        return ' ' !== $char && "\t" !== $char && "\n" !== $char && "\r" !== $char
            && '[' !== $char && ']' !== $char && '{' !== $char && '}' !== $char && ',' !== $char
            && ':' !== $char && '#' !== $char && "\0" !== $char;
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
        $next = $cursor->position + 1;
        if ($next >= $length) {
            return true;
        }
        $nextChar = $input[$next];

        return ' ' === $nextChar || "\t" === $nextChar || "\n" === $nextChar || "\r" === $nextChar
            || '+' === $nextChar || '-' === $nextChar;
    }

    private function readLiteralBlockScalar(string $input, Cursor $cursor, int $length): string
    {
        $result = $this->readBlockScalarHeader($input, $cursor, $length);
        $minIndent = null;

        while ($cursor->position < $length) {
            if ("\n" === $input[$cursor->position] || "\r" === $input[$cursor->position]) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                if ($cursor->position > 0 && "\r" === $input[$cursor->position - 1] && $cursor->position < $length && "\n" === $input[$cursor->position]) {
                    $result .= $this->consumeCodePoint($input, $cursor, $length);
                }
                continue;
            }

            $indentStart = $cursor->position;
            $lineIndent = 0;
            while ($cursor->position < $length && (' ' === $input[$cursor->position] || "\t" === $input[$cursor->position])) {
                $lineIndent += "\t" === $input[$cursor->position] ? 4 : 1;
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }

            if ($cursor->position >= $length || "\n" === $input[$cursor->position] || "\r" === $input[$cursor->position]) {
                continue;
            }

            if (null === $minIndent) {
                $minIndent = $lineIndent;
            }
            if ($lineIndent < $minIndent && '' !== $result && "\n" === substr($result, -1)) {
                $backtrack = $cursor->position - $indentStart;
                $result = substr($result, 0, -$backtrack);
                $cursor->position = $indentStart;
                $cursor->column = max(1, $cursor->column - $backtrack);
                break;
            }

            while ($cursor->position < $length && "\n" !== $input[$cursor->position] && "\r" !== $input[$cursor->position]) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            }
        }

        return $result;
    }

    private function readBlockScalarHeader(string $input, Cursor $cursor, int $length): string
    {
        $result = $this->consumeCodePoint($input, $cursor, $length);
        while ($cursor->position < $length && "\n" !== $input[$cursor->position] && "\r" !== $input[$cursor->position]) {
            $result .= $this->consumeCodePoint($input, $cursor, $length);
        }

        return $result;
    }

    private function readFoldedBlockScalar(string $input, Cursor $cursor, int $length): string
    {
        return $this->readLiteralBlockScalar($input, $cursor, $length);
    }

    private function readPlainScalar(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if ("\n" === $char || "\r" === $char || ':' === $char || '#' === $char || '[' === $char || ']' === $char
                || '{' === $char || '}' === $char || ',' === $char || '?' === $char) {
                break;
            }
            if (' ' === $char || "\t" === $char) {
                $peek = $cursor->position + 1;
                while ($peek < $length && (' ' === $input[$peek] || "\t" === $input[$peek])) {
                    ++$peek;
                }
                if ($peek >= $length || "\n" === $input[$peek] || "\r" === $input[$peek] || '#' === $input[$peek]) {
                    break;
                }
            }
            $result .= $this->consumeCodePoint($input, $cursor, $length);
        }

        return $result;
    }
}
