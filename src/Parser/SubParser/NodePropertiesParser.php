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
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class NodePropertiesParser implements SubParserInterface
{
    public function __construct(
        private ErrorHelper $errorHelper,
    ) {
    }

    public function collectValueProperties(ParseContext $harvester, ValueNode $valueNode): void
    {
        // Per YAML 1.2.2 rule [96] c-ns-properties(n,c), a node has at most one anchor and one tag.
        // The properties may appear inline or be split across separate lines (see [200]
        // s-l+block-collection). When the parser re-enters this routine after consuming the
        // s-separate between the parts, an existing NodePropertiesNode on the value must be
        // reused so the second property does not produce a duplicate properties node.
        $properties = $valueNode->getProperties();
        $hadProperties = null !== $properties;
        $whitespaceBuffer = [];

        while (!$harvester->tokens->isEnd()) {
            $token = $harvester->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                if (null === $properties) {
                    $valueNode->addChild(new WhitespaceNode($token));
                } else {
                    $whitespaceBuffer[] = new WhitespaceNode($token);
                }
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                if (null !== $properties?->getAnchor()) {
                    throw new UnexpectedStateException($this->errorHelper->appendTokenLocation('Only one anchor is supported per value node', $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->addChild(new AnchorNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::TAG === $token->type) {
                if (null !== $properties?->getTag()) {
                    throw new UnexpectedStateException($this->errorHelper->appendTokenLocation('Only one tag is supported per value node', $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->addChild(new TagNode($token));
                $harvester->tokens->advance();
                continue;
            }

            break;
        }

        if (null !== $properties && !$hadProperties) {
            $valueNode->addChild($properties);
        }
        foreach ($whitespaceBuffer as $whitespace) {
            $valueNode->addChild($whitespace);
        }
    }
}
