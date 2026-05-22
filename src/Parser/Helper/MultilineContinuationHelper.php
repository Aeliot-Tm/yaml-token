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
    public function isBareDocumentFlushMultilinePlainContinuationAt(TokenStreamProxy $tokens, int $scalarPeekOffset): bool
    {
        $offset = $scalarPeekOffset;
        while (TokenType::WHITESPACE === $tokens->peek($offset)?->type) {
            ++$offset;
        }
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

        $scalarOffset = $indentPeekOffset + 1;
        while (TokenType::WHITESPACE === $tokens->peek($scalarOffset)?->type) {
            ++$scalarOffset;
        }
        $scalarToken = $tokens->peek($scalarOffset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        $keyProbe = $scalarOffset + 1;
        while (TokenType::WHITESPACE === $tokens->peek($keyProbe)?->type) {
            ++$keyProbe;
        }

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
            return $this->isIndentedMultilinePlainContinuationAt($tokens, $offset + 2, $parentIndentLen)
                || (
                    EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen
                    && $this->isBareDocumentFlushMultilinePlainContinuationAt($tokens, $offset + 2)
                );
        }

        $maybeIndent = $tokens->peek($offset + 1);
        if (TokenType::INDENTATION === $maybeIndent?->type && \strlen($maybeIndent->text) > $parentIndentLen) {
            $afterIndentOffset = $offset + 2;
            while (TokenType::WHITESPACE === $tokens->peek($afterIndentOffset)?->type) {
                ++$afterIndentOffset;
            }
            if (TokenType::NEWLINE === $tokens->peek($afterIndentOffset)?->type) {
                return $this->isIndentedMultilinePlainContinuationAt($tokens, $afterIndentOffset + 1, $parentIndentLen)
                    || (
                        EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen
                        && $this->isBareDocumentFlushMultilinePlainContinuationAt($tokens, $afterIndentOffset + 1)
                    );
            }
        }

        return $this->isIndentedMultilinePlainContinuationAt($tokens, $offset + 1, $parentIndentLen)
            || (
                EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen
                && $this->isBareDocumentFlushMultilinePlainContinuationAt($tokens, $offset + 1)
            );
    }
}
