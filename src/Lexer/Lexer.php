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

            if ($this->shouldTokenizeYamlDirectiveAsParts($input, $cursor, $length)) {
                foreach ($this->tokenizeYamlDirectiveLine($input, $cursor, $length) as $yamlDirectiveToken) {
                    $stream->addToken($yamlDirectiveToken);
                }

                continue;
            }

            if ($this->shouldTokenizeTagDirectiveAsParts($input, $cursor, $length)) {
                foreach ($this->tokenizeTagDirectiveLine($input, $cursor, $length) as $tagDirectiveToken) {
                    $stream->addToken($tagDirectiveToken);
                }

                continue;
            }

            // TAG (!...) — see {@see tokenizeExplicitTag} in {@see tokenize}
            if ($cursor->position < $length && '!' === $input[$cursor->position]) {
                foreach ($this->tokenizeExplicitTag($input, $cursor, $length) as $tagToken) {
                    $stream->addToken($tagToken);
                }

                continue;
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

        // DIRECTIVE_YAML (%YAML ...) — split into parts in {@see tokenizeYamlDirectiveLine} when applicable
        if ($this->match($input, $cursor, $length, '%YAML')) {
            $directive = '%YAML'.$this->readUntilNewline($input, $cursor, $length);

            return new Token(TokenType::DIRECTIVE_YAML, $directive, $startLine, $startColumn);
        }

        // DIRECTIVE_TAG (%TAG ...) — split into parts in {@see tokenizeTagDirectiveLine} when applicable
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

        // MERGE_INDICATOR (YAML 1.1 merge key << before :)
        if ($this->isMergeKeyPlainSequence($input, $cursor, $length)) {
            $this->advance($input, $cursor, $length);
            $this->advance($input, $cursor, $length);

            return new Token(TokenType::MERGE_INDICATOR, '<<', $startLine, $startColumn);
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

    /**
     * Split `%YAML` lines into `DIRECTIVE_YAML`, `DIRECTIVE_YAML_VERSION` when the keyword is followed by horizontal
     * whitespace, `:`, or a digit (version). Otherwise the whole line suffix stays on `DIRECTIVE_YAML` (see
     * {@see readToken}).
     */
    private function shouldTokenizeYamlDirectiveAsParts(string $input, Cursor $cursor, int $length): bool
    {
        if ($cursor->position + 5 > $length) {
            return false;
        }
        if ('%YAML' !== substr($input, $cursor->position, 5)) {
            return false;
        }
        if ($cursor->position + 5 >= $length) {
            return false;
        }
        $after = $input[$cursor->position + 5];
        if (\in_array($after, self::CHARS_HORIZONTAL_WHITESPACE, true) || ':' === $after) {
            return true;
        }

        return ctype_digit($after);
    }

    /**
     * @return list<Token>
     */
    private function tokenizeYamlDirectiveLine(string $input, Cursor $cursor, int $length): array
    {
        $tokens = [];
        $directiveYamlLine = $cursor->line;
        $directiveYamlColumn = $cursor->column;
        if (!$this->match($input, $cursor, $length, '%YAML')) {
            return [];
        }
        $tokens[] = new Token(TokenType::DIRECTIVE_YAML, '%YAML', $directiveYamlLine, $directiveYamlColumn);

        if ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $cursor->line;
            $wsColumn = $cursor->column;
            $ws = $this->readWhitespace($input, $cursor, $length);
            $tokens[] = new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn);
        }

        if ($cursor->position < $length && ':' === $input[$cursor->position]) {
            $colonLine = $cursor->line;
            $colonColumn = $cursor->column;
            $this->advance($input, $cursor, $length);
            $tokens[] = new Token(TokenType::VALUE_INDICATOR, ':', $colonLine, $colonColumn);
        }

        if ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $cursor->line;
            $wsColumn = $cursor->column;
            $ws = $this->readWhitespace($input, $cursor, $length);
            $tokens[] = new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn);
        }

        $versionLine = $cursor->line;
        $versionColumn = $cursor->column;
        $version = $this->readYamlDirectiveVersion($input, $cursor, $length);
        $tokens[] = new Token(TokenType::DIRECTIVE_YAML_VERSION, $version, $versionLine, $versionColumn);

        if ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $cursor->line;
            $wsColumn = $cursor->column;
            $ws = $this->readWhitespace($input, $cursor, $length);
            $tokens[] = new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn);
        }

        if ($cursor->position < $length && '#' === $input[$cursor->position] && $this->isCommentStart($input, $cursor, $length)) {
            $commentLine = $cursor->line;
            $commentColumn = $cursor->column;
            $this->advance($input, $cursor, $length);
            $comment = '#'.$this->readUntilNewline($input, $cursor, $length);
            $tokens[] = new Token(TokenType::COMMENT, $comment, $commentLine, $commentColumn);
        }

        return $tokens;
    }

    private function readYamlDirectiveVersion(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $c = $input[$cursor->position];
            if (\in_array($c, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            if (\in_array($c, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                break;
            }
            if ('#' === $c && $this->isCommentStart($input, $cursor, $length)) {
                break;
            }
            $result .= $this->consumeCodePoint($input, $cursor, $length);
        }

        return $result;
    }

    /**
     * Split `%TAG` lines into `DIRECTIVE_TAG`, `DIRECTIVE_TAG_HANDLE`, `DIRECTIVE_TAG_PREFIX` only when the keyword
     * is followed by a handle (starts with `!`) or horizontal whitespace / EOF — not when followed immediately by a
     * line break (whole-line token as before).
     */
    private function shouldTokenizeTagDirectiveAsParts(string $input, Cursor $cursor, int $length): bool
    {
        if ($cursor->position + 4 > $length) {
            return false;
        }
        if ('%TAG' !== substr($input, $cursor->position, 4)) {
            return false;
        }
        if ($cursor->position + 4 >= $length) {
            return true;
        }
        $after = $input[$cursor->position + 4];

        return \in_array($after, self::CHARS_HORIZONTAL_WHITESPACE, true) || '!' === $after;
    }

    /**
     * @return list<Token>
     */
    private function tokenizeTagDirectiveLine(string $input, Cursor $cursor, int $length): array
    {
        $tokens = [];
        $directiveTagLine = $cursor->line;
        $directiveTagColumn = $cursor->column;
        if (!$this->match($input, $cursor, $length, '%TAG')) {
            return [];
        }
        $tokens[] = new Token(TokenType::DIRECTIVE_TAG, '%TAG', $directiveTagLine, $directiveTagColumn);

        if ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $cursor->line;
            $wsColumn = $cursor->column;
            $ws = $this->readWhitespace($input, $cursor, $length);
            $tokens[] = new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn);
        }

        $handleLine = $cursor->line;
        $handleColumn = $cursor->column;
        $handle = $this->readTagDirectiveHandle($input, $cursor, $length);
        $tokens[] = new Token(TokenType::DIRECTIVE_TAG_HANDLE, $handle, $handleLine, $handleColumn);

        if ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $cursor->line;
            $wsColumn = $cursor->column;
            $ws = $this->readWhitespace($input, $cursor, $length);
            $tokens[] = new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn);
        }

        $prefixLine = $cursor->line;
        $prefixColumn = $cursor->column;
        $prefix = $this->readTagDirectivePrefix($input, $cursor, $length);
        $tokens[] = new Token(TokenType::DIRECTIVE_TAG_PREFIX, $prefix, $prefixLine, $prefixColumn);

        if ($cursor->position < $length && \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            $wsLine = $cursor->line;
            $wsColumn = $cursor->column;
            $ws = $this->readWhitespace($input, $cursor, $length);
            $tokens[] = new Token(TokenType::WHITESPACE, $ws, $wsLine, $wsColumn);
        }

        if ($cursor->position < $length && '#' === $input[$cursor->position] && $this->isCommentStart($input, $cursor, $length)) {
            $commentLine = $cursor->line;
            $commentColumn = $cursor->column;
            $this->advance($input, $cursor, $length);
            $comment = '#'.$this->readUntilNewline($input, $cursor, $length);
            $tokens[] = new Token(TokenType::COMMENT, $comment, $commentLine, $commentColumn);
        }

        return $tokens;
    }

    private function readTagDirectiveHandle(string $input, Cursor $cursor, int $length): string
    {
        if ($cursor->position >= $length || '!' !== $input[$cursor->position]) {
            return '';
        }
        $this->advance($input, $cursor, $length);
        if ($cursor->position < $length && '!' === $input[$cursor->position]) {
            $this->advance($input, $cursor, $length);

            return '!!';
        }
        if ($cursor->position >= $length || \in_array($input[$cursor->position], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            return '!';
        }
        $savedPosition = $cursor->position;
        $savedLine = $cursor->line;
        $savedColumn = $cursor->column;
        $middle = '';
        while ($cursor->position < $length) {
            $c = $input[$cursor->position];
            if ('!' === $c) {
                $this->advance($input, $cursor, $length);

                return '!'.$middle.'!';
            }
            if (\in_array($c, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                break;
            }
            if (!$this->isTagChar($c)) {
                break;
            }
            $middle .= $this->consumeCodePoint($input, $cursor, $length);
        }
        $cursor->position = $savedPosition;
        $cursor->line = $savedLine;
        $cursor->column = $savedColumn;

        return '!';
    }

    private function readTagDirectivePrefix(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $c = $input[$cursor->position];
            if (\in_array($c, self::CHARS_LINE_BREAK, true)) {
                break;
            }
            if (\in_array($c, self::CHARS_HORIZONTAL_WHITESPACE, true)) {
                break;
            }
            if ('#' === $c && $this->isCommentStart($input, $cursor, $length)) {
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
        return $this->isColonMappingValueIndicator($input, $cursor->position, $length);
    }

    /**
     * ':' introduces a mapping value when the byte at $colonPosition is ':' and the following byte, if any,
     * matches {@see self::CHARS_MAPPING_VALUE_SUFFIX} or end of input.
     */
    private function isColonMappingValueIndicator(string $input, int $colonPosition, int $length): bool
    {
        if ($colonPosition >= $length || ':' !== $input[$colonPosition]) {
            return false;
        }
        $afterColon = $colonPosition + 1;
        if ($afterColon >= $length) {
            return true;
        }

        return \in_array($input[$afterColon], self::CHARS_MAPPING_VALUE_SUFFIX, true);
    }

    /**
     * Plain sequence «<<» for the YAML 1.1 merge key: only when followed by optional horizontal whitespace and ':' as a value indicator.
     */
    private function isMergeKeyPlainSequence(string $input, Cursor $cursor, int $length): bool
    {
        if ($cursor->position + 2 > $length) {
            return false;
        }
        if ('<' !== $input[$cursor->position] || '<' !== $input[$cursor->position + 1]) {
            return false;
        }
        $pos = $cursor->position + 2;
        while ($pos < $length && \in_array($input[$pos], self::CHARS_HORIZONTAL_WHITESPACE, true)) {
            ++$pos;
        }
        if ($pos >= $length) {
            return false;
        }

        return $this->isColonMappingValueIndicator($input, $pos, $length);
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

    /**
     * Explicit tag property at a node: `!<...>` verbatim, shorthand (`!`, `!!`, `!name!`) + suffix, or non-specific `!`.
     * Does not apply to `%TAG` directive lines (handled in {@see tokenizeTagDirectiveLine}).
     *
     * @return list<Token>
     */
    private function tokenizeExplicitTag(string $input, Cursor $cursor, int $length): array
    {
        $bangLine = $cursor->line;
        $bangColumn = $cursor->column;
        $this->advance($input, $cursor, $length);

        if ($cursor->position >= $length) {
            return [new Token(TokenType::TAG_NON_SPECIFIC, '!', $bangLine, $bangColumn)];
        }

        $next = $input[$cursor->position];

        if ('<' === $next) {
            $openLine = $cursor->line;
            $openColumn = $cursor->column;
            $this->advance($input, $cursor, $length);

            $bodyLine = $cursor->line;
            $bodyColumn = $cursor->column;
            $body = '';
            while ($cursor->position < $length && '>' !== $input[$cursor->position]) {
                $body .= $this->consumeCodePoint($input, $cursor, $length);
            }
            $closeLine = $cursor->line;
            $closeColumn = $cursor->column;
            $closeText = '';
            if ($cursor->position < $length && '>' === $input[$cursor->position]) {
                $closeText = '>';
                $this->advance($input, $cursor, $length);
            }

            return [
                new Token(TokenType::TAG_VERBATIM_INDICATOR, '!', $bangLine, $bangColumn),
                new Token(TokenType::TAG_VERBATIM_OPEN, '<', $openLine, $openColumn),
                new Token(TokenType::TAG_BODY, $body, $bodyLine, $bodyColumn),
                new Token(TokenType::TAG_VERBATIM_CLOSE, $closeText, $closeLine, $closeColumn),
            ];
        }

        if ('!' === $next) {
            $this->advance($input, $cursor, $length);
            $suffixLine = $cursor->line;
            $suffixColumn = $cursor->column;
            $suffix = $this->readTagShorthandSuffix($input, $cursor, $length);

            return [
                new Token(TokenType::TAG_HANDLE_SECONDARY, '!!', $bangLine, $bangColumn),
                new Token(TokenType::TAG_BODY, $suffix, $suffixLine, $suffixColumn),
            ];
        }

        $firstBangPos = $cursor->position - 1;
        $nameStart = $cursor->position;
        $j = $nameStart;
        while ($j < $length && $this->isTagHandleNameChar($input[$j])) {
            ++$j;
        }
        if ($j < $length && '!' === $input[$j] && $j > $nameStart) {
            $handleEnd = $j;
            while ($cursor->position <= $handleEnd) {
                $this->advance($input, $cursor, $length);
            }
            $handleText = substr($input, $firstBangPos, $handleEnd - $firstBangPos + 1);
            $suffixLine = $cursor->line;
            $suffixColumn = $cursor->column;
            $suffix = $this->readTagShorthandSuffix($input, $cursor, $length);

            return [
                new Token(TokenType::TAG_HANDLE_NAMED, $handleText, $bangLine, $bangColumn),
                new Token(TokenType::TAG_BODY, $suffix, $suffixLine, $suffixColumn),
            ];
        }

        $suffixLine = $cursor->line;
        $suffixColumn = $cursor->column;
        $suffix = $this->readTagShorthandSuffix($input, $cursor, $length);
        if ('' === $suffix) {
            return [new Token(TokenType::TAG_NON_SPECIFIC, '!', $bangLine, $bangColumn)];
        }

        return [
            new Token(TokenType::TAG_HANDLE_PRIMARY, '!', $bangLine, $bangColumn),
            new Token(TokenType::TAG_BODY, $suffix, $suffixLine, $suffixColumn),
        ];
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

    private function readTagShorthandSuffix(string $input, Cursor $cursor, int $length): string
    {
        $result = '';
        while ($cursor->position < $length) {
            $char = $input[$cursor->position];
            if (',' === $char && $this->tagCommaStartsRegistrationYear($input, $cursor->position, $length)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
                for ($i = 0; $i < 4; ++$i) {
                    $result .= $this->consumeCodePoint($input, $cursor, $length);
                }

                continue;
            }
            if ($this->isTagChar($char)) {
                $result .= $this->consumeCodePoint($input, $cursor, $length);
            } else {
                break;
            }
        }

        return $result;
    }

    /**
     * After "!", comma + four ASCII digits begin the registration date in global tag shorthand (YAML 1.0 style).
     */
    private function tagCommaStartsRegistrationYear(string $input, int $commaPosition, int $length): bool
    {
        if ($commaPosition + 5 > $length) {
            return false;
        }
        for ($i = 1; $i <= 4; ++$i) {
            if (!ctype_digit($input[$commaPosition + $i])) {
                return false;
            }
        }

        return true;
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
