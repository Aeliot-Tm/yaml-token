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
use Aeliot\YamlToken\Node\YamlVersionDirectiveNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class YamlDirectiveParser
{
    public function __construct(
        private Consumer $consumer,
    ) {
    }

    public function parse(ParseContext $parseContext): YamlVersionDirectiveNode
    {
        $YamlVersionDirectiveNode = new YamlVersionDirectiveNode();

        $this->consumer->require($parseContext->tokens, $YamlVersionDirectiveNode, TokenType::YAML_DIRECTIVE);
        $this->consumer->collectSpaceValueIndicator($parseContext->tokens, $YamlVersionDirectiveNode);
        $this->consumer->require($parseContext->tokens, $YamlVersionDirectiveNode, TokenType::YAML_VERSION);
        $this->consumer->collectSpaceAndComments($parseContext->tokens, $YamlVersionDirectiveNode);

        return $YamlVersionDirectiveNode;
    }
}
