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
use Aeliot\YamlToken\Parser\Helper\Identifier\BlockStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class BlockMappingParser implements SubParserInterface
{
    /**
     * @param \Closure(ParseContext): MergeInstructionNode $parseMergeInstructionAtCurrentPosition
     */
    public function __construct(
        private BlockStructureIdentifier $blockStructureIdentifier,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private IndentationHelper $indentationHelper,
        private LookAheadHelper $lookAheadHelper,
        private \Closure $parseMergeInstructionAtCurrentPosition,
        private ParserRegistry $registry,
    ) {
    }

    public function parseBlockMappingValue(ParseContext $parseContext, int $parentIndentLen): BlockMappingNode
    {
        $blockMapping = new BlockMappingNode();

        $baseIndentLen = null;
        $previousCoupleIndentLen = null;

        while (!$parseContext->tokens->isEnd()) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 0);
            if (null === $head || $head[0] <= $parentIndentLen) {
                break;
            }

            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $blockMapping);
            $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $blockMapping);

            $token = $parseContext->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif (
                EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen
                && $this->blockStructureIdentifier->isKeyValueCoupleStart($parseContext)
            ) {
                $indentLen = 0;
            } else {
                break;
            }

            if ($indentLen > 0) {
                $this->indentationHelper->registerIndentStepIfNeeded($parseContext->state, $parseContext->tokens, $indentLen);
                $this->indentationHelper->assertIndentLenIsValid($parseContext->state, $parseContext->tokens, $indentLen);
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

            if (false === $this->blockStructureIdentifier->isKeyValueCoupleStartAllowingNodeProperties($parseContext)) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Key/value couple expected while parsing block mapping value, but %s given', $parseContext->tokens->current()?->type->value ?? '_nothing_'), $token));
            }

            $previousCoupleIndentLen = $indentLen;
            $mergeCandidate = TokenType::INDENTATION === $token->type
                ? $parseContext->tokens->peek(1)
                : $token;
            if (TokenType::MERGE_INDICATOR === $mergeCandidate?->type) {
                $blockMapping->addChild(($this->parseMergeInstructionAtCurrentPosition)($parseContext));

                continue;
            }
            $this->registry
                ->getKeyValueCoupleParser()
                ->parseKeyValueCoupleAtCurrentPosition($parseContext, $blockMapping, $indentLen);
        }

        if (null === $baseIndentLen) {
            throw new UnexpectedStateException('Empty block mapping value is not supported');
        }

        return $blockMapping;
    }
}
