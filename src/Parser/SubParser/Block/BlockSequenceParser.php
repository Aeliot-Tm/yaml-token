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
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\BlockCollectionLoopHelper;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\SequenceIdentifier;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class BlockSequenceParser
{
    public function __construct(
        private BlockCollectionLoopHelper $blockCollectionLoopHelper,
        private ErrorHelper $errorHelper,
        private SequenceIdentifier $sequenceIdentifier,
        private ParserRegistry $registry,
    ) {
    }

    public function parseBlockSequenceValue(ParseContext $parseContext, int $parentIndentLen, bool $allowNonSequenceAtBaseIndentAsTerminator = false): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $baseIndentLen = null;

        while (!$parseContext->tokens->isEnd()) {
            $indentLen = $this->blockCollectionLoopHelper->advanceToNextBlockEntry(
                $parseContext,
                $blockSequence,
                $parentIndentLen,
                fn (ParseContext $ctx): bool => TokenType::SEQUENCE_ENTRY === $ctx->tokens->current()?->type,
            );
            if (null === $indentLen) {
                break;
            }

            $token = $parseContext->tokens->current();

            if (null === $baseIndentLen) {
                $baseIndentLen = $indentLen;
            } elseif ($indentLen !== $baseIndentLen) {
                throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen), $token));
            }

            if (!$this->sequenceIdentifier->isSequenceStart($parseContext)) {
                if ($allowNonSequenceAtBaseIndentAsTerminator && $indentLen === $baseIndentLen) {
                    break;
                }
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Sequence entry expected while parsing block sequence value, but %s given', $parseContext->tokens->current()?->type->value ?? '_nothing_'), $token));
            }

            $sequenceEntry = new BlockSequenceEntryNode();
            $blockSequence->addChild($sequenceEntry);
            if (TokenType::INDENTATION === $token->type) {
                $sequenceEntry->addChild(new IndentationNode($token));
                $parseContext->tokens->advance();
            }

            $compactIndent = $indentLen + $this->registry
                    ->getSequenceEntryParser()
                    ->consumeSequenceEntryIndicatorAndSpaces($parseContext, $sequenceEntry);

            $sequenceEntry->addChild(
                $this->registry
                    ->getSequenceEntryParser()
                    ->parseSequenceEntryValue($parseContext, $indentLen, $compactIndent),
            );
        }

        if (null === $baseIndentLen) {
            throw new UnexpectedStateException('Empty block sequence value is not supported');
        }

        return $blockSequence;
    }
}
