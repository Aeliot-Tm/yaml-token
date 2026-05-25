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
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class TagDirectiveParser
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    public function parse(ParseContext $parseContext): TagDirectiveNode
    {
        $tagDirectiveNode = new TagDirectiveNode();

        $this->consumer->require($parseContext->tokens, $tagDirectiveNode, TokenType::DIRECTIVE_TAG_INDICATOR);
        $this->consumer->collectWhitespace($parseContext->tokens, $tagDirectiveNode);
        $this->consumer->require($parseContext->tokens, $tagDirectiveNode, TokenType::DIRECTIVE_TAG_HANDLE);
        $this->consumer->collectWhitespace($parseContext->tokens, $tagDirectiveNode);
        $this->consumer->require($parseContext->tokens, $tagDirectiveNode, TokenType::DIRECTIVE_TAG_PREFIX);
        $this->consumer->collectSpaceAndComments($parseContext->tokens, $tagDirectiveNode);

        return $tagDirectiveNode;
    }
}
