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
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;

final readonly class BlockCollectionLoopHelper
{
    public function __construct(
        private Consumer $consumer,
        private IndentationHelper $indentationHelper,
        private LookAheadHelper $lookAheadHelper,
    ) {
    }

    /**
     * Advances past layout tokens (space, comments, insignificant indentation lines) and
     * returns the indent length of the next block entry, or null when the loop should break.
     *
     * Encapsulates the shared scaffolding of block-collection main loops:
     *   1. peek → break if out-of-scope (no significant head or indent ≤ $parentIndentLen)
     *   2. collectSpaceCommentEnds + collectInsignificantIndentationLines
     *   3. determine $indentLen from INDENTATION token or BARE_DOCUMENT_BLOCK_PARENT zero-indent
     *   4. registerIndentStepIfNeeded + assertIndentLenIsValid for $indentLen > 0
     *   5. break if $indentLen ≤ $parentIndentLen
     *
     * After a non-null return, $parseContext->tokens->current() still points at the same
     * token that was used to determine $indentLen (INDENTATION or the entry token itself).
     *
     * @param callable(ParseContext): bool $isBareDocumentEntry
     *                                                          Called only when $parentIndentLen equals EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT
     *                                                          and the current token is not INDENTATION. Should return true when the token at the
     *                                                          current stream position is a valid zero-indent entry for this collection type.
     *
     * @return int|null indent length of the next entry, or null to signal "break the loop"
     */
    public function advanceToNextBlockEntry(
        ParseContext $parseContext,
        Node $collection,
        int $parentIndentLen,
        callable $isBareDocumentEntry,
    ): ?int {
        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 0);
        if (null === $head || $head->indentLen <= $parentIndentLen) {
            return null;
        }

        $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $collection);
        $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $collection);

        $token = $parseContext->tokens->current();
        if (null === $token) {
            return null;
        }

        if (TokenType::INDENTATION === $token->type) {
            $indentLen = \strlen($token->text);
        } elseif (
            EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen
            && $isBareDocumentEntry($parseContext)
        ) {
            $indentLen = 0;
        } else {
            return null;
        }

        if ($indentLen > 0) {
            $this->indentationHelper->registerIndentStepIfNeeded($parseContext->state, $parseContext->tokens, $indentLen);
            $this->indentationHelper->assertIndentLenIsValid($parseContext->state, $parseContext->tokens, $indentLen);
        }

        if ($indentLen <= $parentIndentLen) {
            return null;
        }

        return $indentLen;
    }
}
