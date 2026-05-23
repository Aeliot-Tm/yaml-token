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
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Dto\LookAheadResult;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;

final readonly class LookAheadHelper
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    /**
     * Consume one or more consecutive l-empty / l-comment lines whose
     * leading INDENTATION must not contribute to the surrounding block's
     * s-indent(n). Tokens are still attached to $root verbatim so the
     * emitter can reproduce the original text.
     */
    public function collectInsignificantIndentationLines(TokenStreamProxy $tokens, Node $root): void
    {
        while ($this->isInsignificantIndentationLine($tokens)) {
            $token = $tokens->current();
            $root->addChild(new IndentationNode($token));
            $tokens->advance();
            $this->consumer->collectSpaceCommentEnds($tokens, $root);
        }
    }

    public function isInsignificantIndentationLine(TokenStreamProxy $tokens): bool
    {
        if (TokenType::INDENTATION !== $tokens->current()?->type) {
            return false;
        }

        for ($offset = 1;; ++$offset) {
            $token = $tokens->peek($offset);
            if (null === $token || TokenType::NEWLINE === $token->type) {
                return true;
            }
            if (TokenType::COMMENT !== $token->type && TokenType::WHITESPACE !== $token->type) {
                return false;
            }
        }
    }

    /**
     * Look-ahead from the current token (expected NEWLINE) through any number
     * of l-empty / l-comment lines (per YAML 1.2.2 §6.6) to find the first
     * line that carries significant content. Used by parseIndentedBlockValue
     * to decide whether the value of a `key:` is empty or holds a nested
     * block / column-0 collection — without prematurely consuming any tokens.
     *
     * A line is considered insignificant when it consists exclusively of
     * WHITESPACE / COMMENT tokens (optionally prefixed by an INDENTATION
     * token) and is terminated by NEWLINE or end-of-stream. Both indented
     * comment lines (`    # ...`) and column-0 comment lines (`# ...`) are
     * skipped, since the lexer omits the leading INDENTATION token only
     * for the latter.
     *
     * @param int $offset TokenStreamProxy peek offset of the first token to consider:
     *                    0 - when layout from the current position must be included in the scan;
     *                    1 - when the current token is already known, e.g. NEWLINE after ':';
     *
     * @return LookAheadResult|null Result pointing at the first significant line:
     *                              - indentLen is the byte-length of that line's
     *                              leading INDENTATION token (0 for column-0 lines);
     *                              - significantToken is the first non-WHITESPACE/COMMENT
     *                              token of that line.
     *                              - peekOffset is the TokenStreamProxy peek offset of significantToken.
     *                              Returns null if the stream ends with only insignificant lines.
     */
    public function peekFirstSignificantBlockHead(TokenStreamProxy $tokens, int $offset): ?LookAheadResult
    {
        while (true) {
            $token = $tokens->peek($offset);
            if (null === $token) {
                return null;
            }

            if (TokenType::NEWLINE === $token->type) {
                ++$offset;
                continue;
            }

            $hasIndentation = TokenType::INDENTATION === $token->type;
            $indentLen = $hasIndentation ? \strlen($token->text) : 0;
            $probe = $hasIndentation ? $offset + 1 : $offset;

            while (true) {
                $candidate = $tokens->peek($probe);
                if (null === $candidate || TokenType::NEWLINE === $candidate->type) {
                    $offset = null === $candidate ? $probe : $probe + 1;
                    continue 2;
                }
                if (TokenType::COMMENT !== $candidate->type && TokenType::WHITESPACE !== $candidate->type) {
                    return new LookAheadResult($indentLen, $candidate, $probe);
                }
                ++$probe;
            }
        }
    }
}
