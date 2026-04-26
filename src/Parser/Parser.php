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
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\IndentationOverrideException;
use Aeliot\YamlToken\Parser\Exception\IndentationUndefinedException;
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
        TokenType::NEWLINE,
        TokenType::WHITESPACE,
    ];

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    private function appendTokenLocation(string $message, Token|TokenStreamProxy $tokens): string
    {
        $line = $tokens instanceof Token ? $tokens->line : $tokens->getLine();
        $column = $tokens instanceof Token ? $tokens->column : $tokens->getColumn();
        if (null !== $line && null !== $column) {
            $message .= \sprintf(' in line %d column %d', $line, $column);
        }

        return $message;
    }

    private function assertIndentLenIsValid(Harvester $harvester, int $indentLen): void
    {
        try {
            $harvester->state->assertIndentLenIsValid($indentLen);
        } catch (IndentationInvalidException|IndentationUndefinedException $e) {
            $this->wrapParseStateIndentationException($e, $harvester->tokens);
        }
    }

    /**
     * Consume one or more consecutive l-empty / l-comment lines whose
     * leading INDENTATION must not contribute to the surrounding block's
     * s-indent(n). Tokens are still attached to $root verbatim so the
     * emitter can reproduce the original text.
     */
    private function collectInsignificantIndentationLines(Harvester $harvester, Node $root): void
    {
        while ($this->isInsignificantIndentationLine($harvester)) {
            $token = $harvester->tokens->current();
            $root->addChild(new IndentationNode($token));
            $harvester->tokens->advance();
            $this->collectTypes($harvester, [
                TokenType::COMMENT,
                TokenType::NEWLINE,
                TokenType::WHITESPACE,
            ], $root);
        }
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
                throw new UnexpectedTokenException($this->appendTokenLocation('Tag body without tag handle', $token));
            }

            if (\in_array($token->type, [
                TokenType::TAG_HANDLE_NAMED,
                TokenType::TAG_HANDLE_PRIMARY,
                TokenType::TAG_HANDLE_SECONDARY,
                TokenType::TAG_HANDLE_VERBATIM,
                TokenType::TAG_NON_SPECIFIC,
            ], true)) {
                if (null !== $tagProperty) {
                    throw new UnexpectedStateException($this->appendTokenLocation('Only one tag property is supported per value node', $token));
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
                    throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Tag body expected, but %s given', $body?->type->value ?? '_nothing_'), $harvester->tokens));
                }

                $tagProperty->addChild(new TagBodyNode($body));
                $harvester->tokens->advance();
                continue;
            }

            break;
        }
    }

    private function collectKeyProperties(Harvester $harvester, KeyNode $keyNode): void
    {
        $tagProperty = null;

        while (!$harvester->tokens->isEnd()) {
            $token = $harvester->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                $keyNode->addChild(new WhitespaceNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                $keyNode->addChild(new AnchorNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::TAG_BODY === $token->type) {
                throw new UnexpectedTokenException($this->appendTokenLocation('Tag body without tag handle', $token));
            }

            if ($this->isNodePropertyToken($token)) {
                if (null !== $tagProperty) {
                    throw new UnexpectedStateException($this->appendTokenLocation('Only one tag property is supported per key node', $token));
                }

                $tagProperty = new TagPropertyNode();
                $tagProperty->addChild(new TagNode($token));
                $keyNode->addChild($tagProperty);
                $harvester->tokens->advance();

                if (\in_array($token->type, [TokenType::TAG_HANDLE_VERBATIM, TokenType::TAG_NON_SPECIFIC], true)) {
                    continue;
                }

                $this->collectTypes($harvester, [TokenType::WHITESPACE], $keyNode);

                $body = $harvester->tokens->current();
                if (TokenType::TAG_BODY !== $body?->type) {
                    throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Tag body expected, but %s given', $body?->type->value ?? '_nothing_'), $harvester->tokens));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('SEQUENCE_ENTRY expected, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
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
            default => throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Not configured node for token type: %s', $token->type->value), $token)),
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
        $this->collectKeyProperties($harvester, $keyNode);
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
                throw new UnexpectedTokenException($this->appendTokenLocation('Empty implicit key is not allowed in this context', $token));
            }

            return $keyNode;
        }

        if (
            null !== $keyNode->getExplicitKeyIndicatorNode()
            && TokenType::SEQUENCE_ENTRY === $token->type
        ) {
            // YAML 1.2.2 §8.2.2 rule [190] c-l-block-map-explicit-key(n):
            //   "?" s-l+block-indented(n, BLOCK-OUT)
            // Compact in-line form where '-' directly follows "? " on the
            // same line (Example 8.17). The nested block-sequence body
            // becomes a child of the KeyNode so the emitter preserves the
            // original text verbatim.
            $keyNode->addChild($this->parseCompactBlockSequence($harvester, $token->column - 1));

            return $keyNode;
        }

        if (!$token->type->isScalar() && !$token->type->isMergeIndicator()) {
            if (null !== $keyNode->getExplicitKeyIndicatorNode()) {
                return $keyNode;
            }

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Key scalar expected, but %s given', $token->type->value), $token));
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

    /**
     * YAML 1.2.2 §6.4 / §6.6: detects a line that is either entirely empty
     * (l-empty) or contains only a comment (l-comment), possibly with
     * leading whitespace. Such a line's leading INDENTATION token is part
     * of s-separate-in-line, not of block s-indent(n), and must not be
     * registered as the document's indent step nor validated against it.
     */
    private function isInsignificantIndentationLine(Harvester $harvester): bool
    {
        if (TokenType::INDENTATION !== $harvester->tokens->current()?->type) {
            return false;
        }

        for ($offset = 1;; ++$offset) {
            $token = $harvester->tokens->peek($offset);
            if (null === $token || TokenType::NEWLINE === $token->type) {
                return true;
            }
            if (TokenType::COMMENT !== $token->type && TokenType::WHITESPACE !== $token->type) {
                return false;
            }
        }
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

    private function isKeyValueCoupleStartAllowingNodeProperties(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        if ($this->isNodePropertyToken($token)) {
            return true;
        }

        return $this->isKeyValueCoupleStart($harvester);
    }

    /**
     * YAML 1.2.2 §8.2 rule [200] s-l+block-collection(n,c): before the block
     * sequence or block mapping body a node may carry c-ns-properties(n+1,c)
     * (tag and/or anchor, rule [96]) — optionally on their own line. At the
     * bare document root this is reached via rule [211] l-bare-document ::=
     * s-l+block-node(-1, block-in) (§9.1.3) → [196] → [198] → [200].
     *
     * Detects such a node-property prefix at the document root by peeking past
     * a possible leading INDENTATION token.
     */
    private function isNodePropertyAtDocumentRoot(Harvester $harvester): bool
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            return false;
        }
        if (TokenType::INDENTATION === $token->type) {
            $token = $harvester->tokens->peek(1);
        }

        return null !== $token && \in_array($token->type, [
            TokenType::ANCHOR,
            TokenType::TAG_HANDLE_NAMED,
            TokenType::TAG_HANDLE_PRIMARY,
            TokenType::TAG_HANDLE_SECONDARY,
            TokenType::TAG_HANDLE_VERBATIM,
            TokenType::TAG_NON_SPECIFIC,
        ], true);
    }

    private function isNodePropertyToken(?Token $token): bool
    {
        if (null === $token) {
            return false;
        }

        return \in_array($token->type, [
            TokenType::ANCHOR,
            TokenType::TAG_HANDLE_NAMED,
            TokenType::TAG_HANDLE_PRIMARY,
            TokenType::TAG_HANDLE_SECONDARY,
            TokenType::TAG_HANDLE_VERBATIM,
            TokenType::TAG_NON_SPECIFIC,
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
            $this->collectInsignificantIndentationLines($harvester, $blockMapping);

            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }

            // Column-0 entries (bare document root, parent indent n = -1 per rule [211])
            // do not have an INDENTATION token emitted by the lexer.
            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif ($parentIndentLen < 0 && $this->isKeyValueCoupleStart($harvester)) {
                $indentLen = 0;
            } else {
                break;
            }

            if ($indentLen > 0) {
                $this->registerIndentStepIfNeeded($harvester, $indentLen);
                $this->assertIndentLenIsValid($harvester, $indentLen);
            }

            if ($indentLen <= $parentIndentLen) {
                break;
            }

            if (null === $baseIndentLen) {
                $baseIndentLen = $indentLen;
            } elseif ($indentLen < $baseIndentLen) {
                throw new IndentationInvalidException($this->appendTokenLocation(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen), $token));
            } elseif ($indentLen > $baseIndentLen && $previousCoupleIndentLen === $baseIndentLen) {
                throw new IndentationInvalidException($this->appendTokenLocation(\sprintf('Unexpected indentation %d for next key/value couple; expected %d', $indentLen, $baseIndentLen), $token));
            }

            if (false === $this->isKeyValueCoupleStartAllowingNodeProperties($harvester)) {
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Key/value couple expected while parsing block mapping value, but %s given', $harvester->tokens->current()?->type->value ?? '_nothing_'), $token));
            }

            $previousCoupleIndentLen = $indentLen;
            $mergeCandidate = TokenType::INDENTATION === $token->type
                ? $harvester->tokens->peek(1)
                : $token;
            if (TokenType::MERGE_INDICATOR === $mergeCandidate?->type) {
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

    private function parseBlockSequenceValue(Harvester $harvester, int $parentIndentLen, bool $allowNonSequenceAtBaseIndentAsTerminator = false): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $baseIndentLen = null;

        while (!$harvester->tokens->isEnd()) {
            $this->collectTypes($harvester, [
                TokenType::NEWLINE,
                TokenType::COMMENT,
                TokenType::WHITESPACE,
            ], $blockSequence);
            $this->collectInsignificantIndentationLines($harvester, $blockSequence);

            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }

            // Column-0 entries (bare document root, parent indent n = -1 per rule [211])
            // do not have an INDENTATION token emitted by the lexer.
            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif ($parentIndentLen < 0 && TokenType::SEQUENCE_ENTRY === $token->type) {
                $indentLen = 0;
            } else {
                break;
            }

            if ($indentLen > 0) {
                $this->registerIndentStepIfNeeded($harvester, $indentLen);
                $this->assertIndentLenIsValid($harvester, $indentLen);
            }

            if ($indentLen <= $parentIndentLen) {
                break;
            }

            if (null === $baseIndentLen) {
                $baseIndentLen = $indentLen;
            } elseif ($indentLen !== $baseIndentLen) {
                throw new IndentationInvalidException($this->appendTokenLocation(\sprintf('Unexpected indentation %d while base indentation is %d', $indentLen, $baseIndentLen), $token));
            }

            if (false === $this->isSequenceStart($harvester)) {
                if ($allowNonSequenceAtBaseIndentAsTerminator && $indentLen === $baseIndentLen) {
                    break;
                }
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Sequence entry expected while parsing block sequence value, but %s given', $harvester->tokens->current()?->type->value ?? '_nothing_'), $token));
            }

            $sequenceEntry = new SequenceEntryNode();
            $blockSequence->addChild($sequenceEntry);
            if (TokenType::INDENTATION === $token->type) {
                $sequenceEntry->addChild(new IndentationNode($token));
                $harvester->tokens->advance();
            }

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
            $this->collectInsignificantIndentationLines($harvester, $blockMapping);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::INDENTATION !== $token->type) {
                break;
            }
            if (\strlen($token->text) !== $indentLen) {
                break;
            }
            if (!$this->isKeyValueCoupleStartAllowingNodeProperties($harvester)) {
                break;
            }

            $this->parseKeyValueCoupleAtCurrentPosition($harvester, $blockMapping, $indentLen);
        }

        return $blockMapping;
    }

    /**
     * YAML 1.2.2 §8.2.1 rule [186] ns-l-compact-sequence(n):
     *   c-l-block-seq-entry(n) ( s-indent(n) c-l-block-seq-entry(n) )*
     *
     * The first entry is parsed at the current stream position (no leading
     * INDENTATION token — the caller has already consumed the enclosing
     * indicator, e.g. '-', '?' or ':' together with its trailing spaces,
     * so we sit directly on the nested '-'). Subsequent entries require
     * an INDENTATION token whose length equals $indentLen — the column
     * (0-based) of the first '-', i.e. the value of n in rule [186].
     */
    private function parseCompactBlockSequence(Harvester $harvester, int $indentLen): BlockSequenceNode
    {
        $blockSequence = new BlockSequenceNode();

        $firstEntry = new SequenceEntryNode();
        $blockSequence->addChild($firstEntry);
        $firstCompactIndent = $indentLen + $this->consumeSequenceEntryIndicatorAndSpaces($harvester, $firstEntry);
        $firstEntry->setValue($this->parseSequenceEntryValue($harvester, $indentLen, $firstCompactIndent));

        while (!$harvester->tokens->isEnd()) {
            $this->collectTypes($harvester, [
                TokenType::NEWLINE,
                TokenType::COMMENT,
                TokenType::WHITESPACE,
            ], $blockSequence);
            $this->collectInsignificantIndentationLines($harvester, $blockSequence);

            $token = $harvester->tokens->current();
            if (null === $token || TokenType::INDENTATION !== $token->type) {
                break;
            }
            if (\strlen($token->text) !== $indentLen) {
                break;
            }
            if (!$this->isSequenceStart($harvester)) {
                break;
            }

            $sequenceEntry = new SequenceEntryNode();
            $blockSequence->addChild($sequenceEntry);
            $sequenceEntry->addChild(new IndentationNode($token));
            $harvester->tokens->advance();

            $compactIndent = $indentLen + $this->consumeSequenceEntryIndicatorAndSpaces($harvester, $sequenceEntry);
            $sequenceEntry->setValue($this->parseSequenceEntryValue($harvester, $indentLen, $compactIndent));
        }

        return $blockSequence;
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

            // YAML 1.2.2 §6.6 Comments: "Comments must be separated from other tokens by white space characters."
            // Handles `s-separate-in-line` between a preceding token on the same line (e.g. DOCUMENT_START/END) and a trailing comment.
            if (TokenType::WHITESPACE === $token->type && TokenType::COMMENT === $harvester->tokens->peek(1)?->type) {
                $document->addChild(new WhitespaceNode($token));
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

            if ($this->isNodePropertyAtDocumentRoot($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->parseValue($harvester, -1));
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

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected type: %s', $token->type->value), $token));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected FLOW_MAPPING_START token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected FLOW_MAPPING_END token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected FLOW_SEQUENCE_START token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected FLOW_SEQUENCE_END token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
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
     * Both alternatives of rule [150] ns-flow-pair(n,c) are supported:
     *  - explicit form starting with '?' (Example 7.20), which per the prose
     *    above [150] has the same syntax as ns-flow-map-explicit-entry [143]
     *    and therefore permits an empty key and/or an empty value (e-node);
     *  - implicit YAML-key form, detected via {@see isScalarFollowedByValueIndicator()}.
     *
     * Both paths build the couple using the same helpers as {@see parseFlowMapping()}
     * so that whitespace tokens between the key and ':' end up attached to the
     * KeyValueCoupleNode (matching c-ns-flow-map-separate-value, rule [148]).
     *
     * The JSON-key adjacent value form (Example 7.21, rule [153]) is still out of scope.
     */
    private function parseFlowSequenceEntry(Harvester $harvester): Node
    {
        $isExplicitKeyPair = TokenType::EXPLICIT_KEY_INDICATOR === $harvester->tokens->current()?->type;

        if (!$isExplicitKeyPair && !$this->isScalarFollowedByValueIndicator($harvester)) {
            return $this->parseValue($harvester, 0);
        }

        $couple = new KeyValueCoupleNode();
        $couple->setKey($this->getKeyNode($harvester, $isExplicitKeyPair));

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

    private function parseIndentedBlockValue(Harvester $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        $token = $harvester->tokens->current();
        if (TokenType::NEWLINE !== $token?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected NEWLINE while parsing indented block value, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        // YAML 1.2.2 §6.6: look past any l-empty / l-comment lines to find the
        // first significant content. Otherwise, a comment-only line indented
        // deeper than the key (e.g. "first:\n    # comment") is mistaken for
        // the value's content and triggers "Empty block mapping value".
        $head = $this->peekFirstSignificantBlockHead($harvester);
        if (null === $head) {
            return;
        }
        [$indentLen, $afterIndent, $afterIndentOffset] = $head;

        if ($indentLen > 0) {
            // YAML 1.2.2 §8.2.1 "indentless sequences":
            // a block mapping value may be a block sequence whose entries start at the same
            // indentation level as the mapping key (common in Kubernetes manifests):
            //
            //   key:
            //   - item
            //
            // Here $indentLen equals $parentIndentLen (indentation of the key line).
            if ($indentLen === $parentIndentLen && TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $valueNode->addChild($this->parseBlockSequenceValue($harvester, $parentIndentLen - 1, true));

                return;
            }

            if ($indentLen <= $parentIndentLen) {
                return;
            }

            // YAML 1.2.2 §8.2 rule [200] s-l+block-collection(n,c): a node may
            // have c-ns-properties(n+1,c) (tag and/or anchor), optionally on their
            // own line, before the actual collection body.
            //
            // If the first significant line starts with node properties and the line
            // ends immediately after them, treat it as value properties. Otherwise,
            // it's a tagged/anchored key in a nested block mapping.
            if ($this->isNodePropertyToken($afterIndent) && $this->isNodePropertiesOnlyLine($harvester, $afterIndentOffset)) {
                $valueNode->addChild(new NewLineNode($token));
                $harvester->tokens->advance();
                $this->collectTypes($harvester, [
                    TokenType::COMMENT,
                    TokenType::NEWLINE,
                    TokenType::WHITESPACE,
                ], $valueNode);
                $this->collectInsignificantIndentationLines($harvester, $valueNode);

                $indentationToken = $harvester->tokens->current();
                if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                    throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected INDENTATION before node properties, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
                }
                $valueNode->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();

                $this->collectValueProperties($harvester, $valueNode);

                $next = $harvester->tokens->current();
                if (null === $next || TokenType::NEWLINE !== $next->type) {
                    throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected NEWLINE after node properties, but %s given', $next?->type->value ?? '_nothing_'), $harvester->tokens));
                }

                $this->parseIndentedBlockValue($harvester, $valueNode, $parentIndentLen);

                return;
            }

            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $valueNode->addChild($this->parseBlockSequenceValue($harvester, $parentIndentLen));

                return;
            }

            // YAML 1.2.2 §8.2.3 / rule [197] s-l+flow-in-block: a block mapping value
            // may hold a flow node placed on the next line, indented by at least n+1.
            // Per rule [81] s-separate-lines(n) → [79] s-l-comments → l-comment*,
            // any number of l-empty / l-comment lines (including column-0 comments,
            // see [78] l-comment + [66] s-separate-in-line) may sit between the ':'
            // and the flow node.
            if (
                TokenType::FLOW_SEQUENCE_START === $afterIndent->type
                || TokenType::FLOW_MAPPING_START === $afterIndent->type
            ) {
                $valueNode->addChild(new NewLineNode($token));
                $harvester->tokens->advance();
                $this->collectTypes($harvester, [
                    TokenType::COMMENT,
                    TokenType::NEWLINE,
                    TokenType::WHITESPACE,
                ], $valueNode);
                $this->collectInsignificantIndentationLines($harvester, $valueNode);

                $indentationToken = $harvester->tokens->current();
                if (null === $indentationToken || TokenType::INDENTATION !== $indentationToken->type) {
                    throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected INDENTATION before flow node, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
                }
                $valueNode->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();

                $valueNode->addChild(
                    TokenType::FLOW_SEQUENCE_START === $afterIndent->type
                        ? $this->parseFlowSequence($harvester)
                        : $this->parseFlowMapping($harvester),
                );

                return;
            }

            $valueNode->addChild($this->parseBlockMappingValue($harvester, $parentIndentLen));

            return;
        }

        // Column-0 block collection (no leading INDENTATION token) — only
        // accepted at bare document root (n = -1 per YAML 1.2.2 rule [211]).
        if ($parentIndentLen < 0) {
            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $valueNode->addChild($this->parseBlockSequenceValue($harvester, $parentIndentLen));

                return;
            }
            if (
                TokenType::EXPLICIT_KEY_INDICATOR === $afterIndent->type
                || TokenType::MERGE_INDICATOR === $afterIndent->type
                || $afterIndent->type->isScalar()
            ) {
                $valueNode->addChild($this->parseBlockMappingValue($harvester, $parentIndentLen));
            }
        }
    }

    private function parseKeyValueCoupleAtCurrentPosition(Harvester $harvester, Node $root, int $indentLen): void
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            throw new UnexpectedEndException($this->appendTokenLocation('Unexpected end of stream while parsing key/value couple', $harvester->tokens));
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
        $mergeInstruction = new MergeInstructionNode();

        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token?->type) {
            $mergeInstruction->addChild(new IndentationNode($token));
            $harvester->tokens->advance();
            $token = $harvester->tokens->current();
        }

        if (TokenType::MERGE_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected MERGE_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }
        $mergeInstruction->addChild(new SyntaxTokenNode($token));
        $harvester->tokens->advance();

        $this->collectTypes($harvester, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $mergeInstruction);

        $value = $this->parseValue($harvester, 0);
        $mergeInstruction->addChild($value);

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
     *  - a compact in-line block sequence (rule [186] ns-l-compact-sequence),
     *    when the entry content starts with another '-' on the same line
     *    (Example 8.15);
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

        if (TokenType::SEQUENCE_ENTRY === $harvester->tokens->current()?->type) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->parseCompactBlockSequence($harvester, $compactIndent));

            return $valueNode;
        }

        return $this->parseValue($harvester, $parentIndentLen);
    }

    private function parseStream(TokenStream $tokens): StreamNode
    {
        $harvester = new Harvester(new TokenStreamProxy($tokens));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected DIRECTIVE_TAG token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $tagDirectiveNode = new TagDirectiveNode($token);
        $harvester->tokens->advance();

        $seenHandle = false;
        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException($this->appendTokenLocation('Unexpected end of token stream: TAG directive handle and prefix are required', $harvester->tokens));
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
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected TAG directive handle and prefix before newline or comment, but %s given', $token->type->value), $token));
            }

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected token in TAG directive: %s', $token->type->value), $token));
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
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected newline, but %s given', $token->type->value), $token));
            }
            $valueNode->addChild(new NewLineNode($token));
            $harvester->tokens->advance();

            // YAML 1.2.2 §8.1.1.1: with an explicit indentation indicator (|N, >N, |N-, >N+, ...),
            // the body may start with leading spaces that are part of the content but surface
            // to the parser as a separate INDENTATION token before the scalar payload.
            if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
                $valueNode->addChild(new IndentationNode($harvester->tokens->current()));
                $harvester->tokens->advance();
            }

            $token = $harvester->tokens->current();
            if (!$token->type->isScalar()) {
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Scalar expected, but %s given', $token->type->value), $token));
            }

            $valueNode->addChild(new ScalarNode($token));
            $harvester->tokens->advance();

            // YAML 1.2.2 §8.1.1.2 / rule [166]-[168] l-chomped-empty(n,t):
            // trailing "empty" indented lines belong to the block scalar and must be
            // consumed here (even with strip chomping they are excluded from content but
            // still consumed from the token stream).
            while (true) {
                $newLineToken = $harvester->tokens->current();
                if (TokenType::NEWLINE !== $newLineToken?->type) {
                    break;
                }
                $indentationToken = $harvester->tokens->peek(1);
                if (TokenType::INDENTATION !== $indentationToken?->type) {
                    break;
                }
                $afterIndentation = $harvester->tokens->peek(2);
                if (null !== $afterIndentation && TokenType::NEWLINE !== $afterIndentation->type) {
                    break;
                }
                $valueNode->addChild(new NewLineNode($newLineToken));
                $harvester->tokens->advance();
                $valueNode->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();
            }
        } elseif (TokenType::NEWLINE === $token->type) {
            $this->parseIndentedBlockValue($harvester, $valueNode, $parentIndentLen);
        } elseif ($token->type->isScalar()) {
            $valueNode->addChild(new ScalarNode($token));
            $harvester->tokens->advance();

            // YAML 1.2.2 §7.3.3 / §8.1.1: plain scalars in block context may span multiple lines.
            // The lexer emits them as a sequence of:
            //   PLAIN_SCALAR NEWLINE INDENTATION PLAIN_SCALAR ...
            // When such a continuation line is indented deeper than the parent node indentation,
            // it belongs to the same scalar (not to the surrounding block collection).
            if (TokenType::PLAIN_SCALAR === $token->type) {
                while (TokenType::NEWLINE === $harvester->tokens->current()?->type) {
                    $newLine = $harvester->tokens->current();
                    $indentation = $harvester->tokens->peek(1);
                    $afterIndent = $harvester->tokens->peek(2);
                    if (TokenType::INDENTATION !== $indentation?->type || !$afterIndent?->type->isScalar()) {
                        break;
                    }

                    $indentLen = \strlen($indentation->text);
                    if ($indentLen <= $parentIndentLen) {
                        break;
                    }

                    // Do not steal a nested block mapping entry key (implicit YAML key).
                    $offset = 3;
                    while (TokenType::WHITESPACE === $harvester->tokens->peek($offset)?->type) {
                        ++$offset;
                    }
                    if (TokenType::VALUE_INDICATOR === $harvester->tokens->peek($offset)?->type) {
                        break;
                    }

                    $valueNode->addChild(new NewLineNode($newLine));
                    $harvester->tokens->advance();
                    $valueNode->addChild(new IndentationNode($indentation));
                    $harvester->tokens->advance();
                    $valueNode->addChild(new ScalarNode($afterIndent));
                    $harvester->tokens->advance();
                }
            }
        } elseif (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $harvester->registry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException($this->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
            }
            $aliasNode->setAnchor($anchor);
            $valueNode->addChild($aliasNode);
            $harvester->tokens->advance();
        } elseif (TokenType::SEQUENCE_ENTRY === $token->type) {
            $valueNode->addChild($this->parseCompactBlockSequence($harvester, $token->column - 1));
        } elseif (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $valueNode->addChild($this->parseFlowSequence($harvester));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->parseFlowMapping($harvester));
        } else {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected type while parsing of value: %s', $token->type->value), $token));
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
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected DIRECTIVE_YAML token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $yamlDirectiveNode = new YamlDirectiveNode($token);
        $harvester->tokens->advance();

        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException($this->appendTokenLocation('Unexpected end of token stream: YAML directive version is required', $harvester->tokens));
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
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected YAML directive version before newline or comment, but %s given', $token->type->value), $token));
            }

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected token in YAML directive: %s', $token->type->value), $token));
        }
    }

    /**
     * Look-ahead from the current token (expected NEWLINE) through any number
     * of l-empty / l-comment lines (per YAML 1.2.2 §6.6) to find the first
     * line that carries significant content. Used by parseIndentedBlockValue
     * to decide whether the value of a `key:` is empty or holds a nested
     * block / column-0 collection — without prematurely consuming any tokens.
     *
     * A line is considered insignificant when it consists exclusively of
     * WHITESPACE / COMMENT tokens (optionally prefixed by an INDENTATION
     * token) and is terminated by NEWLINE or end-of-stream. Both indented
     * comment lines (`    # ...`) and column-0 comment lines (`# ...`) are
     * skipped, since the lexer omits the leading INDENTATION token only
     * for the latter.
     *
     * @return array{int, Token, int}|null Tuple of [indentLen, significantToken, offset] pointing
     *                                     at the first significant line:
     *                                     - indentLen is the byte-length of that line's
     *                                     leading INDENTATION token (0 for column-0 lines);
     *                                     - significantToken is the first non-WHITESPACE/COMMENT
     *                                     token of that line.
     *                                     - offset is the TokenStreamProxy peek offset of significantToken.
     *                                     Returns null if the stream ends with only insignificant lines.
     */
    private function peekFirstSignificantBlockHead(Harvester $harvester): ?array
    {
        $offset = 1;
        while (true) {
            $token = $harvester->tokens->peek($offset);
            if (null === $token) {
                return null;
            }

            if (TokenType::NEWLINE === $token->type) {
                ++$offset;
                continue;
            }

            $hasIndentation = TokenType::INDENTATION === $token->type;
            $indentLen = $hasIndentation ? \strlen($token->text) : 0;
            $probe = $hasIndentation ? $offset + 1 : $offset;

            while (true) {
                $candidate = $harvester->tokens->peek($probe);
                if (null === $candidate || TokenType::NEWLINE === $candidate->type) {
                    $offset = null === $candidate ? $probe : $probe + 1;
                    continue 2;
                }
                if (TokenType::COMMENT !== $candidate->type && TokenType::WHITESPACE !== $candidate->type) {
                    return [$indentLen, $candidate, $probe];
                }
                ++$probe;
            }
        }
    }

    /**
     * @param int $offset Offset to the first non-WHITESPACE/COMMENT token of the line
     */
    private function isNodePropertiesOnlyLine(Harvester $harvester, int $offset): bool
    {
        $i = $offset;
        $seenTag = false;

        while (true) {
            $token = $harvester->tokens->peek($i);
            if (null === $token) {
                return true;
            }
            if (TokenType::NEWLINE === $token->type) {
                return true;
            }
            if (TokenType::WHITESPACE === $token->type || TokenType::COMMENT === $token->type) {
                ++$i;
                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                ++$i;
                continue;
            }

            if (TokenType::TAG_BODY === $token->type) {
                return false;
            }

            if ($this->isNodePropertyToken($token)) {
                if ($seenTag) {
                    return false;
                }
                $seenTag = true;
                ++$i;

                if (\in_array($token->type, [TokenType::TAG_HANDLE_VERBATIM, TokenType::TAG_NON_SPECIFIC], true)) {
                    continue;
                }

                while (TokenType::WHITESPACE === $harvester->tokens->peek($i)?->type) {
                    ++$i;
                }

                if (TokenType::TAG_BODY !== $harvester->tokens->peek($i)?->type) {
                    return false;
                }
                ++$i;
                continue;
            }

            return false;
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

    private function registerIndentStepIfNeeded(Harvester $harvester, int $indentLen): void
    {
        if ($harvester->state->isIndentLenRegistered()) {
            return;
        }

        try {
            $harvester->state->registerIndentStepLen($indentLen);
        } catch (IndentationInvalidException|IndentationOverrideException $e) {
            $this->wrapParseStateIndentationException($e, $harvester->tokens);
        }
    }

    private function wrapParseStateIndentationException(\Exception $previous, TokenStreamProxy $tokens): void
    {
        throw new ($previous::class)($this->appendTokenLocation($previous->getMessage(), $tokens), (int) $previous->getCode(), $previous);
    }
}
