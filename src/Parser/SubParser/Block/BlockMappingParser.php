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
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\BlockCollectionLoopHelper;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\BlockStructureIdentifier;

final readonly class BlockMappingParser
{
    public function __construct(
        private BlockCollectionLoopHelper $blockCollectionLoopHelper,
        private BlockStructureIdentifier $blockStructureIdentifier,
        private ErrorHelper $errorHelper,
        private ParserRegistry $registry,
    ) {
    }

    public function parseBlockMappingValue(ParseContext $parseContext, IndentContext $parentIndent): BlockMappingNode
    {
        $blockMapping = new BlockMappingNode();

        $baseIndentLen = null;
        $previousCoupleIndentLen = null;

        while (!$parseContext->tokens->isEnd()) {
            $indentLen = $this->blockCollectionLoopHelper->advanceToNextBlockEntry(
                $parseContext,
                $blockMapping,
                $parentIndent,
                fn (ParseContext $ctx): bool => $this->blockStructureIdentifier->isKeyValueCoupleStart($ctx),
            );
            if (null === $indentLen) {
                break;
            }

            $token = $parseContext->tokens->current();

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
                $blockMapping->addChild(
                    $this->registry->getMergeInstructionParser()->parseMergeInstructionAtCurrentPosition($parseContext),
                );

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
