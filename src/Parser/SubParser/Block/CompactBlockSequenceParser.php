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

use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Helper\BlockCollectionLoopHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\SequenceIdentifier;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class CompactBlockSequenceParser
{
    public function __construct(
        private BlockCollectionLoopHelper $blockCollectionLoopHelper,
        private SequenceIdentifier $sequenceIdentifier,
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
    public function parseCompactBlockSequence(ParseContext $parseContext, int $indentLen): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $firstEntry = new BlockSequenceEntryNode();
        $blockSequence->addChild($firstEntry);
        $this->registry->getSequenceEntryParser()->parseSequenceEntry($parseContext, $firstEntry, $indentLen);

        while (!$parseContext->tokens->isEnd()) {
            if (!$this->blockCollectionLoopHelper->advanceToNextCompactBlockEntry($parseContext, $blockSequence, $indentLen)) {
                break;
            }

            if (!$this->sequenceIdentifier->isSequenceStart($parseContext)) {
                break;
            }

            $token = $parseContext->tokens->current();
            $sequenceEntry = new BlockSequenceEntryNode();
            $blockSequence->addChild($sequenceEntry);
            $sequenceEntry->addChild(new IndentationNode($token));
            $parseContext->tokens->advance();

            $this->registry->getSequenceEntryParser()->parseSequenceEntry($parseContext, $sequenceEntry, $indentLen);
        }

        return $blockSequence;
    }
}
