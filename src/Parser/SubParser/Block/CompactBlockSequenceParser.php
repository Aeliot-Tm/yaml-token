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

namespace Aeliot\YamlToken\Parser\SubParser\Block;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class CompactBlockSequenceParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private LookAheadHelper $lookAheadHelper,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * YAML 1.2.2 §8.2.1 rule [186] ns-l-compact-sequence(n):
     *   c-l-block-seq-entry(n) ( s-indent(n) c-l-block-seq-entry(n) )*
     *
     * The first entry is parsed at the current stream position (no leading
     * INDENTATION token — the caller has already consumed the enclosing
     * indicator, e.g. '-', '?' or ':' together with its trailing spaces,
     * so we sit directly on the nested '-'). Subsequent entries require
     * an INDENTATION token whose length equals $indentLen — the column
     * (0-based) of the first '-', i.e. the value of n in rule [186].
     */
    public function parseCompactBlockSequence(ParseContext $harvester, int $indentLen): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $firstEntry = new BlockSequenceEntryNode();
        $blockSequence->addChild($firstEntry);
        $firstCompactIndent = $indentLen + $this->registry
                ->getSequenceEntryParser()
                ->consumeSequenceEntryIndicatorAndSpaces($harvester, $firstEntry);

        $firstEntry->addChild(
            $this->registry
                ->getSequenceEntryParser()
                ->parseSequenceEntryValue($harvester, $indentLen, $firstCompactIndent),
        );

        while (!$harvester->tokens->isEnd()) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($harvester->tokens, 0);
            if (null === $head || $head[0] !== $indentLen) {
                break;
            }

            $this->consumer->collectSpaceCommentEnds($harvester->tokens, $blockSequence);
            $this->lookAheadHelper->collectInsignificantIndentationLines($harvester->tokens, $blockSequence);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::INDENTATION !== $token->type) {
                break;
            }
            if (\strlen($token->text) !== $indentLen) {
                break;
            }
            if (!$this->isSequenceStart($harvester)) {
                break;
            }

            $sequenceEntry = new BlockSequenceEntryNode();
            $blockSequence->addChild($sequenceEntry);
            $sequenceEntry->addChild(new IndentationNode($token));
            $harvester->tokens->advance();

            $compactIndent = $indentLen + $this->registry
                    ->getSequenceEntryParser()
                    ->consumeSequenceEntryIndicatorAndSpaces($harvester, $sequenceEntry);

            $sequenceEntry->addChild(
                $this->registry
                    ->getSequenceEntryParser()
                    ->parseSequenceEntryValue($harvester, $indentLen, $compactIndent),
            );
        }

        return $blockSequence;
    }

    private function isSequenceStart(ParseContext $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
    }
}
