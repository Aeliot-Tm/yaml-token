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
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class BlockMappingParser implements SubParserInterface
{
    /**
     * @param \Closure(ParseContext): bool $isKeyValueCoupleStart
     * @param \Closure(ParseContext): bool $isKeyValueCoupleStartAllowingNodeProperties
     * @param \Closure(ParseContext): MergeInstructionNode $parseMergeInstructionAtCurrentPosition
     */
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private IndentationHelper $indentationHelper,
        private \Closure $isKeyValueCoupleStart,
        private \Closure $isKeyValueCoupleStartAllowingNodeProperties,
        private LookAheadHelper $lookAheadHelper,
        private \Closure $parseMergeInstructionAtCurrentPosition,
        private ParserRegistry $registry,
    ) {
    }

    public function parseBlockMappingValue(ParseContext $harvester, int $parentIndentLen): BlockMappingNode
    {
        $blockMapping = new BlockMappingNode();

        $baseIndentLen = null;
        $previousCoupleIndentLen = null;

        while (!$harvester->tokens->isEnd()) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($harvester->tokens, 0);
            if (null === $head || $head[0] <= $parentIndentLen) {
                break;
            }

            $this->consumer->collectSpaceCommentEnds($harvester->tokens, $blockMapping);
            $this->lookAheadHelper->collectInsignificantIndentationLines($harvester->tokens, $blockMapping);

            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif (EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen && ($this->isKeyValueCoupleStart)($harvester)) {
                $indentLen = 0;
            } else {
                break;
            }

            if ($indentLen > 0) {
                $this->indentationHelper->registerIndentStepIfNeeded($harvester->state, $harvester->tokens, $indentLen);
                $this->indentationHelper->assertIndentLenIsValid($harvester->state, $harvester->tokens, $indentLen);
            }

            if ($indentLen <= $parentIndentLen) {
                break;
            }

            if (null === $baseIndentLen) {
                $baseIndentLen = $indentLen;
            } elseif ($indentLen < $baseIndentLen) {
                throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen), $token));
            } elseif ($indentLen > $baseIndentLen && $previousCoupleIndentLen === $baseIndentLen) {
                throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected indentation %d for next key/value couple; expected %d', $indentLen, $baseIndentLen), $token));
            }

            if (false === ($this->isKeyValueCoupleStartAllowingNodeProperties)($harvester)) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Key/value couple expected while parsing block mapping value, but %s given', $harvester->tokens->current()?->type->value ?? '_nothing_'), $token));
            }

            $previousCoupleIndentLen = $indentLen;
            $mergeCandidate = TokenType::INDENTATION === $token->type
                ? $harvester->tokens->peek(1)
                : $token;
            if (TokenType::MERGE_INDICATOR === $mergeCandidate?->type) {
                $blockMapping->addChild(($this->parseMergeInstructionAtCurrentPosition)($harvester));

                continue;
            }
            $this->registry
                ->getKeyValueCoupleParser()
                ->parseKeyValueCoupleAtCurrentPosition($harvester, $blockMapping, $indentLen);
        }

        if (null === $baseIndentLen) {
            throw new UnexpectedStateException('Empty block mapping value is not supported');
        }

        return $blockMapping;
    }
}
