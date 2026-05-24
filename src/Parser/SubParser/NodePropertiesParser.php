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
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\NodePropertiesHolderInterface;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;

final readonly class NodePropertiesParser
{
    private const TOKEN_TYPE_NODES = [
        TokenType::ANCHOR->value => AnchorNode::class,
        TokenType::TAG->value => TagNode::class,
    ];

    public function __construct(
        private ErrorHelper $errorHelper,
    ) {
    }

    /**
     * Per YAML 1.2.2 rule [96] c-ns-properties(n,c), a node has at most one anchor and one tag.
     * The properties may appear inline or be split across separate lines (see [200]
     * s-l+block-collection). When the parser re-enters this routine after consuming the
     * s-separate between the parts, an existing NodePropertiesNode on the value must be
     * reused so the second property does not produce a duplicate properties node.
     */
    public function collectProperties(
        ParseContext $parseContext,
        Node&NodePropertiesHolderInterface $propertiesHolder,
    ): void {
        $properties = $propertiesHolder->getProperties();
        $hadProperties = null !== $properties;
        $buffer = [];

        while (!$parseContext->tokens->isEnd()) {
            $token = $parseContext->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                if (null === $properties) {
                    $propertiesHolder->addChild(new WhitespaceNode($token));
                } else {
                    $buffer[] = new WhitespaceNode($token);
                }
                $parseContext->tokens->advance();
                continue;
            }

            if (isset(self::TOKEN_TYPE_NODES[$token->type->value])) {
                $class = self::TOKEN_TYPE_NODES[$token->type->value];
                if (null !== $properties?->getProperty($class)) {
                    throw new UnexpectedStateException($this->errorHelper->appendTokenLocation(\sprintf('Only one %s is supported per node', $token->type->value), $token));
                }
                $this->whitespaceBuffer($properties, $buffer);
                $properties->addChild(new $class($token));
                $parseContext->tokens->advance();
                continue;
            }

            break;
        }

        if (null !== $properties && !$hadProperties) {
            $propertiesHolder->addChild($properties);
        }
        foreach ($buffer as $whitespace) {
            $propertiesHolder->addChild($whitespace);
        }
    }

    /**
     * @param array<WhitespaceNode> $buffer
     *
     * @param-out NodePropertiesNode $properties
     */
    private function whitespaceBuffer(?NodePropertiesNode &$properties, array &$buffer): void
    {
        $properties ??= new NodePropertiesNode();
        foreach ($buffer as $whitespace) {
            $properties->addChild($whitespace);
        }
        $buffer = [];
    }
}
