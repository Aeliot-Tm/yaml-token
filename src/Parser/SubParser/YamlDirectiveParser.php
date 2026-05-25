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
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class YamlDirectiveParser
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    public function parse(ParseContext $parseContext): YamlDirectiveNode
    {
        $yamlDirectiveNode = new YamlDirectiveNode();

        $this->consumer->grab($parseContext->tokens, $yamlDirectiveNode, TokenType::DIRECTIVE_YAML_INDICATOR);
        $this->consumer->collectTypes(
            $parseContext->tokens,
            [TokenType::WHITESPACE, TokenType::VALUE_INDICATOR],
            $yamlDirectiveNode,
        );
        $this->consumer->grab($parseContext->tokens, $yamlDirectiveNode, TokenType::DIRECTIVE_YAML_VERSION);
        $this->consumer->collectSpaceAndComments($parseContext->tokens, $yamlDirectiveNode);

        return $yamlDirectiveNode;
    }
}
