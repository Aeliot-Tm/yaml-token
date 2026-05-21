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
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Exception\UnexpectedEndException;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class KeyValueCoupleParser implements SubParserInterface
{
    /**
     * @param \Closure(Harvester, int): ValueNode $parseValue
     */
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private LookAheadHelper $lookAheadHelper,
        private \Closure $parseValue,
        private ParserRegistry $registry,
    ) {
    }

    public function parseKeyValueCoupleAtCurrentPosition(Harvester $harvester, Node $root, int $indentLen): void
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            throw new UnexpectedEndException($this->errorHelper->appendTokenLocation('Unexpected end of stream while parsing key/value couple', $harvester->tokens));
        }

        $keyValueCouple = new KeyValueCoupleNode();
        $root->addChild($keyValueCouple);

        $entryIndentLen = 0;
        if (TokenType::INDENTATION === $token->type) {
            $entryIndentLen = \strlen($token->text);
            $keyValueCouple->setIndentation(new IndentationNode($token));
            $harvester->tokens->advance();
        }

        $keyValueCouple->addChild($this->registry->getKeyParser()->getKeyNode($harvester, $entryIndentLen));

        $afterKey = $harvester->tokens->current();
        if (
            null !== $afterKey
            && null !== $keyValueCouple->getKey()->getExplicitKeyIndicatorNode()
        ) {
            $this->consumer->collectTypes($harvester->tokens, [TokenType::WHITESPACE], $keyValueCouple);
            $afterKey = $harvester->tokens->current();

            if (null === $afterKey || TokenType::NEWLINE !== $afterKey->type) {
                $afterKey = null;
            }
        }

        if (null !== $afterKey && TokenType::NEWLINE === $afterKey->type) {
            $head = $this->lookAheadHelper->peekFirstSignificantBlockHead($harvester->tokens, 1);
            if (null !== $head) {
                [$headIndentLen, $significantToken] = $head;
                if (TokenType::VALUE_INDICATOR === $significantToken->type && $headIndentLen === $entryIndentLen) {
                    $this->consumer->collectTypes($harvester->tokens, [
                        TokenType::COMMENT,
                        TokenType::INDENTATION,
                        TokenType::NEWLINE,
                        TokenType::WHITESPACE,
                    ], $keyValueCouple);
                }
            }
        }

        $afterKey = $harvester->tokens->current();
        if (
            null !== $afterKey
            && null !== $keyValueCouple->getKey()->getExplicitKeyIndicatorNode()
            && TokenType::INDENTATION === $afterKey->type
            && \strlen($afterKey->text) === $entryIndentLen
            && TokenType::VALUE_INDICATOR === $harvester->tokens->peek(1)?->type
        ) {
            $this->consumer->collectTypes($harvester->tokens, [TokenType::INDENTATION], $keyValueCouple);
        }

        $this->consumer->collectTypes($harvester->tokens, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $keyValueCouple);
        $keyValueCouple->addChild(($this->parseValue)($harvester, $indentLen));
        $this->anchorPostProcessor->postProcessKeyValueCouple($harvester->anchorsRegistry, $keyValueCouple);
    }
}
