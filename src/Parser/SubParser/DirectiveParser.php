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
use Aeliot\YamlToken\Node\TagDirectiveHandleNode;
use Aeliot\YamlToken\Node\TagDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Node\TagDirectivePrefixNode;
use Aeliot\YamlToken\Node\YamlDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\UnexpectedEndException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class DirectiveParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
    ) {
    }

    public function parseTagDirective(ParseContext $parseContext): TagDirectiveNode
    {
        $token = $parseContext->tokens->current();
        if (TokenType::DIRECTIVE_TAG_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected DIRECTIVE_TAG_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $tagDirectiveNode = new TagDirectiveNode();
        $tagDirectiveNode->addChild(new TagDirectiveIndicatorNode($token));
        $parseContext->tokens->advance();

        $seenHandle = false;
        while (true) {
            $token = $parseContext->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException($this->errorHelper->appendTokenLocation('Unexpected end of token stream: TAG directive handle and prefix are required', $parseContext->tokens));
            }

            if (TokenType::WHITESPACE === $token->type) {
                $tagDirectiveNode->addChild($this->nodeFactory->createSimpleNode($token));
                $parseContext->tokens->advance();

                continue;
            }

            if (TokenType::DIRECTIVE_TAG_HANDLE === $token->type) {
                $seenHandle = true;
                $tagDirectiveNode->addChild(new TagDirectiveHandleNode($token));
                $parseContext->tokens->advance();

                continue;
            }

            if (TokenType::DIRECTIVE_TAG_PREFIX === $token->type) {
                if (!$seenHandle) {
                    throw new UnexpectedStateException('Expected TAG directive handle before prefix');
                }
                $tagDirectiveNode->addChild(new TagDirectivePrefixNode($token));
                $parseContext->tokens->advance();

                $this->consumer->collectSpaceAndComments($parseContext->tokens, $tagDirectiveNode);

                return $tagDirectiveNode;
            }

            if (\in_array($token->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected TAG directive handle and prefix before newline or comment, but %s given', $token->type->value), $token));
            }

            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected token in TAG directive: %s', $token->type->value), $token));
        }
    }

    public function parseYamlDirective(ParseContext $parseContext): YamlDirectiveNode
    {
        $token = $parseContext->tokens->current();
        if (TokenType::DIRECTIVE_YAML_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected DIRECTIVE_YAML_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'), $parseContext->tokens));
        }

        $yamlDirectiveNode = new YamlDirectiveNode();
        $yamlDirectiveNode->addChild(new YamlDirectiveIndicatorNode($token));
        $parseContext->tokens->advance();

        while (true) {
            $token = $parseContext->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException($this->errorHelper->appendTokenLocation('Unexpected end of token stream: YAML directive version is required', $parseContext->tokens));
            }

            if (\in_array($token->type, [TokenType::WHITESPACE, TokenType::VALUE_INDICATOR], true)) {
                $yamlDirectiveNode->addChild($this->nodeFactory->createSimpleNode($token));
                $parseContext->tokens->advance();

                continue;
            }

            if (TokenType::DIRECTIVE_YAML_VERSION === $token->type) {
                $yamlDirectiveNode->addChild($this->nodeFactory->createSimpleNode($token));
                $parseContext->tokens->advance();

                $this->consumer->collectSpaceAndComments($parseContext->tokens, $yamlDirectiveNode);

                return $yamlDirectiveNode;
            }

            if (\in_array($token->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected YAML directive version before newline or comment, but %s given', $token->type->value), $token));
            }

            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Unexpected token in YAML directive: %s', $token->type->value), $token));
        }
    }
}
