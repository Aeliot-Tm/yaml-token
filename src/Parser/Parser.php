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
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
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
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagBodyNode;
use Aeliot\YamlToken\Node\TagDirectiveHandleNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Node\TagDirectivePrefixNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Node\YamlDirectiveVersionNode;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedEndException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedNodeException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
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
     * @return list<AliasNode>
     */
    private function collectMergeAliases(ValueNode $value): array
    {
        $directAliases = array_values(array_filter(
            $value->getChildren(),
            static fn (Node $n): bool => $n instanceof AliasNode,
        ));
        if ($directAliases) {
            /* @var list<AliasNode> $directAliases */
            return $directAliases;
        }

        $flowSequence = null;
        foreach ($value->getChildren() as $child) {
            if ($child instanceof FlowSequenceNode) {
                $flowSequence = $child;
                break;
            }
        }
        if (null === $flowSequence) {
            throw new UnexpectedStateException('Merge value must be an alias or a flow sequence of aliases');
        }

        $aliases = [];
        foreach ($flowSequence->getEntries() as $entry) {
            if (!$entry instanceof ValueNode) {
                throw new UnexpectedNodeException('Flow sequence entry must be a value node');
            }

            $entryAliases = array_values(array_filter(
                $entry->getChildren(),
                static fn (Node $n): bool => $n instanceof AliasNode,
            ));
            if (1 !== \count($entryAliases)) {
                throw new UnexpectedStateException('Each merge sequence entry must contain exactly one alias');
            }
            $aliases[] = $entryAliases[0];
        }

        return $aliases;
    }

    private function collectSpaceAndComments(Harvester $harvester, Node $root): void
    {
        $this->collectTypes($harvester, self::TOKEN_TYPES_SPASE_AND_COMMENT, $root);
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

    private function collectValueProperties(Harvester $harvester, ValueNode $valueNode): void
    {
        $tagProperty = null;

        while (!$harvester->tokens->isEnd()) {
            $token = $harvester->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                $valueNode->addChild(new WhitespaceNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                $valueNode->addChild(new AnchorNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::TAG_BODY === $token->type) {
                throw new UnexpectedTokenException('Tag body without tag handle');
            }

            if (\in_array($token->type, [
                TokenType::TAG_HANDLE_NAMED,
                TokenType::TAG_HANDLE_PRIMARY,
                TokenType::TAG_HANDLE_SECONDARY,
                TokenType::TAG_HANDLE_VERBATIM,
                TokenType::TAG_NON_SPECIFIC,
            ], true)) {
                if (null !== $tagProperty) {
                    throw new UnexpectedStateException('Only one tag property is supported per value node');
                }

                $tagProperty = new TagPropertyNode();
                $tagProperty->addChild(new TagNode($token));
                $valueNode->addChild($tagProperty);
                $harvester->tokens->advance();

                if (\in_array($token->type, [TokenType::TAG_HANDLE_VERBATIM, TokenType::TAG_NON_SPECIFIC], true)) {
                    continue;
                }

                $this->collectTypes($harvester, [TokenType::WHITESPACE], $valueNode);

                $body = $harvester->tokens->current();
                if (TokenType::TAG_BODY !== $body?->type) {
                    throw new UnexpectedTokenException(\sprintf('Tag body expected, but %s given', $body?->type->value ?? '_nothing_'));
                }

                $tagProperty->addChild(new TagBodyNode($body));
                $harvester->tokens->advance();
                continue;
            }

            break;
        }
    }

    /**
     * Consumes one SEQUENCE_ENTRY token followed by any number of
     * directly adjacent WHITESPACE tokens. Returns the total length
     * in characters (always >= 1). Per YAML 1.2.2 §8.2.1 this
     * combined length is considered part of the indentation of the
     * nested (compact) block collection.
     */
    private function consumeSequenceEntryIndicatorAndSpaces(Harvester $harvester, Node $target): int
    {
        $token = $harvester->tokens->current();
        if (TokenType::SEQUENCE_ENTRY !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('SEQUENCE_ENTRY expected, but %s given', $token?->type->value ?? '_nothing_'));
        }

        $target->addChild(new SyntaxTokenNode($token));
        $harvester->tokens->advance();
        $consumed = \strlen($token->text);

        while (true) {
            $next = $harvester->tokens->current();
            if (TokenType::WHITESPACE !== $next?->type) {
                break;
            }
            $target->addChild(new WhitespaceNode($next));
            $consumed += \strlen($next->text);
            $harvester->tokens->advance();
        }

        return $consumed;
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
            TokenType::TAG_BODY => new TagBodyNode($token),
            TokenType::TAG_HANDLE_NAMED,
            TokenType::TAG_HANDLE_PRIMARY,
            TokenType::TAG_HANDLE_SECONDARY,
            TokenType::TAG_HANDLE_VERBATIM => new TagNode($token),
            TokenType::SEQUENCE_ENTRY,
            TokenType::VALUE_INDICATOR => new SyntaxTokenNode($token),
            TokenType::WHITESPACE => new WhitespaceNode($token),
            TokenType::DIRECTIVE_YAML_VERSION => new YamlDirectiveVersionNode($token),
            default => throw new UnexpectedTokenException(\sprintf('Not configured node for token type: %s', $token->type->value)),
        };
    }

    private function createSyntaxTokenNode(Token $token): SyntaxTokenNode
    {
        return new SyntaxTokenNode($token);
    }

    private function tryConsumeFlowMappingValueIndicator(Harvester $harvester, KeyValueCoupleNode $couple): bool
    {
        $this->collectTypes($harvester, [TokenType::WHITESPACE], $couple);

        $token = $harvester->tokens->current();
        if (null === $token || TokenType::VALUE_INDICATOR !== $token->type) {
            return false;
        }

        $couple->setMappingValueIndicator(new SyntaxTokenNode($token));
        $harvester->tokens->advance();

        $this->collectTypes($harvester, [TokenType::WHITESPACE], $couple);

        return true;
    }

    private function getKeyNode(Harvester $harvester, bool $allowEmptyImplicitKey): KeyNode
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
            if (!$allowEmptyImplicitKey && null === $keyNode->getExplicitKeyIndicatorNode()) {
                throw new UnexpectedTokenException('Empty implicit key is not allowed in this context');
            }

            return $keyNode;
        }

        if (!$token->type->isScalar() && !$token->type->isMergeIndicator()) {
            if (null !== $keyNode->getExplicitKeyIndicatorNode()) {
                return $keyNode;
            }

            throw new UnexpectedTokenException(\sprintf('Key scalar expected, but %s given', $token->type->value));
        }

        $keyNode->setName(new ScalarNode($token));
        $harvester->tokens->advance();

        return $keyNode;
    }

    private function isFlowMappingStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::FLOW_MAPPING_START === $token?->type;
    }

    private function isFlowSequenceStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::FLOW_SEQUENCE_START === $token?->type;
    }

    private function isKeyValueCoupleStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        if (TokenType::EXPLICIT_KEY_INDICATOR === $token->type || $token->type->isMergeIndicator()) {
            return true;
        }

        return \in_array($token->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true);
    }

    /**
     * Implicit YAML key detector (YAML 1.2.2 rule [154] ns-s-implicit-yaml-key):
     * current token is a scalar and the next non-WHITESPACE token on the same
     * logical position is ':' (VALUE_INDICATOR). Used both for
     *  - flow-pair entry inside a flow-sequence (§7.4.1 [139], §7.4.2 [152]);
     *  - compact block-mapping entry inside a block sequence entry (§8.2.1 [185], §8.2.2 [195]).
     */
    private function isScalarFollowedByValueIndicator(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (null === $token || !$token->type->isScalar()) {
            return false;
        }

        $offset = 1;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }
            if (TokenType::WHITESPACE !== $peeked->type) {
                return TokenType::VALUE_INDICATOR === $peeked->type;
            }
            ++$offset;
        }
    }

    private function isSequenceStart(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return TokenType::SEQUENCE_ENTRY === $token?->type;
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
                break;
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
                throw new IndentationInvalidException(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen));
            } elseif ($indentLen > $baseIndentLen && $previousCoupleIndentLen === $baseIndentLen) {
                throw new IndentationInvalidException(\sprintf('Unexpected indentation %d for next key/value couple; expected %d', $indentLen, $baseIndentLen));
            }

            if (false === $this->isKeyValueCoupleStart($harvester)) {
                throw new UnexpectedTokenException(\sprintf('Key/value couple expected while parsing block mapping value, but %s given', $harvester->tokens->current()?->type->value ?? '_nothing_'));
            }

            $previousCoupleIndentLen = $indentLen;
            $tokenAfterIndent = $harvester->tokens->peek(1);
            if (TokenType::MERGE_INDICATOR === $tokenAfterIndent?->type) {
                $harvester->tokens->advance(); // skip indentation
                $blockMapping->addChild($this->parseMergeInstructionAtCurrentPosition($harvester));
                continue;
            }
            $this->parseKeyValueCoupleAtCurrentPosition($harvester, $blockMapping, $indentLen);
        }

        if (null === $baseIndentLen) {
            throw new UnexpectedStateException('Empty block mapping value is not supported');
        }

        return $blockMapping;
    }

    private function parseBlockSequenceValue(Harvester $harvester, int $parentIndentLen): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $baseIndentLen = null;

        while (!$harvester->tokens->isEnd()) {
            $this->collectTypes($harvester, [
                TokenType::NEWLINE,
                TokenType::COMMENT,
                TokenType::WHITESPACE,
            ], $blockSequence);

            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::INDENTATION !== $token->type) {
                break;
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
            } elseif ($indentLen !== $baseIndentLen) {
                throw new IndentationInvalidException(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen));
            }

            if (false === $this->isSequenceStart($harvester)) {
                throw new UnexpectedTokenException(\sprintf('Sequence entry expected while parsing block sequence value, but %s given', $harvester->tokens->current()?->type->value ?? '_nothing_'));
            }

            $sequenceEntry = new SequenceEntryNode();
            $blockSequence->addChild($sequenceEntry);
            $sequenceEntry->addChild(new IndentationNode($token));
            $harvester->tokens->advance();

            $compactIndent = $indentLen + $this->consumeSequenceEntryIndicatorAndSpaces($harvester, $sequenceEntry);
            $sequenceEntry->setValue($this->parseSequenceEntryValue($harvester, $indentLen, $compactIndent));
        }

        if (null === $baseIndentLen) {
            throw new UnexpectedStateException('Empty block sequence value is not supported');
        }

        return $blockSequence;
    }

    /**
     * YAML 1.2.2 §8.2.2 rule [195] ns-l-compact-mapping(n):
     *   ns-l-block-map-entry(n) ( s-indent(n) ns-l-block-map-entry(n) )*
     *
     * The first entry is parsed at the current stream position (no leading
     * INDENTATION token — the caller has already consumed '-' and its
     * trailing spaces so we sit directly on the key). Subsequent entries
     * require an INDENTATION token whose length equals $indentLen.
     */
    private function parseCompactBlockMapping(Harvester $harvester, int $indentLen): BlockMappingNode
    {
        $blockMapping = new BlockMappingNode();

        $this->parseKeyValueCoupleAtCurrentPosition($harvester, $blockMapping, $indentLen);

        while (!$harvester->tokens->isEnd()) {
            $this->collectTypes($harvester, [
                TokenType::NEWLINE,
                TokenType::COMMENT,
                TokenType::WHITESPACE,
            ], $blockMapping);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::INDENTATION !== $token->type) {
                break;
            }
            if (\strlen($token->text) !== $indentLen) {
                break;
            }
            if (!$this->isKeyValueCoupleStart($harvester)) {
                break;
            }

            $this->parseKeyValueCoupleAtCurrentPosition($harvester, $blockMapping, $indentLen);
        }

        return $blockMapping;
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

            if (TokenType::DIRECTIVE_YAML === $token->type) {
                $document->addChild($this->parseYamlDirective($harvester));
                continue;
            }

            if (TokenType::DIRECTIVE_TAG === $token->type) {
                $document->addChild($this->parseTagDirective($harvester));
                continue;
            }

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

                $leadingIndent = 0;
                if (TokenType::INDENTATION === $token->type) {
                    $sequenceEntry->addChild(new IndentationNode($token));
                    $leadingIndent = \strlen($token->text);
                    $harvester->tokens->advance();
                }

                $compactIndent = $leadingIndent + $this->consumeSequenceEntryIndicatorAndSpaces($harvester, $sequenceEntry);
                $sequenceEntry->setValue($this->parseSequenceEntryValue($harvester, $leadingIndent, $compactIndent));
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

            if ($this->isFlowMappingStart($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->parseFlowMapping($harvester));
                continue;
            }

            if ($this->isFlowSequenceStart($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->parseFlowSequence($harvester));
                continue;
            }

            throw new UnexpectedTokenException(\sprintf('Unexpected type: %s', $token->type->value));
        }

        if ($document->getChildren()) {
            $stream->addChild($document);
        }
    }

    private function parseFlowMapping(Harvester $harvester): FlowMappingNode
    {
        $flowMappingNode = new FlowMappingNode();
        $token = $harvester->tokens->current();
        if (TokenType::FLOW_MAPPING_START !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_MAPPING_START token, but %s given', $token?->type->value ?? '_nothing_'));
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

            if (TokenType::MERGE_INDICATOR === $token->type) {
                $flowMappingNode->addChild($this->parseMergeInstructionAtCurrentPosition($harvester));
                continue;
            }

            $keyValueCouple = new KeyValueCoupleNode();
            $flowMappingNode->addChild($keyValueCouple);

            $keyValueCouple->setKey($this->getKeyNode($harvester, true));

            if ($this->tryConsumeFlowMappingValueIndicator($harvester, $keyValueCouple)) {
                $token = $harvester->tokens->current();
                if (null === $token || \in_array($token->type, [TokenType::FLOW_ENTRY, TokenType::FLOW_MAPPING_END], true)) {
                    $keyValueCouple->setValue(new ValueNode());
                } else {
                    $keyValueCouple->setValue($this->parseValue($harvester, 0));
                }
            }
            $this->postProcessKeyValueCouple($harvester, $keyValueCouple);
        }

        $token = $harvester->tokens->current();
        if (TokenType::FLOW_MAPPING_END !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_MAPPING_END token, but %s given', $token?->type->value ?? '_nothing_'));
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
            throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_SEQUENCE_START token, but %s given', $token?->type->value ?? '_nothing_'));
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

            $flowSequenceNode->addChild($this->parseFlowSequenceEntry($harvester));
        }

        $token = $harvester->tokens->current();
        if (TokenType::FLOW_SEQUENCE_END !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('There is no expected FLOW_SEQUENCE_END token, but %s given', $token?->type->value ?? '_nothing_'));
        }

        $flowSequenceNode->addChild($this->createSyntaxTokenNode($token));
        $harvester->tokens->advance();

        $this->collectSpaceAndComments($harvester, $flowSequenceNode);

        return $flowSequenceNode;
    }

    /**
     * Parses a single flow-sequence entry.
     *
     * Per YAML 1.2.2 §7.4.1 rule [139], an entry is either a flow-node or a flow-pair.
     * Flow-pair (the compact single-pair mapping) is recognized via {@see isScalarFollowedByValueIndicator()}
     * and built using the same helpers as {@see parseFlowMapping()} so that whitespace
     * tokens between the key and ':' end up attached to the KeyValueCoupleNode
     * (matching c-ns-flow-map-separate-value, rule [152]).
     *
     * Only the implicit YAML-key form is covered in this scope:
     * explicit '?' form (Example 7.20), empty implicit key and
     * JSON-key adjacent value (Example 7.21) are out of scope.
     */
    private function parseFlowSequenceEntry(Harvester $harvester): Node
    {
        if (!$this->isScalarFollowedByValueIndicator($harvester)) {
            return $this->parseValue($harvester, 0);
        }

        $couple = new KeyValueCoupleNode();
        $couple->setKey($this->getKeyNode($harvester, false));

        $this->tryConsumeFlowMappingValueIndicator($harvester, $couple);

        $next = $harvester->tokens->current();
        if (null === $next || \in_array($next->type, [TokenType::FLOW_ENTRY, TokenType::FLOW_SEQUENCE_END], true)) {
            $couple->setValue(new ValueNode());
        } else {
            $couple->setValue($this->parseValue($harvester, 0));
        }

        $this->postProcessKeyValueCouple($harvester, $couple);

        return $couple;
    }

    private function parseIndentedBlockValue(Harvester $harvester, int $parentIndentLen): ?Node
    {
        $token = $harvester->tokens->current();
        if (TokenType::NEWLINE !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('Expected NEWLINE while parsing indented block value, but %s given', $token?->type->value ?? '_nothing_'));
        }

        $indent = $harvester->tokens->peek(1);
        if (null === $indent || TokenType::INDENTATION !== $indent->type) {
            $harvester->tokens->advance();

            return null;
        }

        $indentLen = \strlen($indent->text);
        if ($indentLen <= $parentIndentLen) {
            $harvester->tokens->advance();

            return null;
        }

        $afterIndent = $harvester->tokens->peek(2);
        if (TokenType::SEQUENCE_ENTRY === $afterIndent?->type) {
            return $this->parseBlockSequenceValue($harvester, $parentIndentLen);
        }

        return $this->parseBlockMappingValue($harvester, $parentIndentLen);
    }

    private function parseKeyValueCoupleAtCurrentPosition(Harvester $harvester, Node $root, int $indentLen): void
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            throw new UnexpectedEndException('Unexpected end of stream while parsing key/value couple');
        }

        $keyValueCouple = new KeyValueCoupleNode();
        $root->addChild($keyValueCouple);

        if (TokenType::INDENTATION === $token->type) {
            $keyValueCouple->setIndentation(new IndentationNode($token));
            $harvester->tokens->advance();
        }

        $keyValueCouple->setKey($this->getKeyNode($harvester, false));
        $this->collectTypes($harvester, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $keyValueCouple);
        $keyValueCouple->setValue($this->parseValue($harvester, $indentLen));
        $this->postProcessKeyValueCouple($harvester, $keyValueCouple);
    }

    private function parseMergeInstructionAtCurrentPosition(Harvester $harvester): MergeInstructionNode
    {
        $token = $harvester->tokens->current();
        if (TokenType::MERGE_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('There is no expected MERGE_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'));
        }
        $harvester->tokens->advance();

        $mergeInstruction = new MergeInstructionNode();

        $tmp = new KeyValueCoupleNode();
        $this->collectTypes($harvester, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $tmp);
        $tmp->setValue($this->parseValue($harvester, 0));

        $value = $tmp->getValue();
        if (null === $value) {
            throw new UnexpectedStateException('Merge instruction must have a value');
        }

        $aliases = $this->collectMergeAliases($value);
        foreach ($aliases as $alias) {
            $mergeInstruction->addAlias($alias);
        }

        return $mergeInstruction;
    }

    /**
     * YAML 1.2.2 §8.2.1 rule [185] s-l+block-indented(n,c): decides between
     *  - a compact in-line block mapping (rule [195] ns-l-compact-mapping),
     *    when the entry content starts with an implicit YAML key;
     *  - a generic block / flow / scalar node (delegated to {@see parseValue()}).
     *
     * $compactIndent is the column of the entry's first content character,
     * i.e. (indent of '-') + length('-') + length of WHITESPACE tokens
     * that follow '-'. Per §8.2.1 this length defines the indentation
     * of the nested compact collection.
     */
    private function parseSequenceEntryValue(Harvester $harvester, int $parentIndentLen, int $compactIndent): ValueNode
    {
        if ($this->isScalarFollowedByValueIndicator($harvester)) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->parseCompactBlockMapping($harvester, $compactIndent));

            return $valueNode;
        }

        return $this->parseValue($harvester, $parentIndentLen);
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

    private function parseTagDirective(Harvester $harvester): TagDirectiveNode
    {
        $token = $harvester->tokens->current();
        if (TokenType::DIRECTIVE_TAG !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('Expected DIRECTIVE_TAG token, but %s given', $token?->type->value ?? '_nothing_'));
        }

        $tagDirectiveNode = new TagDirectiveNode($token);
        $harvester->tokens->advance();

        $seenHandle = false;
        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException('Unexpected end of token stream: TAG directive handle and prefix are required');
            }

            if (TokenType::WHITESPACE === $token->type) {
                $tagDirectiveNode->addChild($this->createSimpleNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE_TAG_HANDLE === $token->type) {
                $seenHandle = true;
                $tagDirectiveNode->addChild(new TagDirectiveHandleNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE_TAG_PREFIX === $token->type) {
                if (!$seenHandle) {
                    throw new UnexpectedStateException('Expected TAG directive handle before prefix');
                }
                $tagDirectiveNode->addChild(new TagDirectivePrefixNode($token));
                $harvester->tokens->advance();

                $this->collectTypes($harvester, [
                    TokenType::WHITESPACE,
                    TokenType::COMMENT,
                    TokenType::NEWLINE,
                ], $tagDirectiveNode);

                return $tagDirectiveNode;
            }

            if (\in_array($token->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                throw new UnexpectedTokenException(\sprintf('Expected TAG directive handle and prefix before newline or comment, but %s given', $token->type->value));
            }

            throw new UnexpectedTokenException(\sprintf('Unexpected token in TAG directive: %s', $token->type->value));
        }
    }

    private function parseValue(Harvester $harvester, int $parentIndentLen): ValueNode
    {
        $valueNode = new ValueNode();

        $this->collectValueProperties($harvester, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $harvester->registry->anchors[$anchor->getName()] = $anchor;
        }

        $token = $harvester->tokens->current();
        if (null === $token) {
            return $valueNode;
        }
        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $valueNode->addChild(new BlockScalarIndicatorNode($token));
            $harvester->tokens->advance();
            $this->collectUntil($harvester, TokenType::NEWLINE, $valueNode);

            $token = $harvester->tokens->current();
            if (!$token) {
                return $valueNode;
            }

            if (TokenType::NEWLINE !== $token->type) {
                throw new UnexpectedTokenException(\sprintf('Unexpected newline, but %s given', $token->type->value));
            }
            $valueNode->addChild(new NewLineNode($token));
            $harvester->tokens->advance();

            $token = $harvester->tokens->current();
            if (!$token->type->isScalar()) {
                throw new UnexpectedTokenException(\sprintf('Scalar expected, but %s given', $token->type->value));
            }

            $valueNode->addChild(new ScalarNode($token));
            $harvester->tokens->advance();
        } elseif (TokenType::NEWLINE === $token->type) {
            $indented = $this->parseIndentedBlockValue($harvester, $parentIndentLen);
            if (null !== $indented) {
                $valueNode->addChild($indented);
            }
        } elseif ($token->type->isScalar()) {
            $valueNode->addChild(new ScalarNode($token));
            $harvester->tokens->advance();
        } elseif (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $harvester->registry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException(\sprintf('Undefined alias "%s"', $aliasName));
            }
            $aliasNode->setAnchor($anchor);
            $valueNode->addChild($aliasNode);
            $harvester->tokens->advance();
        } elseif (TokenType::SEQUENCE_ENTRY === $token->type) {
            $valueNode->addChild($this->parseBlockSequenceValue($harvester, $parentIndentLen));
        } elseif (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $valueNode->addChild($this->parseFlowSequence($harvester));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->parseFlowMapping($harvester));
        } else {
            throw new UnexpectedTokenException(\sprintf('Unexpected type while parsing of value: %s', $token->type->value));
        }

        $this->collectTypes($harvester, [
            TokenType::COMMENT,
            TokenType::WHITESPACE,
        ], $valueNode);

        return $valueNode;
    }

    private function parseYamlDirective(Harvester $harvester): YamlDirectiveNode
    {
        $token = $harvester->tokens->current();
        if (TokenType::DIRECTIVE_YAML !== $token?->type) {
            throw new UnexpectedTokenException(\sprintf('Expected DIRECTIVE_YAML token, but %s given', $token?->type->value ?? '_nothing_'));
        }

        $yamlDirectiveNode = new YamlDirectiveNode($token);
        $harvester->tokens->advance();

        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException('Unexpected end of token stream: YAML directive version is required');
            }

            if (\in_array($token->type, [TokenType::WHITESPACE, TokenType::VALUE_INDICATOR], true)) {
                $yamlDirectiveNode->addChild($this->createSimpleNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE_YAML_VERSION === $token->type) {
                $yamlDirectiveNode->addChild($this->createSimpleNode($token));
                $harvester->tokens->advance();

                $this->collectTypes($harvester, [
                    TokenType::WHITESPACE,
                    TokenType::COMMENT,
                    TokenType::NEWLINE,
                ], $yamlDirectiveNode);

                return $yamlDirectiveNode;
            }

            if (\in_array($token->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                throw new UnexpectedTokenException(\sprintf('Expected YAML directive version before newline or comment, but %s given', $token->type->value));
            }

            throw new UnexpectedTokenException(\sprintf('Unexpected token in YAML directive: %s', $token->type->value));
        }
    }

    private function postProcessKeyValueCouple(Harvester $harvester, KeyValueCoupleNode $couple): void
    {
        $valueNode = $couple->getValue();
        $anchor = $valueNode?->getAnchor();
        if (null !== $anchor) {
            $anchor->setDeclarationCouple($couple);
            $harvester->registry->anchors[$anchor->getName()] = $anchor;
        }
    }
}
