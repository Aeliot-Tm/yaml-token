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

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\ByteOrderNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DirectiveNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Parser
{
    private const TOKEN_TYPES_SPASE_AND_COMMENT = [
        TokenType::COMMENT,
        TokenType::INDENTATION,
        TokenType::NEWLINE,
        TokenType::WHITESPACE,
    ];

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    /**
     * @param TokenType[] $types
     */
    private function collectTypes(Harvester $harvester, array $types, Node $root): void
    {
        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }
            if (\in_array($token->type, $types, true)) {
                $root->addChild($this->createSimpleNode($token));
                $harvester->tokens->advance();
                continue;
            }
            break;
        }
    }

    private function collectUntil(Harvester $harvester, TokenType $until, Node $root): void
    {
        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token || $token->type === $until) {
                break;
            }
            $root->addChild($this->createSimpleNode($token));
            $harvester->tokens->advance();
        }
    }

    private function collectSpaceAndComments(Harvester $harvester, Node $root): void
    {
        $this->collectTypes($harvester, self::TOKEN_TYPES_SPASE_AND_COMMENT, $root);
    }

    private function createSimpleNode(Token $token): Node
    {
        return match ($token->type) {
            TokenType::ANCHOR => new AnchorNode($token),
            TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR => new BlockScalarChompingIndicatorNode($token),
            TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR => new BlockScalarIndentationIndicatorNode($token),
            TokenType::COMMENT => new CommentNode($token),
            TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
            TokenType::LITERAL_BLOCK_SCALAR_INDICATOR => new BlockScalarIndicatorNode($token),
            TokenType::INDENTATION => new IndentationNode($token),
            TokenType::NEWLINE => new NewLineNode($token),
            TokenType::TAG_HANDLE_NAMED,
            TokenType::TAG_HANDLE_PRIMARY,
            TokenType::TAG_HANDLE_SECONDARY,
            TokenType::TAG_HANDLE_VERBATIM => new TagNode($token),
            TokenType::VALUE_INDICATOR => new SyntaxTokenNode($token),
            TokenType::WHITESPACE => new WhitespaceNode($token),
            default => throw new \DomainException(\sprintf('Not configured node for token type: %s', $token->type->value)),
        };
    }

    private function createSyntaxTokenNode(Token $token): SyntaxTokenNode
    {
        return new SyntaxTokenNode($token);
    }

    private function getKeyNode(Harvester $harvester): KeyNode
    {
        $keyNode = new KeyNode();
        $token = $harvester->tokens->current();

        if (TokenType::EXPLICIT_KEY_INDICATOR === $token->type) {
            $keyNode->setExplicitKeyIndicator(new ExplicitKeyIndicatorNode($token));
            $harvester->tokens->advance();
            $token = $harvester->tokens->current();

            if (TokenType::WHITESPACE === $token->type) {
                $keyNode->addChild(new WhitespaceNode($token));
                $harvester->tokens->advance();
                $token = $harvester->tokens->current();
            }
        }

        if (TokenType::VALUE_INDICATOR === $token->type) {
            $token = new Token(TokenType::EMPTY_SCALAR, '', $token->line, $token->column);
            $harvester->tokens->setPosition($harvester->tokens->getPosition() - 1);
        }

        if (!$token->type->isScalar()) {
            throw new \LogicException('Key scalar expected');
        }

        $keyNode->setName(new ScalarNode($token));
        $harvester->tokens->advance();

        return $keyNode;
    }

    private function isKeyValueCoupleStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        if (TokenType::EXPLICIT_KEY_INDICATOR === $token->type) {
            return true;
        }

        return \in_array($token->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true);
    }

    private function isSequenceStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
    }

    private function parseFlowMapping(Harvester $harvester): FlowMappingNode
    {
        $flowMappingNode = new FlowMappingNode();
        $token = $harvester->tokens->current();
        if (TokenType::FLOW_MAPPING_START !== $token?->type) {
            throw new \LogicException('There is no expected FLOW_MAPPING_START token');
        }

        $flowMappingNode->addChild(new SyntaxTokenNode($token));
        $harvester->tokens->advance();

        while (true) {
            $this->collectSpaceAndComments($harvester, $flowMappingNode);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::FLOW_MAPPING_END === $token->type) {
                break;
            }

            if (TokenType::FLOW_ENTRY === $token->type) {
                $flowMappingNode->addChild(new SyntaxTokenNode($token));
                $harvester->tokens->advance();
                continue;
            }

            $keyValueCouple = new KeyValueCoupleNode();
            $flowMappingNode->addChild($keyValueCouple);

            $keyValueCouple->setKey($this->getKeyNode($harvester));
            $this->collectTypes($harvester, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $keyValueCouple);
            $keyValueCouple->setValue($this->parseValue($harvester, 0));
        }

        $token = $harvester->tokens->current();
        if (TokenType::FLOW_MAPPING_END !== $token?->type) {
            throw new \LogicException('There is no expected FLOW_MAPPING_END token');
        }

        $flowMappingNode->addChild(new SyntaxTokenNode($token));
        $harvester->tokens->advance();

        $this->collectSpaceAndComments($harvester, $flowMappingNode);

        return $flowMappingNode;
    }

    private function parseFlowSequence(Harvester $harvester): FlowSequenceNode
    {
        $flowSequenceNode = new FlowSequenceNode();

        $token = $harvester->tokens->current();
        if (TokenType::FLOW_SEQUENCE_START !== $token?->type) {
            throw new \LogicException('There is no expected FLOW_SEQUENCE_START token');
        }

        $flowSequenceNode->addChild($this->createSyntaxTokenNode($token));
        $harvester->tokens->advance();

        while (true) {
            $this->collectSpaceAndComments($harvester, $flowSequenceNode);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::FLOW_SEQUENCE_END === $token->type) {
                break;
            }
            if (TokenType::FLOW_ENTRY === $token->type) {
                $flowSequenceNode->addChild($this->createSyntaxTokenNode($token));
                $harvester->tokens->advance();
                continue;
            }

            $flowSequenceNode->addChild($this->parseValue($harvester, 0));
        }

        $token = $harvester->tokens->current();
        if (TokenType::FLOW_SEQUENCE_END !== $token?->type) {
            throw new \LogicException('There is no expected FLOW_SEQUENCE_END token');
        }

        $flowSequenceNode->addChild($this->createSyntaxTokenNode($token));
        $harvester->tokens->advance();

        $this->collectSpaceAndComments($harvester, $flowSequenceNode);

        return $flowSequenceNode;
    }

    private function parseStream(TokenStream $tokens): StreamNode
    {
        $harvester = new Harvester($tokens);
        $harvester->registry = new ParseRegistry();
        $harvester->state = new ParseState();
        $harvester->stream = $stream = new StreamNode();

        $token = $harvester->tokens->current();
        if (null !== $token && TokenType::BYTE_ORDER_MARK === $token->type) {
            $harvester->stream->addChild(new ByteOrderNode($token));
            $harvester->tokens->advance();
        }

        $this->parseDocuments($harvester, $stream);

        return $stream;
    }

    private function parseDocuments(Harvester $harvester, StreamNode $stream): void
    {
        $document = new DocumentNode();
        while (!$harvester->tokens->isEnd()) {
            $token = $harvester->tokens->current();

            if (TokenType::DOCUMENT_START === $token->type) {
                if ($document->getChildren()) {
                    $stream->addChild($document);
                    $document = new DocumentNode();
                }

                $document->addChild(new DocumentStartNode($token));
                $stream->addChild($document);
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DOCUMENT_END === $token->type) {
                $document->addChild(new DocumentEndNode($token));
                $stream->addChild($document);
                $document = new DocumentNode();
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE === $token->type) {
                $document->addChild(new DirectiveNode($token));
                $harvester->tokens->advance();
                continue;
            }

            // TODO: handel DIRECTIVE_YAML & DIRECTIVE_TAG

            if (TokenType::COMMENT === $token->type) {
                $document->addChild(new CommentNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::NEWLINE === $token->type) {
                $document->addChild(new NewLineNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::INDENTATION === $token->type && TokenType::COMMENT === $harvester->tokens->peek(1)?->type) {
                $document->addChild(new IndentationNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if ($this->isSequenceStart($harvester)) {
                $sequenceEntry = new SequenceEntryNode();
                $document->addChild($sequenceEntry);

                if (TokenType::INDENTATION === $token->type) {
                    $sequenceEntry->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $this->collectTypes($harvester, [TokenType::SEQUENCE_ENTRY, TokenType::WHITESPACE], $sequenceEntry);
                $sequenceEntry->setValue($this->parseValue($harvester, 0));
                continue;
            }

            if ($this->isKeyValueCoupleStart($harvester)) {
                $indentLen = 0;
                if (TokenType::INDENTATION === $token->type) {
                    $indentLen = \strlen($token->text);
                }

                $this->parseKeyValueCoupleAtCurrentPosition($harvester, $document, $indentLen);
                continue;
            }

            throw new \LogicException('Unexpected type');
        }

        if ($document->getChildren()) {
            $stream->addChild($document);
        }
    }

    private function parseKeyValueCoupleAtCurrentPosition(Harvester $harvester, Node $root, int $indentLen): void
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            throw new \LogicException('Unexpected end of stream while parsing key/value couple');
        }

        $keyValueCouple = new KeyValueCoupleNode();
        $root->addChild($keyValueCouple);

        if (TokenType::INDENTATION === $token->type) {
            $keyValueCouple->setIndentation(new IndentationNode($token));
            $harvester->tokens->advance();
        }

        $keyValueCouple->setKey($this->getKeyNode($harvester));
        $this->collectTypes($harvester, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $keyValueCouple);
        $keyValueCouple->setValue($this->parseValue($harvester, $indentLen));
    }

    private function parseValue(Harvester $harvester, int $parentIndentLen): Node
    {
        $valueNode = new ValueNode();

        $this->collectTypes($harvester, [
            TokenType::ANCHOR,
            TokenType::TAG_HANDLE_NAMED,
            TokenType::TAG_HANDLE_PRIMARY,
            TokenType::TAG_HANDLE_SECONDARY,
            TokenType::TAG_HANDLE_VERBATIM,
            TokenType::WHITESPACE,
        ], $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $harvester->registry->anchors[$anchor->getName()] = $anchor;
        }

        $token = $harvester->tokens->current();
        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $valueNode->addChild(new BlockScalarIndicatorNode($token));
            $harvester->tokens->advance();
            $this->collectUntil($harvester, TokenType::NEWLINE, $valueNode);

            $token = $harvester->tokens->current();
            if (!$token) {
                return $valueNode;
            }

            if (TokenType::NEWLINE !== $token->type) {
                throw new \LogicException('Unexpected newline');
            }
            $valueNode->addChild(new NewLineNode($token));
            $harvester->tokens->advance();

            $token = $harvester->tokens->current();
            if (!$token->type->isScalar()) {
                throw new \LogicException('Scalar expected');
            }

            $valueNode->addChild(new ScalarNode($token));
            $harvester->tokens->advance();
        } elseif (TokenType::NEWLINE === $token->type) {
            $valueNode->addChild($this->parseBlockMappingValue($harvester, $parentIndentLen));
        } elseif ($token->type->isScalar()) {
            $valueNode->addChild(new ScalarNode($token));
            $harvester->tokens->advance();
        } elseif (TokenType::SEQUENCE_ENTRY === $token->type) {
            // TODO implement
        } elseif (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $valueNode->addChild($this->parseFlowSequence($harvester));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->parseFlowMapping($harvester));
        } else {
            throw new \LogicException('Unexpected type while parsing of value');
        }

        $this->collectTypes($harvester, [
            TokenType::COMMENT,
            TokenType::WHITESPACE,
        ], $valueNode);

        return $valueNode;
    }

    private function parseBlockMappingValue(Harvester $harvester, int $parentIndentLen): BlockMappingNode
    {
        $blockMapping = new BlockMappingNode();

        $baseIndentLen = null;
        $previousCoupleIndentLen = null;

        while (!$harvester->tokens->isEnd()) {
            $this->collectTypes($harvester, [
                TokenType::NEWLINE,
                TokenType::COMMENT,
                TokenType::WHITESPACE,
            ], $blockMapping);

            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::INDENTATION !== $token->type) {
                throw new \LogicException('Indentation expected while parsing block mapping value');
            }

            $indentLen = \strlen($token->text);
            if ($indentLen > 0) {
                if (!$harvester->state->isIndentLenRegistered()) {
                    $harvester->state->registerIndentStepLen($indentLen);
                }
                $harvester->state->assertIndentLenIsValid($indentLen);
            }

            if ($indentLen <= $parentIndentLen) {
                break;
            }

            if (null === $baseIndentLen) {
                $baseIndentLen = $indentLen;
            } elseif ($indentLen < $baseIndentLen) {
                throw new \LogicException(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen));
            } elseif ($indentLen > $baseIndentLen && $previousCoupleIndentLen === $baseIndentLen) {
                throw new \LogicException(\sprintf('Unexpected indentation %d for next key/value couple; expected %d', $indentLen, $baseIndentLen));
            }

            if (false === $this->isKeyValueCoupleStart($harvester)) {
                throw new \LogicException('Key/value couple expected while parsing block mapping value');
            }

            $previousCoupleIndentLen = $indentLen;
            $this->parseKeyValueCoupleAtCurrentPosition($harvester, $blockMapping, $indentLen);
        }

        if (null === $baseIndentLen) {
            throw new \LogicException('Empty block mapping value is not supported');
        }

        return $blockMapping;
    }
}
