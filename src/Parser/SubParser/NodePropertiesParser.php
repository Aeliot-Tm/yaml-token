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
use Aeliot\YamlToken\Node\AbstractNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class NodePropertiesParser
{
    public function __construct(
        private ErrorHelper $errorHelper,
    ) {
    }

    public function collectKeyProperties(ParseContext $parseContext, KeyNode $keyNode): void
    {
        $this->collectPropertiesInto($parseContext, $keyNode, null, 'key');
    }

    public function collectValueProperties(ParseContext $parseContext, ValueNode $valueNode): void
    {
        // Per YAML 1.2.2 rule [96] c-ns-properties(n,c), a node has at most one anchor and one tag.
        // The properties may appear inline or be split across separate lines (see [200]
        // s-l+block-collection). When the parser re-enters this routine after consuming the
        // s-separate between the parts, an existing NodePropertiesNode on the value must be
        // reused so the second property does not produce a duplicate properties node.
        $this->collectPropertiesInto($parseContext, $valueNode, $valueNode->getProperties(), 'value');
    }

    private function collectPropertiesInto(
        ParseContext $parseContext,
        AbstractNode $parentNode,
        ?NodePropertiesNode $existingProperties,
        string $nodeTypeLabel,
    ): void {
        $properties = $existingProperties;
        $hadProperties = null !== $properties;
        $whitespaceBuffer = [];

        while (!$parseContext->tokens->isEnd()) {
            $token = $parseContext->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                if (null === $properties) {
                    $parentNode->addChild(new WhitespaceNode($token));
                } else {
                    $whitespaceBuffer[] = new WhitespaceNode($token);
                }
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                if (null !== $properties?->getAnchor()) {
                    throw new UnexpectedStateException($this->errorHelper->appendTokenLocation(\sprintf('Only one anchor is supported per %s node', $nodeTypeLabel), $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->addChild(new AnchorNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            if (TokenType::TAG === $token->type) {
                if (null !== $properties?->getTag()) {
                    throw new UnexpectedStateException($this->errorHelper->appendTokenLocation(\sprintf('Only one tag is supported per %s node', $nodeTypeLabel), $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->addChild(new TagNode($token));
                $parseContext->tokens->advance();
                continue;
            }

            break;
        }

        if (null !== $properties && !$hadProperties) {
            $parentNode->addChild($properties);
        }
        foreach ($whitespaceBuffer as $whitespace) {
            $parentNode->addChild($whitespace);
        }
    }
}
