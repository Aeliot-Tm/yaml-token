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

namespace Aeliot\YamlToken\Parser\Helper;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;

final readonly class MultilineContinuationHelper
{
    public function __construct(
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    public function isAnyContinuationAt(TokenStreamProxy $tokens, int $offset, int $parentIndentLen): bool
    {
        return $this->isIndentedMultilinePlainContinuationAt($tokens, $offset, $parentIndentLen)
            || (
                EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen
                && $this->isBareDocumentFlushMultilinePlainContinuationAt($tokens, $offset)
            );
    }

    public function isBareDocumentFlushMultilinePlainContinuationAt(TokenStreamProxy $tokens, int $scalarPeekOffset): bool
    {
        $offset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $scalarPeekOffset);
        $scalarToken = $tokens->peek($offset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        return !$this->isImplicitYamlKeyOnContinuationLine($tokens, $offset);
    }

    /**
     * True when the token at peek offset $scalarPeekOffset is a scalar and the same
     * logical line contains ':' as implicit YAML key (nested block mapping entry).
     *
     * @see Parser::parseValue() Plain scalar continuation guard (~1633–1639)
     */
    public function isImplicitYamlKeyOnContinuationLine(TokenStreamProxy $tokens, int $scalarPeekOffset): bool
    {
        $offset = $scalarPeekOffset + 1;
        while (true) {
            $peeked = $tokens->peek($offset);
            if (null === $peeked || TokenType::NEWLINE === $peeked->type) {
                return false;
            }
            if (TokenType::WHITESPACE === $peeked->type) {
                ++$offset;
                continue;
            }

            return TokenType::VALUE_INDICATOR === $peeked->type;
        }
    }

    public function isIndentedMultilinePlainContinuationAt(TokenStreamProxy $tokens, int $indentPeekOffset, int $parentIndentLen): bool
    {
        $indentation = $tokens->peek($indentPeekOffset);
        if (TokenType::INDENTATION !== $indentation?->type) {
            return false;
        }
        if (\strlen($indentation->text) <= $parentIndentLen) {
            return false;
        }

        $scalarOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $indentPeekOffset + 1);
        $scalarToken = $tokens->peek($scalarOffset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        $keyProbe = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $scalarOffset + 1);

        return TokenType::VALUE_INDICATOR !== $tokens->peek($keyProbe)?->type;
    }

    /**
     * Whether at least one multiline plain-scalar continuation line follows the current PLAIN_SCALAR
     * (peek-only; does not consume tokens).
     *
     * @see MultilinePlainScalarParser::appendMultilinePlainScalarContinuations()
     */
    public function isMultilinePlainContinuationAhead(TokenStreamProxy $tokens, int $peekOffset, int $parentIndentLen): bool
    {
        $offset = $peekOffset;
        if (TokenType::WHITESPACE === $tokens->peek($offset)?->type) {
            if (TokenType::NEWLINE !== $tokens->peek($offset + 1)?->type) {
                return false;
            }
            ++$offset;
        }

        if (TokenType::NEWLINE !== $tokens->peek($offset)?->type) {
            return false;
        }

        if (TokenType::NEWLINE === $tokens->peek($offset + 1)?->type) {
            return $this->isAnyContinuationAt($tokens, $offset + 2, $parentIndentLen);
        }

        $maybeIndent = $tokens->peek($offset + 1);
        if (TokenType::INDENTATION === $maybeIndent?->type && \strlen($maybeIndent->text) > $parentIndentLen) {
            $afterIndentOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $offset + 2);
            if (TokenType::NEWLINE === $tokens->peek($afterIndentOffset)?->type) {
                return $this->isAnyContinuationAt($tokens, $afterIndentOffset + 1, $parentIndentLen);
            }
        }

        return $this->isAnyContinuationAt($tokens, $offset + 1, $parentIndentLen);
    }
}
