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
use Aeliot\YamlToken\Node\TagDefinitionNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class TagDirectiveParser
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    public function parse(ParseContext $parseContext): TagDefinitionNode
    {
        $TagDefinitionNode = new TagDefinitionNode();

        $this->consumer->require($parseContext->tokens, $TagDefinitionNode, TokenType::TAG_DIRECTIVE);
        $this->consumer->collectWhitespace($parseContext->tokens, $TagDefinitionNode);
        $this->consumer->require($parseContext->tokens, $TagDefinitionNode, TokenType::DIRECTIVE_TAG_HANDLE);
        $this->consumer->collectWhitespace($parseContext->tokens, $TagDefinitionNode);
        $this->consumer->require($parseContext->tokens, $TagDefinitionNode, TokenType::DIRECTIVE_TAG_PREFIX);
        $this->consumer->collectSpaceAndComments($parseContext->tokens, $TagDefinitionNode);

        return $TagDefinitionNode;
    }
}
