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
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\Identifier\BlockStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\FlowStructureIdentifier;
use Aeliot\YamlToken\Parser\Helper\Identifier\NodePropertyIdentifier;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Token\Token;

final readonly class DocumentParser
{
    public function __construct(
        private BlockStructureIdentifier $blockStructureIdentifier,
        private ErrorHelper $errorHelper,
        private FlowStructureIdentifier $flowStructureIdentifier,
        private LookAheadHelper $lookAheadHelper,
        private NodePropertyIdentifier $nodePropertyIdentifier,
        private ParserRegistry $registry,
    ) {
    }

    public function parseDocuments(ParseContext $parseContext, StreamNode $stream): void
    {
        $addedDocs = [];
        $document = new DocumentNode();
        while (!$parseContext->tokens->isEnd()) {
            if ($this->tryConsumeDocumentMarker($parseContext, $document, $stream, $addedDocs)) {
                continue;
            }
            if ($this->tryConsumeDirectiveToken($parseContext, $document)) {
                continue;
            }
            if ($this->tryConsumeDocumentLayoutToken($parseContext, $document)) {
                continue;
            }
            if ($this->tryParseDocumentRootContent($parseContext, $document)) {
                continue;
            }

            $token = $parseContext->tokens->current();
            if (!$token) {
                break;
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

    private function consumeOptionalLeadingIndent(ParseContext $parseContext, DocumentNode $document): void
    {
        $token = $parseContext->tokens->current();
        if (TokenType::INDENTATION !== $token->type) {
            return;
        }

        $document->addChild(new IndentationNode($token));
        $parseContext->tokens->advance();
    }

    private function parseDocumentRootSequenceEntry(ParseContext $parseContext, DocumentNode $document, Token $token): void
    {
        $sequenceEntry = new BlockSequenceEntryNode();
        $document->addChild($sequenceEntry);

        $leadingIndent = 0;
        if (TokenType::INDENTATION === $token->type) {
            $sequenceEntry->addChild(new IndentationNode($token));
            $leadingIndent = \strlen($token->text);
            $parseContext->tokens->advance();
        }

        $this->registry
                ->getSequenceEntryParser()
                ->parseSequenceEntry($parseContext, $sequenceEntry, $leadingIndent);
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

    private function tryConsumeDirectiveToken(ParseContext $parseContext, DocumentNode $document): bool
    {
        $token = $parseContext->tokens->current();
        if (!$token) {
            return false;
        }

        if (TokenType::DIRECTIVE === $token->type) {
            $document->addChild(new DirectiveNode($token));
            $parseContext->tokens->advance();

            return true;
        }

        if (TokenType::DIRECTIVE_YAML_INDICATOR === $token->type) {
            $document->addChild($this->registry->getYamlDirectiveParser()->parse($parseContext));

            return true;
        }

        if (TokenType::DIRECTIVE_TAG_INDICATOR === $token->type) {
            $document->addChild($this->registry->getTagDirectiveParser()->parse($parseContext));

            return true;
        }

        return false;
    }

    private function tryConsumeDocumentLayoutToken(ParseContext $parseContext, DocumentNode $document): bool
    {
        $token = $parseContext->tokens->current();
        if (!$token) {
            return false;
        }

        if (TokenType::COMMENT === $token->type) {
            $document->addChild(new CommentNode($token));
            $parseContext->tokens->advance();

            return true;
        }

        if (TokenType::NEWLINE === $token->type) {
            $document->addChild(new NewLineNode($token));
            $parseContext->tokens->advance();

            return true;
        }

        if (TokenType::WHITESPACE === $token->type) {
            $document->addChild(new WhitespaceNode($token));
            $parseContext->tokens->advance();

            return true;
        }

        if (TokenType::INDENTATION === $token->type && TokenType::COMMENT === $parseContext->tokens->peek(1)?->type) {
            $document->addChild(new IndentationNode($token));
            $parseContext->tokens->advance();

            return true;
        }

        if ($this->lookAheadHelper->isInsignificantIndentationLine($parseContext->tokens)) {
            $this->lookAheadHelper->collectInsignificantIndentationLines($parseContext->tokens, $document);

            return true;
        }

        return false;
    }

    /**
     * @param array<int, bool> $addedDocs
     */
    private function tryConsumeDocumentMarker(
        ParseContext $parseContext,
        DocumentNode &$document,
        StreamNode $stream,
        array &$addedDocs,
    ): bool {
        $token = $parseContext->tokens->current();
        if (!$token) {
            return false;
        }

        if (TokenType::DOCUMENT_START === $token->type) {
            if ($document->getChildren()) {
                $this->tryAddDocumentToStream($stream, $document, $addedDocs);
                $document = new DocumentNode();
            }

            $document->addChild(new DocumentStartNode($token));
            $this->tryAddDocumentToStream($stream, $document, $addedDocs);
            $parseContext->tokens->advance();

            return true;
        }

        if (TokenType::DOCUMENT_END === $token->type) {
            $document->addChild(new DocumentEndNode($token));
            $this->tryAddDocumentToStream($stream, $document, $addedDocs);
            $parseContext->tokens->advance();
            $this->consumeDocumentEndLineSuffix($parseContext, $document);
            $document = new DocumentNode();

            return true;
        }

        return false;
    }

    private function tryParseDocumentRootContent(ParseContext $parseContext, DocumentNode $document): bool
    {
        $token = $parseContext->tokens->current();
        if (!$token) {
            return false;
        }

        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $document->addChild($this->registry->getValueParser()->parseValue($parseContext, IndentContext::createForBareDocument()));

            return true;
        }

        if (TokenType::ALIAS === $token->type) {
            $document->addChild($this->registry->getValueParser()->parseValue($parseContext, IndentContext::createForBareDocument()));

            return true;
        }

        if ($this->blockStructureIdentifier->isSequenceStart($parseContext)) {
            $this->parseDocumentRootSequenceEntry($parseContext, $document, $token);

            return true;
        }

        if ($this->blockStructureIdentifier->isKeyValueCoupleStart($parseContext)) {
            $indentLen = 0;
            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            }

            $this->registry
                ->getKeyValueCoupleParser()
                ->parseKeyValueCoupleAtCurrentPosition($parseContext, $document, $indentLen);

            return true;
        }

        if ($token->type->isScalar()) {
            $document->addChild($this->registry->getValueParser()->parseValue($parseContext, IndentContext::createForBareDocument()));

            return true;
        }

        if ($this->nodePropertyIdentifier->isNodePropertyAtDocumentRoot($parseContext)) {
            $this->consumeOptionalLeadingIndent($parseContext, $document);
            $document->addChild($this->registry->getValueParser()->parseValue($parseContext, IndentContext::createForBareDocument()));

            return true;
        }

        if ($this->flowStructureIdentifier->isFlowMappingStart($parseContext)) {
            $this->consumeOptionalLeadingIndent($parseContext, $document);
            $document->addChild($this->registry->getFlowMappingParser()->parse($parseContext));

            return true;
        }

        if ($this->flowStructureIdentifier->isFlowSequenceStart($parseContext)) {
            $this->consumeOptionalLeadingIndent($parseContext, $document);
            $document->addChild($this->registry->getFlowSequenceParser()->parse($parseContext));

            return true;
        }

        return false;
    }
}
