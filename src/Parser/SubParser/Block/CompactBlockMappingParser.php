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
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class CompactBlockMappingParser implements SubParserInterface
{
    /**
     * @param \Closure(ParseContext): bool $isKeyValueCoupleStartAllowingNodeProperties
     */
    public function __construct(
        private Consumer $consumer,
        private \Closure $isKeyValueCoupleStartAllowingNodeProperties,
        private LookAheadHelper $lookAheadHelper,
        private ParserRegistry $registry,
    ) {
    }

    /**
     * YAML 1.2.2 §8.2.2 rule [195] ns-l-compact-mapping(n):
     *   ns-l-block-map-entry(n) ( s-indent(n) ns-l-block-map-entry(n) )*
     *
     * The first entry is parsed at the current stream position (no leading
     * INDENTATION token — the caller has already consumed '-' and its
     * trailing spaces so we sit directly on the key). Subsequent entries
     * require an INDENTATION token whose length equals $indentLen.
     */
    public function parseCompactBlockMapping(ParseContext $parseContext, int $indentLen): BlockMappingNode
    {
        $blockMapping = new BlockMappingNode();

        $this->registry
            ->getKeyValueCoupleParser()
            ->parseKeyValueCoupleAtCurrentPosition($parseContext, $blockMapping, $indentLen);

        while (!$parseContext->tokens->isEnd()) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 0);
            if (null === $head || $head[0] !== $indentLen) {
                break;
            }

            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $blockMapping);
            $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $blockMapping);

            $token = $parseContext->tokens->current();
            if (null === $token || TokenType::INDENTATION !== $token->type) {
                break;
            }
            if (\strlen($token->text) !== $indentLen) {
                break;
            }
            if (!($this->isKeyValueCoupleStartAllowingNodeProperties)($parseContext)) {
                break;
            }

            $this->registry
                ->getKeyValueCoupleParser()
                ->parseKeyValueCoupleAtCurrentPosition($parseContext, $blockMapping, $indentLen);
        }

        return $blockMapping;
    }
}
