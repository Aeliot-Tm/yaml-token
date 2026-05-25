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
use Aeliot\YamlToken\Node\YamlDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\TokenGrabber;

final readonly class YamlDirectiveParser
{
    public function __construct(
        private Consumer $consumer,
        private NodeFactory $nodeFactory,
        private TokenGrabber $tokenGrabber,
    ) {
    }

    public function parse(ParseContext $parseContext): YamlDirectiveNode
    {
        $yamlDirectiveNode = new YamlDirectiveNode();
        $yamlDirectiveNode->addChild(new YamlDirectiveIndicatorNode(
            $this->tokenGrabber->current($parseContext->tokens, TokenType::DIRECTIVE_YAML_INDICATOR),
        ));

        $this->consumer->collectTypes($parseContext->tokens, [TokenType::WHITESPACE, TokenType::VALUE_INDICATOR], $yamlDirectiveNode);

        $yamlDirectiveNode->addChild($this->nodeFactory->createSimpleNode(
            $this->tokenGrabber->current($parseContext->tokens, TokenType::DIRECTIVE_YAML_VERSION),
        ));

        $this->consumer->collectSpaceAndComments($parseContext->tokens, $yamlDirectiveNode);

        return $yamlDirectiveNode;
    }
}
