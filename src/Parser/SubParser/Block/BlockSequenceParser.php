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
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class BlockSequenceParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private IndentationHelper $indentationHelper,
        private LookAheadHelper $lookAheadHelper,
        private ParserRegistry $registry,
    ) {
    }

    public function parseBlockSequenceValue(ParseContext $parseContext, int $parentIndentLen, bool $allowNonSequenceAtBaseIndentAsTerminator = false): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $baseIndentLen = null;

        while (!$parseContext->tokens->isEnd()) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($parseContext->tokens, 0);
            if (null === $head || $head[0] <= $parentIndentLen) {
                break;
            }

            $this->consumer->collectSpaceCommentEnds($parseContext->tokens, $blockSequence);
            $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $blockSequence);

            $token = $parseContext->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif (EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value === $parentIndentLen && TokenType::SEQUENCE_ENTRY === $token->type) {
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
            } elseif ($indentLen !== $baseIndentLen) {
                throw new IndentationInvalidException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen), $token));
            }

            if (!$this->isSequenceStart($parseContext)) {
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

    private function isSequenceStart(ParseContext $parseContext): bool
    {
        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $parseContext->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
    }
}
