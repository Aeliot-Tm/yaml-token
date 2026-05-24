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
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\IndentationOverrideException;
use Aeliot\YamlToken\Parser\Exception\IndentationUndefinedException;
use Aeliot\YamlToken\Parser\SubParser\Consumer;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class BlockCollectionLoopHelper
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private LookAheadHelper $lookAheadHelper,
    ) {
    }

    /**
     * Advances past layout tokens and checks that the next entry is at exactly $indentLen.
     *
     * Compact-collection variant of advanceToNextBlockEntry: uses strict equality for
     * the indentation check and skips registerIndentStepIfNeeded/assertIndentLenIsValid
     * because the step was already registered when the first entry was parsed.
     *
     * After a true return, $parseContext->tokens->current() points at the INDENTATION
     * token whose length equals $indentLen.
     *
     * @return bool true when the loop should continue, false when it should break
     */
    public function advanceToNextCompactBlockEntry(
        ParseContext $parseContext,
        Node $collection,
        int $indentLen,
    ): bool {
        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 0);
        if (null === $head || $head->indentLen !== $indentLen) {
            return false;
        }

        $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $collection);
        $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $collection);

        $token = $parseContext->tokens->current();
        if (null === $token || TokenType::INDENTATION !== $token->type) {
            return false;
        }

        if (\strlen($token->text) !== $indentLen) {
            return false;
        }

        return true;
    }

    /**
     * Advances past layout tokens (space, comments, insignificant indentation lines) and
     * returns the indent length of the next block entry, or null when the loop should break.
     *
     * Encapsulates the shared scaffolding of block-collection main loops:
     *   1. peek → break if out-of-scope (no significant head or indent ≤ $parentIndent->indentLen)
     *   2. collectSpaceCommentEnds + collectInsignificantIndentationLines
     *   3. determine $indentLen from INDENTATION token or bare-document zero-indent
     *   4. registerIndentStepIfNeeded + assertIndentLenIsValid for $indentLen > 0
     *   5. break if $indentLen ≤ $parentIndent->indentLen
     *
     * After a non-null return, $parseContext->tokens->current() still points at the same
     * token that was used to determine $indentLen (INDENTATION or the entry token itself).
     *
     * @param callable(ParseContext): bool $isBareDocumentEntry
     *                                                          Called only when $parentIndent->isBareDocumentRoot is true
     *                                                          and the current token is not INDENTATION. Should return true when the token at the
     *                                                          current stream position is a valid zero-indent entry for this collection type.
     *
     * @return int|null indent length of the next entry, or null to signal "break the loop"
     */
    public function advanceToNextBlockEntry(
        ParseContext $parseContext,
        Node $collection,
        IndentContext $parentIndent,
        callable $isBareDocumentEntry,
    ): ?int {
        $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 0);
        if (null === $head || $head->indentLen <= $parentIndent->indentLen) {
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
            $parentIndent->isBareDocumentRoot
            && $isBareDocumentEntry($parseContext)
        ) {
            $indentLen = 0;
        } elseif (
            $parentIndent->allowsSameIndentBlockSequence
            && TokenType::SEQUENCE_ENTRY === $token->type
            && 0 === $head->indentLen
        ) {
            $indentLen = 0;
        } else {
            return null;
        }

        if ($indentLen > 0) {
            $this->registerIndentStepIfNeeded($parseContext->state, $parseContext->tokens, $indentLen);
            $this->assertIndentLenIsValid($parseContext->state, $parseContext->tokens, $indentLen);
        }

        if ($indentLen <= $parentIndent->indentLen) {
            return null;
        }

        return $indentLen;
    }

    private function assertIndentLenIsValid(ParseState $state, TokenStreamInterface $tokens, int $indentLen): void
    {
        try {
            $state->assertIndentLenIsValid($indentLen);
        } catch (IndentationInvalidException|IndentationUndefinedException $e) {
            $this->errorHelper->wrapParseStateIndentationException($e, $tokens);
        }
    }

    private function registerIndentStepIfNeeded(ParseState $state, TokenStreamInterface $tokens, int $indentLen): void
    {
        if ($state->isIndentLenRegistered()) {
            return;
        }

        try {
            $state->registerIndentStepLen($indentLen);
        } catch (IndentationInvalidException|IndentationOverrideException $e) {
            $this->errorHelper->wrapParseStateIndentationException($e, $tokens);
        }
    }
}
