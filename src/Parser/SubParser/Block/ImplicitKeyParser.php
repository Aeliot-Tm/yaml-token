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
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\AliasResolver;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class ImplicitKeyParser
{
    public function __construct(
        private AliasResolver $aliasResolver,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $registry,
    ) {
    }

    public function parse(ParseContext $parseContext, KeyNode $keyNode, ?int $entryIndentLen): void
    {
        $token = $parseContext->tokens->current();

        if (TokenType::VALUE_INDICATOR === $token->type) {
            return;
        }

        if (TokenType::FLOW_MAPPING_START === $token->type) {
            $keyNode->setName($this->registry->getFlowMappingParser()->parse($parseContext));

            return;
        }

        if (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $keyNode->setName($this->registry->getFlowSequenceParser()->parse($parseContext));

            return;
        }

        if (TokenType::ALIAS === $token->type) {
            $aliasNode = $this->aliasResolver->resolveAlias($parseContext, $token);
            $keyNode->setName($aliasNode);
            $parseContext->tokens->advance();

            return;
        }

        if (!$token->type->isScalar() && !$token->type->isMergeIndicator()) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Key scalar expected, but %s given', $token->type->value), $token));
        }

        $keyNode->setName($this->buildScalarKeyName($parseContext->tokens, $token, $entryIndentLen));
    }

    private function buildScalarKeyName(TokenStreamInterface $tokens, Token $headToken, ?int $entryIndentLen): Node
    {
        $head = $this->nodeFactory->createScalarNode($headToken);
        $tokens->advance();

        if (!$head instanceof PlainScalarNode) {
            return $head;
        }

        if (null === $entryIndentLen) {
            return $this->registry->getFlowMultilinePlainScalarKeyParser()->parse($tokens, $head);
        }

        return $head;
    }
}
