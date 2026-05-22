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

namespace Aeliot\YamlToken\Parser\SubParser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DirectiveNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Enum\EspecialIndent;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class DocumentParser implements SubParserInterface
{
    /**
     * @param \Closure(ParseContext): bool $isBlockScalarStartAtDocumentRoot
     * @param \Closure(ParseContext): bool $isFlowMappingStart
     * @param \Closure(ParseContext): bool $isFlowSequenceStart
     * @param \Closure(ParseContext): bool $isKeyValueCoupleStart
     * @param \Closure(ParseContext): bool $isNodePropertyAtDocumentRoot
     * @param \Closure(ParseContext): bool $isSequenceStart
     */
    public function __construct(
        private ErrorHelper $errorHelper,
        private \Closure $isBlockScalarStartAtDocumentRoot,
        private \Closure $isFlowMappingStart,
        private \Closure $isFlowSequenceStart,
        private \Closure $isKeyValueCoupleStart,
        private \Closure $isNodePropertyAtDocumentRoot,
        private \Closure $isSequenceStart,
        private ParserRegistry $registry,
    ) {
    }

    public function parseDocuments(ParseContext $parseContext, StreamNode $stream): void
    {
        $addedDocs = [];
        $document = new DocumentNode();
        while (!$parseContext->tokens->isEnd()) {
            $token = $parseContext->tokens->current();

            if (TokenType::DOCUMENT_START === $token->type) {
                if ($document->getChildren()) {
                    $this->tryAddDocumentToStream($stream, $document, $addedDocs);
                    $document = new DocumentNode();
                }

                $document->addChild(new DocumentStartNode($token));
                $this->tryAddDocumentToStream($stream, $document, $addedDocs);
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::DOCUMENT_END === $token->type) {
                $document->addChild(new DocumentEndNode($token));
                $this->tryAddDocumentToStream($stream, $document, $addedDocs);
                $parseContext->tokens->advance();
                $this->consumeDocumentEndLineSuffix($parseContext, $document);
                $document = new DocumentNode();
                continue;
            }

            if (TokenType::DIRECTIVE === $token->type) {
                $document->addChild(new DirectiveNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE_YAML_INDICATOR === $token->type) {
                $document->addChild($this->registry->getDirectiveParser()->parseYamlDirective($parseContext));
                continue;
            }

            if (TokenType::DIRECTIVE_TAG_INDICATOR === $token->type) {
                $document->addChild($this->registry->getDirectiveParser()->parseTagDirective($parseContext));
                continue;
            }

            if (TokenType::COMMENT === $token->type) {
                $document->addChild(new CommentNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::NEWLINE === $token->type) {
                $document->addChild(new NewLineNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            // Preserve trailing spaces on otherwise blank lines: whitespace before NEWLINE is not structural.
            if (TokenType::WHITESPACE === $token->type && TokenType::NEWLINE === $parseContext->tokens->peek(1)?->type) {
                $document->addChild(new WhitespaceNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::INDENTATION === $token->type && TokenType::COMMENT === $parseContext->tokens->peek(1)?->type) {
                $document->addChild(new IndentationNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            // YAML 1.2.2 §6.6 Comments: "Comments must be separated from other tokens by white space characters."
            // Handles `s-separate-in-line` between a preceding token on the same line (e.g. DOCUMENT_START/END) and a trailing comment.
            if (TokenType::WHITESPACE === $token->type && TokenType::COMMENT === $parseContext->tokens->peek(1)?->type) {
                $document->addChild(new WhitespaceNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (($this->isBlockScalarStartAtDocumentRoot)($parseContext)) {
                while (true) {
                    $separation = $parseContext->tokens->current();
                    if (TokenType::INDENTATION === $separation?->type) {
                        $document->addChild(new IndentationNode($separation));
                        $parseContext->tokens->advance();
                        continue;
                    }
                    if (TokenType::WHITESPACE === $separation?->type) {
                        $document->addChild(new WhitespaceNode($separation));
                        $parseContext->tokens->advance();
                        continue;
                    }
                    break;
                }

                $document->addChild($this->registry->getValueParser()->parseValue($parseContext, EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value));
                continue;
            }

            if (TokenType::ALIAS === $token->type) {
                $document->addChild($this->registry->getValueParser()->parseValue($parseContext, EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value));
                continue;
            }

            if (($this->isSequenceStart)($parseContext)) {
                $sequenceEntry = new BlockSequenceEntryNode();
                $document->addChild($sequenceEntry);

                $leadingIndent = 0;
                if (TokenType::INDENTATION === $token->type) {
                    $sequenceEntry->addChild(new IndentationNode($token));
                    $leadingIndent = \strlen($token->text);
                    $parseContext->tokens->advance();
                }

                $compactIndent = $leadingIndent + $this->registry
                        ->getSequenceEntryParser()
                        ->consumeSequenceEntryIndicatorAndSpaces($parseContext, $sequenceEntry);

                $sequenceEntry->addChild(
                    $this->registry
                        ->getSequenceEntryParser()
                        ->parseSequenceEntryValue($parseContext, $leadingIndent, $compactIndent),
                );
                continue;
            }

            if (($this->isKeyValueCoupleStart)($parseContext)) {
                $indentLen = 0;
                if (TokenType::INDENTATION === $token->type) {
                    $indentLen = \strlen($token->text);
                }

                $this->registry
                    ->getKeyValueCoupleParser()
                    ->parseKeyValueCoupleAtCurrentPosition($parseContext, $document, $indentLen);
                continue;
            }

            if ($token->type->isScalar()) {
                $document->addChild($this->registry->getValueParser()->parseValue($parseContext, EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value));
                continue;
            }

            if (($this->isNodePropertyAtDocumentRoot)($parseContext)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $parseContext->tokens->advance();
                }

                $document->addChild($this->registry->getValueParser()->parseValue($parseContext, EspecialIndent::BARE_DOCUMENT_BLOCK_PARENT->value));
                continue;
            }

            if (($this->isFlowMappingStart)($parseContext)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $parseContext->tokens->advance();
                }

                $document->addChild($this->registry->getFlowMappingParser()->parse($parseContext));
                continue;
            }

            if (($this->isFlowSequenceStart)($parseContext)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $parseContext->tokens->advance();
                }

                $document->addChild($this->registry->getFlowSequenceParser()->parse($parseContext));
                continue;
            }

            if (TokenType::WHITESPACE === $token->type) {
                $document->addChild(new WhitespaceNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected type: %s', $token->type->value), $token));
        }

        if ($document->getChildren()) {
            $this->tryAddDocumentToStream($stream, $document, $addedDocs);
        }
    }

    /**
     * Consumes the line suffix after a document end marker (YAML 1.2.2 rule [209] c-document-end).
     */
    private function consumeDocumentEndLineSuffix(ParseContext $parseContext, DocumentNode $document): void
    {
        while (true) {
            $token = $parseContext->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::WHITESPACE === $token->type) {
                $document->addChild(new WhitespaceNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::COMMENT === $token->type) {
                $document->addChild(new CommentNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::NEWLINE === $token->type) {
                $document->addChild(new NewLineNode($token));
                $parseContext->tokens->advance();
            }

            break;
        }
    }

    /**
     * @param array<int, bool> $addedDocs
     */
    private function tryAddDocumentToStream(StreamNode $stream, DocumentNode $document, array &$addedDocs): void
    {
        $objectId = spl_object_id($document);
        if (isset($addedDocs[$objectId])) {
            return;
        }

        $stream->addChild($document);
        $addedDocs[$objectId] = true;
    }
}
