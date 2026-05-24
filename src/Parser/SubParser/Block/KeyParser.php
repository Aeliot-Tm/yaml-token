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
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\SubParser\NodePropertiesParser;

final readonly class KeyParser
{
    public function __construct(
        private ExplicitKeyParser $explicitKeyParser,
        private ImplicitKeyParser $implicitKeyParser,
        private NodePropertiesParser $nodePropertiesParser,
    ) {
    }

    public function getKeyNode(ParseContext $parseContext, ?int $entryIndentLen = null): KeyNode
    {
        $keyNode = new KeyNode();
        $this->nodePropertiesParser->collectProperties($parseContext, $keyNode);
        $token = $parseContext->tokens->current();

        if (TokenType::EXPLICIT_KEY_INDICATOR === $token->type) {
            $this->explicitKeyParser->parse($parseContext, $keyNode, $entryIndentLen);
        } else {
            $this->implicitKeyParser->parse($parseContext, $keyNode, $entryIndentLen);
        }

        return $keyNode;
    }
}
