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

namespace Aeliot\YamlToken\Parser\SubParser\Scalar;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;

final readonly class BlockScalarParser implements SubParserInterface
{
    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private NodeFactory $nodeFactory,
    ) {
    }

    /**
     * Consumes a block scalar (literal | or folded >) used as an explicit mapping key
     * (YAML 1.2.2 §8.2.2 c-l-block-map-explicit-key). Tokens consumed:
     * BLOCK_SCALAR_INDICATOR, optional sub-indicators (chomping/indentation), NEWLINE,
     * optional leading empty lines, optional INDENTATION, and the scalar payload.
     * The resulting scalar node is set as the {@see KeyNode::setName() name} of the key.
     */
    public function consumeBlockScalarKeyName(TokenStreamProxy $tokens, KeyNode $keyNode): void
    {
        $token = $tokens->current();
        $keyNode->addChild(new BlockScalarIndicatorNode($token));
        $tokens->advance();

        $this->consumer->collectUntil($tokens, TokenType::NEWLINE, $keyNode);

        $token = $tokens->current();
        if (null === $token || TokenType::NEWLINE !== $token->type) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE after block scalar indicator in key, got %s', $token?->type->value ?? '_nothing_'), $tokens));
        }
        $keyNode->addChild(new NewLineNode($token));
        $tokens->advance();

        while (TokenType::NEWLINE === $tokens->current()?->type) {
            $keyNode->addChild(new NewLineNode($tokens->current()));
            $tokens->advance();
        }

        if (TokenType::INDENTATION === $tokens->current()?->type) {
            $keyNode->addChild(new IndentationNode($tokens->current()));
            $tokens->advance();
        }

        $token = $tokens->current();
        if (null === $token || !$token->type->isScalar()) {
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected scalar payload for block scalar key, got %s', $token?->type->value ?? '_nothing_'), $tokens));
        }

        $scalarNode = $this->nodeFactory->createScalarNode($token);
        $keyNode->setName($scalarNode);
        $tokens->advance();

        while (true) {
            $newLineToken = $tokens->current();
            if (TokenType::NEWLINE !== $newLineToken?->type) {
                break;
            }

            $indentationToken = $tokens->peek(1);
            if (TokenType::INDENTATION !== $indentationToken?->type) {
                break;
            }

            $probe = 2;
            while (TokenType::WHITESPACE === $tokens->peek($probe)?->type) {
                ++$probe;
            }

            $afterIndentation = $tokens->peek($probe);
            if (null !== $afterIndentation && TokenType::NEWLINE !== $afterIndentation->type) {
                break;
            }

            $keyNode->addChild(new NewLineNode($newLineToken));
            $tokens->advance();
            $keyNode->addChild(new IndentationNode($indentationToken));
            $tokens->advance();

            $emptyLineSpace = $tokens->current();
            while (TokenType::WHITESPACE === $emptyLineSpace?->type) {
                $keyNode->addChild(new WhitespaceNode($emptyLineSpace));
                $tokens->advance();
                $emptyLineSpace = $tokens->current();
            }
        }
    }

    /**
     * Builds the {@see KeyNode} name for the explicit-block-key path where the key starts on a new line
     * after the `?` indicator (YAML 1.2.2 §8.2.2). Consumes the first NEWLINE + INDENTATION + PLAIN_SCALAR
     * line and any subsequent continuation lines. When only a single scalar fragment is present, the
     * leading layout (NEWLINE / INDENTATION / WHITESPACE) is attached directly to the {@see KeyNode}
     * and the name becomes a plain {@see ScalarNode}; otherwise the whole sequence is wrapped in a
     * {@see MultilinePlainScalarNode}.
     */
    public function consumeExplicitKeyMultilinePlainScalar(TokenStreamProxy $tokens, KeyNode $keyNode, int $entryIndentLen): void
    {
        if (TokenType::NEWLINE !== $tokens->current()?->type) {
            return;
        }

        $multiline = new MultilinePlainScalarNode();
        $this->consumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen);

        while ($this->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
        }

        $scalars = array_values(array_filter(
            $multiline->getChildren(),
            static fn (Node $child): bool => $child instanceof ScalarNode,
        ));

        if (1 === \count($scalars)) {
            foreach ($multiline->getChildren() as $child) {
                if ($child instanceof ScalarNode) {
                    $keyNode->setName($child);
                } else {
                    $keyNode->addChild($child);
                }
            }

            return;
        }

        $keyNode->setName($multiline);
    }

    public function tryConsumeExplicitKeyMultilinePlainScalarLine(
        TokenStreamProxy $tokens,
        MultilinePlainScalarNode $multiline,
        int $entryIndentLen,
    ): bool {
        $newLine = $tokens->current();
        if (TokenType::NEWLINE !== $newLine?->type) {
            return false;
        }

        $indentation = $tokens->peek(1);
        if (TokenType::INDENTATION !== $indentation?->type) {
            return false;
        }

        if (\strlen($indentation->text) <= $entryIndentLen) {
            return false;
        }

        $scalarOffset = 2;
        while (TokenType::WHITESPACE === $tokens->peek($scalarOffset)?->type) {
            ++$scalarOffset;
        }
        $scalarToken = $tokens->peek($scalarOffset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        $keyProbe = $scalarOffset + 1;
        while (TokenType::WHITESPACE === $tokens->peek($keyProbe)?->type) {
            ++$keyProbe;
        }
        if (TokenType::VALUE_INDICATOR === $tokens->peek($keyProbe)?->type) {
            return false;
        }

        $multiline->addChild(new NewLineNode($newLine));
        $multiline->addChild(new IndentationNode($indentation));
        $tokens->advance();
        $tokens->advance();

        $contentHead = $tokens->current();
        while (TokenType::WHITESPACE === $contentHead->type) {
            $multiline->addChild(new WhitespaceNode($contentHead));
            $tokens->advance();
            $contentHead = $tokens->current();
        }

        $multiline->addChild($this->nodeFactory->createScalarNode($contentHead));
        $tokens->advance();

        return true;
    }

    private function consumeExplicitKeyMultilinePlainScalarLine(
        TokenStreamProxy $tokens,
        MultilinePlainScalarNode $multiline,
        int $entryIndentLen,
    ): void {
        if (!$this->tryConsumeExplicitKeyMultilinePlainScalarLine($tokens, $multiline, $entryIndentLen)) {
            $token = $tokens->current();
            throw new UnexpectedTokenException($this->errorHelper->appendTokenLocation(\sprintf('Expected NEWLINE to start indented explicit key plain scalar, got %s', $token?->type->value ?? '_nothing_'), $tokens));
        }
    }
}
