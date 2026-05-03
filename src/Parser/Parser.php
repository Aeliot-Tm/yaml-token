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
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagDirectiveHandleNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Node\TagDirectivePrefixNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Node\YamlDirectiveVersionNode;
use Aeliot\YamlToken\Parser\Builder\FlowMappingBuilder;
use Aeliot\YamlToken\Parser\Builder\FlowSequenceBuilder;
use Aeliot\YamlToken\Parser\Driver\Driver;
use Aeliot\YamlToken\Parser\Driver\Frame;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Dto\ParseRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\IndentationOverrideException;
use Aeliot\YamlToken\Parser\Exception\IndentationUndefinedException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedEndException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Flow\FlowHost;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Parser
{
    /**
     * Bare-document block parent indent (YAML 1.2.2 rule [211], grammar uses n = -1). Not a column count;
     * keeps “$lineIndent <= $parentIndent” checks uniform: no non-negative indent is <= this value.
     */
    private const BARE_DOCUMENT_BLOCK_PARENT_INDENT = -1;

    /**
     * Sentinel for {@see parseValue()} when the value is parsed inside a flow collection or merge RHS.
     * Flow lines use {@see TokenType::WHITESPACE} (not {@see TokenType::INDENTATION}) before the node,
     * so a newline-prefixed value must not use block-oriented {@see parseIndentedBlockValue()} with indent 0.
     */
    private const FLOW_COLLECTION_VALUE_PARENT_INDENT = -2;

    private const TOKEN_TYPES_SPASE_AND_COMMENT = [
        TokenType::COMMENT,
        TokenType::NEWLINE,
        TokenType::WHITESPACE,
    ];

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    /**
     * Appends NEWLINE / INDENTATION / scalar chunks for multiline plain scalars and for | / > block bodies.
     *
     * @see Parser::parseValue() YAML 1.2.2 §7.3.3 / §8.1.1
     */
    private function appendMultilinePlainScalarContinuations(Harvester $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        while (true) {
            while (
                TokenType::WHITESPACE === $harvester->tokens->current()?->type
                && TokenType::NEWLINE === $harvester->tokens->peek(1)?->type
            ) {
                $valueNode->addChild(new WhitespaceNode($harvester->tokens->current()));
                $harvester->tokens->advance();
            }

            if (TokenType::NEWLINE !== $harvester->tokens->current()?->type) {
                break;
            }

            $newLine = $harvester->tokens->current();

            // Physical empty line between indented continuation lines: lexer emits two NEWLINE tokens
            // (YAML 1.2.2 §6.5 / §7.3.3 multiline plain, e.g. Example 7.12 Plain Lines). Only consume when
            // the same continuation probe as below still applies after the gap (avoid stealing structure
            // where the second NEWLINE starts unrelated content).
            if (TokenType::NEWLINE === $harvester->tokens->peek(1)?->type) {
                $continuesAfterBlankLine =
                    $this->isIndentedMultilinePlainContinuationAt($harvester, 2, $parentIndentLen)
                    || (
                        self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen
                        && $this->isBareDocumentFlushMultilinePlainContinuationAt($harvester, 2)
                    );
                if (!$continuesAfterBlankLine) {
                    break;
                }

                $valueNode->addChild(new NewLineNode($newLine));
                $harvester->tokens->advance();
                continue;
            }

            // Empty continuation line: INDENTATION (spaces) then only WHITESPACE (e.g. tab) before the
            // line break — Lexer emits tab as WHITESPACE. Leave the closing NEWLINE for the next iteration
            // so the following fragment still gets a leading NewLineNode like other continuations.
            $maybeIndent = $harvester->tokens->peek(1);
            if (TokenType::INDENTATION === $maybeIndent?->type && \strlen($maybeIndent->text) > $parentIndentLen) {
                $afterIndentOffset = 2;
                while (TokenType::WHITESPACE === $harvester->tokens->peek($afterIndentOffset)?->type) {
                    ++$afterIndentOffset;
                }
                if (
                    TokenType::NEWLINE === $harvester->tokens->peek($afterIndentOffset)?->type
                    && (
                        $this->isIndentedMultilinePlainContinuationAt($harvester, $afterIndentOffset + 1, $parentIndentLen)
                        || (
                            self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen
                            && $this->isBareDocumentFlushMultilinePlainContinuationAt($harvester, $afterIndentOffset + 1)
                        )
                    )
                ) {
                    $valueNode->addChild(new NewLineNode($newLine));
                    $harvester->tokens->advance();
                    $indentationToken = $harvester->tokens->current();
                    if (TokenType::INDENTATION !== $indentationToken->type) {
                        throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected INDENTATION after newline in multiline plain empty line, got %s', $indentationToken->type->value), $harvester->tokens));
                    }
                    $valueNode->addChild(new IndentationNode($indentationToken));
                    $harvester->tokens->advance();
                    for ($w = 2; $w < $afterIndentOffset; ++$w) {
                        $wsToken = $harvester->tokens->current();
                        if (TokenType::WHITESPACE !== $wsToken->type) {
                            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected WHITESPACE in multiline plain empty line, got %s', $wsToken->type->value), $harvester->tokens));
                        }
                        $valueNode->addChild(new WhitespaceNode($wsToken));
                        $harvester->tokens->advance();
                    }
                    $closingNewline = $harvester->tokens->current();
                    if (TokenType::NEWLINE !== $closingNewline->type) {
                        throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected NEWLINE after multiline plain empty line content, got %s', $closingNewline->type->value), $harvester->tokens));
                    }
                    continue;
                }
            }

            if ($this->isIndentedMultilinePlainContinuationAt($harvester, 1, $parentIndentLen)) {
                $indentation = $harvester->tokens->peek(1);

                $valueNode->addChild(new NewLineNode($newLine));
                $valueNode->addChild(new IndentationNode($indentation));
                $harvester->tokens->advance();
                $harvester->tokens->advance();

                $contentHead = $harvester->tokens->current();
                while (TokenType::WHITESPACE === $contentHead->type) {
                    $valueNode->addChild(new WhitespaceNode($contentHead));
                    $harvester->tokens->advance();
                    $contentHead = $harvester->tokens->current();
                }

                $valueNode->addChild(new ScalarNode($contentHead));
                $harvester->tokens->advance();

                continue;
            }

            if (
                self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen
                && $this->isBareDocumentFlushMultilinePlainContinuationAt($harvester, 1)
            ) {
                $valueNode->addChild(new NewLineNode($newLine));
                $harvester->tokens->advance();

                $contentHead = $harvester->tokens->current();
                while (TokenType::WHITESPACE === $contentHead->type) {
                    $valueNode->addChild(new WhitespaceNode($contentHead));
                    $harvester->tokens->advance();
                    $contentHead = $harvester->tokens->current();
                }

                $valueNode->addChild(new ScalarNode($contentHead));
                $harvester->tokens->advance();

                continue;
            }

            break;
        }
    }

    /**
     * Flow-context counterpart of {@see appendMultilinePlainScalarContinuations()}: consumes one or more
     * NEWLINE + WHITESPACE* + PLAIN_SCALAR continuation chunks for a plain-scalar key inside a flow
     * mapping (YAML 1.2.2 §7.3.3 / §7.4.1). The lexer emits WHITESPACE — not INDENTATION — for leading
     * spaces inside `{...}`, so the block-context helpers cannot be reused. Each consumed PLAIN_SCALAR
     * is appended via {@see KeyNode::addScalarName()}, which automatically wraps repeated fragments
     * into a {@see MultilinePlainScalarNode}.
     */
    private function appendFlowKeyMultilinePlainScalarContinuations(Harvester $harvester, KeyNode $keyNode): void
    {
        $name = $keyNode->getName();
        if (!$name instanceof ScalarNode || TokenType::PLAIN_SCALAR !== $name->getToken()->type) {
            return;
        }

        while (TokenType::NEWLINE === $harvester->tokens->current()?->type) {
            $newLine = $harvester->tokens->current();
            $scalarOffset = 1;
            while (TokenType::WHITESPACE === $harvester->tokens->peek($scalarOffset)?->type) {
                ++$scalarOffset;
            }
            $scalarToken = $harvester->tokens->peek($scalarOffset);
            if (TokenType::PLAIN_SCALAR !== $scalarToken?->type) {
                break;
            }

            $keyNode->addChild(new NewLineNode($newLine));
            $harvester->tokens->advance();

            $contentHead = $harvester->tokens->current();
            while (TokenType::WHITESPACE === $contentHead->type) {
                $keyNode->addChild(new WhitespaceNode($contentHead));
                $harvester->tokens->advance();
                $contentHead = $harvester->tokens->current();
            }

            $keyNode->addScalarName(new ScalarNode($scalarToken));
            $harvester->tokens->advance();
        }
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

    private function collectKeyProperties(Harvester $harvester, KeyNode $keyNode): void
    {
        $properties = null;
        $whitespaceBuffer = [];

        while (!$harvester->tokens->isEnd()) {
            $token = $harvester->tokens->current();
            if (TokenType::WHITESPACE === $token->type) {
                if (null === $properties) {
                    $keyNode->addChild(new WhitespaceNode($token));
                } else {
                    $whitespaceBuffer[] = new WhitespaceNode($token);
                }
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::ANCHOR === $token->type) {
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->setAnchor(new AnchorNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if ($this->isNodePropertyToken($token)) {
                if (null !== $properties?->getTag()) {
                    throw new UnexpectedStateException($this->appendTokenLocation('Only one tag is supported per key node', $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->setTag(new TagNode($token));
                $harvester->tokens->advance();
                continue;
            }

            break;
        }

        if (null !== $properties) {
            $keyNode->setProperties($properties);
        }
        foreach ($whitespaceBuffer as $whitespace) {
            $keyNode->addChild($whitespace);
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
            $entryAliases = array_values(array_filter(
                $entry->getChildren(),
                static fn (Node $n): bool => $n instanceof AliasNode,
            ));
            if (1 !== \count($entryAliases)) {
                $references = array_map(static fn (AliasNode $a): string => $a->getToken()->text, $entryAliases);
                throw new UnexpectedStateException(\sprintf('Each merge sequence entry must contain exactly one alias but %d given: %s', \count($references), implode(', ', $references)));
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
        $properties = null;
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
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->setAnchor(new AnchorNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::TAG === $token->type) {
                if (null !== $properties?->getTag()) {
                    throw new UnexpectedStateException($this->appendTokenLocation('Only one tag is supported per value node', $token));
                }
                $properties ??= new NodePropertiesNode();
                foreach ($whitespaceBuffer as $whitespace) {
                    $properties->addChild($whitespace);
                }
                $whitespaceBuffer = [];
                $properties->setTag(new TagNode($token));
                $harvester->tokens->advance();
                continue;
            }

            break;
        }

        if (null !== $properties) {
            $valueNode->setProperties($properties);
        }
        foreach ($whitespaceBuffer as $whitespace) {
            $valueNode->addChild($whitespace);
        }
    }

    /**
     * TODO: refactor similar methods: consumeExplicitKeyMultilinePlainScalarFirstLine & consumeExplicitKeyMultilinePlainScalarContinuation.
     */
    private function consumeExplicitKeyMultilinePlainScalarContinuation(Harvester $harvester, KeyNode $keyNode, int $entryIndentLen): void
    {
        $name = $keyNode->getName();
        if (!$name instanceof ScalarNode || TokenType::PLAIN_SCALAR !== $name->getToken()->type) {
            return;
        }

        while (TokenType::NEWLINE === $harvester->tokens->current()?->type) {
            $newLine = $harvester->tokens->current();
            $indentation = $harvester->tokens->peek(1);
            if (TokenType::INDENTATION !== $indentation?->type) {
                break;
            }

            $indentLen = \strlen($indentation->text);
            if ($indentLen <= $entryIndentLen) {
                break;
            }

            $scalarOffset = 2;
            while (TokenType::WHITESPACE === $harvester->tokens->peek($scalarOffset)?->type) {
                ++$scalarOffset;
            }
            $scalarToken = $harvester->tokens->peek($scalarOffset);
            if (!$scalarToken?->type->isScalar()) {
                break;
            }

            $keyProbe = $scalarOffset + 1;
            while (TokenType::WHITESPACE === $harvester->tokens->peek($keyProbe)?->type) {
                ++$keyProbe;
            }
            if (TokenType::VALUE_INDICATOR === $harvester->tokens->peek($keyProbe)?->type) {
                break;
            }

            $keyNode->addChild(new NewLineNode($newLine));
            $keyNode->addChild(new IndentationNode($indentation));
            $harvester->tokens->advance();
            $harvester->tokens->advance();

            $contentHead = $harvester->tokens->current();
            while (TokenType::WHITESPACE === $contentHead->type) {
                $keyNode->addChild(new WhitespaceNode($contentHead));
                $harvester->tokens->advance();
                $contentHead = $harvester->tokens->current();
            }

            $keyNode->addScalarName(new ScalarNode($contentHead));
            $harvester->tokens->advance();
        }
    }

    private function consumeExplicitKeyMultilinePlainScalarFirstLine(Harvester $harvester, KeyNode $keyNode, int $entryIndentLen): void
    {
        $newLine = $harvester->tokens->current();
        if (TokenType::NEWLINE !== $newLine->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected NEWLINE to start indented explicit key plain scalar, got %s', $newLine->type->value), $newLine));
        }

        $indentation = $harvester->tokens->peek(1);
        if (TokenType::INDENTATION !== $indentation?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected INDENTATION and scalar for explicit key continuation line, got %s', $harvester->tokens->current()?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $scalarOffset = 2;
        while (TokenType::WHITESPACE === $harvester->tokens->peek($scalarOffset)?->type) {
            ++$scalarOffset;
        }
        $scalarToken = $harvester->tokens->peek($scalarOffset);
        if (!$scalarToken?->type->isScalar()) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected INDENTATION and scalar for explicit key continuation line, got %s', $harvester->tokens->current()?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        if (\strlen($indentation->text) <= $entryIndentLen) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Indented explicit key line must be deeper than entry indent %d', $entryIndentLen), $indentation));
        }

        $keyNode->addChild(new NewLineNode($newLine));
        $keyNode->addChild(new IndentationNode($indentation));
        $harvester->tokens->advance();
        $harvester->tokens->advance();

        $contentHead = $harvester->tokens->current();
        while (TokenType::WHITESPACE === $contentHead->type) {
            $keyNode->addChild(new WhitespaceNode($contentHead));
            $harvester->tokens->advance();
            $contentHead = $harvester->tokens->current();
        }

        $keyNode->addScalarName(new ScalarNode($contentHead));
        $harvester->tokens->advance();
    }

    /**
     * Indented plain or quoted scalar on the line(s) after "key:\\n", not a nested block mapping entry.
     */
    private function consumeIndentedBlockScalarValue(Harvester $harvester, ValueNode $valueNode, Token $leadingNewline, int $parentIndentLen): void
    {
        $valueNode->addChild(new NewLineNode($leadingNewline));
        $harvester->tokens->advance();

        $this->collectTypes($harvester, [
            TokenType::COMMENT,
            TokenType::NEWLINE,
            TokenType::WHITESPACE,
        ], $valueNode);
        $this->collectInsignificantIndentationLines($harvester, $valueNode);

        $indentationToken = $harvester->tokens->current();
        if (TokenType::INDENTATION !== $indentationToken?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected INDENTATION for indented block scalar value, but %s given', $indentationToken?->type->value ?? '_nothing_'), $harvester->tokens));
        }
        if (\strlen($indentationToken->text) <= $parentIndentLen) {
            throw new IndentationInvalidException($this->appendTokenLocation(\sprintf('Indented block scalar must be deeper than parent key line indent (%d spaces)', $parentIndentLen), $indentationToken));
        }

        $valueNode->addChild(new IndentationNode($indentationToken));
        $harvester->tokens->advance();

        $this->collectTypes($harvester, [TokenType::WHITESPACE, TokenType::COMMENT], $valueNode);

        $scalarToken = $harvester->tokens->current();
        if (null === $scalarToken || !\in_array($scalarToken->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Scalar expected for indented block value, but %s given', $scalarToken?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $valueNode->addChild(new ScalarNode($scalarToken));
        $harvester->tokens->advance();

        if (TokenType::PLAIN_SCALAR === $scalarToken->type) {
            $this->appendMultilinePlainScalarContinuations($harvester, $valueNode, $parentIndentLen);
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

    private function createFlowHost(): FlowHost
    {
        return new FlowHost(
            function (Harvester $h, KeyNode $keyNode): void {
                $this->appendFlowKeyMultilinePlainScalarContinuations($h, $keyNode);
            },
            function (Harvester $h, Node $root): void {
                $this->collectSpaceAndComments($h, $root);
            },
            fn (Token $t): SyntaxTokenNode => $this->createSyntaxTokenNode($t),
            fn (Harvester $h): KeyNode => $this->getKeyNode($h, true),
            fn (Harvester $h): bool => $this->isScalarFollowedByValueIndicator($h, true),
            fn (Harvester $h): ValueNode => $this->parseFlowContextValue($h),
            fn (Harvester $h): FlowMappingNode => $this->runFlowMappingDriver($h),
            fn (Harvester $h): MergeInstructionNode => $this->parseMergeInstructionAtCurrentPosition($h),
            function (Harvester $h, KeyValueCoupleNode $couple): void {
                $this->postProcessKeyValueCouple($h, $couple);
            },
            fn (Harvester $h, KeyValueCoupleNode $couple): bool => $this->tryConsumeFlowMappingValueIndicator($h, $couple),
        );
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
            TokenType::TAG => new TagNode($token),
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

    private function getKeyNode(Harvester $harvester, bool $allowEmptyImplicitKey, ?int $entryIndentLen = null): KeyNode
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

            // YAML 1.2.2 §8.2.2 c-l-block-map-explicit-key(n) uses
            // s-l+block-indented(n, BLOCK-OUT) which allows node properties
            // (anchor/tag) after the '?' indicator.
            $this->collectKeyProperties($harvester, $keyNode);
            $token = $harvester->tokens->current();
        }

        if (
            null !== $keyNode->getExplicitKeyIndicatorNode()
            && null !== $entryIndentLen
            && TokenType::NEWLINE === $token->type
        ) {
            $head = $this->peekFirstSignificantBlockHead($harvester);
            if (null === $head) {
                return $keyNode;
            }

            [$indentLen, $significantToken, $scalarPeekOffset] = $head;
            if ($indentLen <= $entryIndentLen) {
                return $keyNode;
            }

            if (TokenType::SEQUENCE_ENTRY === $significantToken->type) {
                $keyNode->setName($this->parseBlockSequenceValue($harvester, $entryIndentLen));

                return $keyNode;
            }

            if (
                TokenType::EXPLICIT_KEY_INDICATOR === $significantToken->type
                || TokenType::MERGE_INDICATOR === $significantToken->type
            ) {
                $keyNode->setName($this->parseBlockMappingValue($harvester, $entryIndentLen));

                return $keyNode;
            }

            if ($significantToken->type->isScalar()) {
                // TODO: refactor confusing place
                //       1) consider continuing of consuming (consume value outside of the method)
                if ($this->isImplicitYamlKeyOnContinuationLine($harvester, $scalarPeekOffset)) {
                    $keyNode->setName($this->parseBlockMappingValue($harvester, $entryIndentLen));
                } else {
                    $this->consumeExplicitKeyMultilinePlainScalarFirstLine($harvester, $keyNode, $entryIndentLen);
                    $this->consumeExplicitKeyMultilinePlainScalarContinuation($harvester, $keyNode, $entryIndentLen);
                }

                return $keyNode;
            }

            return $keyNode;
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
            $keyNode->setName($this->parseCompactBlockSequence($harvester, $token->column - 1));

            return $keyNode;
        }

        if (TokenType::FLOW_MAPPING_START === $token->type) {
            $keyNode->setName($this->runFlowMappingDriver($harvester));

            return $keyNode;
        }

        if (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $keyNode->setName($this->runFlowSequenceDriver($harvester));

            return $keyNode;
        }

        if (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $harvester->registry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException($this->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
            }
            $aliasNode->setAnchor($anchor);
            $keyNode->setName($aliasNode);
            $harvester->tokens->advance();

            return $keyNode;
        }

        if (!$token->type->isScalar() && !$token->type->isMergeIndicator()) {
            if (null !== $keyNode->getExplicitKeyIndicatorNode()) {
                return $keyNode;
            }

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Key scalar expected, but %s given', $token->type->value), $token));
        }

        $keyNode->addScalarName(new ScalarNode($token));
        $harvester->tokens->advance();

        return $keyNode;
    }

    /**
     * Whether {@code peek($scalarPeekOffset)} starts a continuation line of a multiline plain scalar
     * at bare document root ({@see self::BARE_DOCUMENT_BLOCK_PARENT_INDENT}) **without** a leading
     * {@see TokenType::INDENTATION} token (continuation at column one, YAML 1.2.2 §7.3.3).
     */
    private function isBareDocumentFlushMultilinePlainContinuationAt(Harvester $harvester, int $scalarPeekOffset): bool
    {
        $offset = $scalarPeekOffset;
        while (TokenType::WHITESPACE === $harvester->tokens->peek($offset)?->type) {
            ++$offset;
        }
        $scalarToken = $harvester->tokens->peek($offset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        return !$this->isImplicitYamlKeyOnContinuationLine($harvester, $offset);
    }

    private function isBlockScalarStartAtDocumentRoot(Harvester $harvester): bool
    {
        $offset = 0;
        while (true) {
            $token = $harvester->tokens->peek($offset);
            if (null === $token) {
                return false;
            }
            if (TokenType::INDENTATION === $token->type || TokenType::WHITESPACE === $token->type) {
                ++$offset;
                continue;
            }

            return \in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true);
        }
    }

    /**
     * True when a flow sequence or flow mapping at {@code $collectionStartPeekOffset} is closed and
     * the next non-layout token on the same line is {@code VALUE_INDICATOR} (block implicit key
     * whose key is a flow collection, e.g. {@code [flow]: block}).
     */
    private function isFlowCollectionFollowedByBlockValueIndicatorOnSameLine(Harvester $harvester, int $collectionStartPeekOffset): bool
    {
        $open = $harvester->tokens->peek($collectionStartPeekOffset);
        if (!\in_array($open?->type, [TokenType::FLOW_SEQUENCE_START, TokenType::FLOW_MAPPING_START], true)) {
            return false;
        }

        $depth = 0;
        $i = $collectionStartPeekOffset;
        while (true) {
            $tok = $harvester->tokens->peek($i);
            if (null === $tok) {
                return false;
            }

            if (TokenType::FLOW_SEQUENCE_START === $tok->type || TokenType::FLOW_MAPPING_START === $tok->type) {
                ++$depth;
            } elseif (TokenType::FLOW_SEQUENCE_END === $tok->type || TokenType::FLOW_MAPPING_END === $tok->type) {
                --$depth;
                if ($depth < 0) {
                    return false;
                }
                if (0 === $depth) {
                    break;
                }
            }

            ++$i;
        }

        ++$i;
        while (true) {
            $tok = $harvester->tokens->peek($i);
            if (null === $tok) {
                return false;
            }
            if (TokenType::WHITESPACE === $tok->type || TokenType::COMMENT === $tok->type) {
                ++$i;
                continue;
            }
            if (TokenType::NEWLINE === $tok->type) {
                return false;
            }

            return TokenType::VALUE_INDICATOR === $tok->type;
        }
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
     * True when the token at peek offset $scalarPeekOffset is a scalar and the same
     * logical line contains ':' as implicit YAML key (nested block mapping entry).
     *
     * @see Parser::parseValue() Plain scalar continuation guard (~1633–1639)
     */
    private function isImplicitYamlKeyOnContinuationLine(Harvester $harvester, int $scalarPeekOffset): bool
    {
        $offset = $scalarPeekOffset + 1;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked || TokenType::NEWLINE === $peeked->type) {
                return false;
            }
            if (TokenType::WHITESPACE === $peeked->type) {
                ++$offset;
                continue;
            }

            return TokenType::VALUE_INDICATOR === $peeked->type;
        }
    }

    /**
     * Whether the token stream at {@code $indentPeekOffset} from the current position is
     * {@see TokenType::INDENTATION} deeper than $parentIndentLen followed by a multiline plain continuation
     * fragment (not a nested implicit block key).
     *
     * @see Parser::appendMultilinePlainScalarContinuations()
     */
    private function isIndentedMultilinePlainContinuationAt(Harvester $harvester, int $indentPeekOffset, int $parentIndentLen): bool
    {
        $indentation = $harvester->tokens->peek($indentPeekOffset);
        if (TokenType::INDENTATION !== $indentation?->type) {
            return false;
        }
        if (\strlen($indentation->text) <= $parentIndentLen) {
            return false;
        }

        $scalarOffset = $indentPeekOffset + 1;
        while (TokenType::WHITESPACE === $harvester->tokens->peek($scalarOffset)?->type) {
            ++$scalarOffset;
        }
        $scalarToken = $harvester->tokens->peek($scalarOffset);
        if (!$scalarToken?->type->isScalar()) {
            return false;
        }

        $keyProbe = $scalarOffset + 1;
        while (TokenType::WHITESPACE === $harvester->tokens->peek($keyProbe)?->type) {
            ++$keyProbe;
        }

        return TokenType::VALUE_INDICATOR !== $harvester->tokens->peek($keyProbe)?->type;
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
        $contentPeekOffset = 0;
        $token = $harvester->tokens->current();
        if (TokenType::INDENTATION === $token->type) {
            $contentPeekOffset = 1;
            $token = $harvester->tokens->peek(1);
        }

        if (
            TokenType::EXPLICIT_KEY_INDICATOR === $token->type
            || TokenType::ALIAS === $token->type
            || TokenType::VALUE_INDICATOR === $token->type
            || $token->type->isMergeIndicator()
        ) {
            return true;
        }

        if (\in_array($token?->type, [TokenType::FLOW_SEQUENCE_START, TokenType::FLOW_MAPPING_START], true)) {
            return $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($harvester, $contentPeekOffset);
        }

        if (\in_array($token->type, [
            TokenType::DOUBLE_QUOTED_SCALAR,
            TokenType::SINGLE_QUOTED_SCALAR,
            TokenType::PLAIN_SCALAR,
        ], true)) {
            $scalarLineOffset = TokenType::INDENTATION === $harvester->tokens->current()?->type ? 1 : 0;

            return $this->isImplicitYamlKeyOnContinuationLine($harvester, $scalarLineOffset);
        }

        return $this->isNodePropertyToken($token)
            && (
                $this->isNodePropertiesFollowedByImplicitYamlKeyOnSameLine($harvester)
                || $this->isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine($harvester)
            );
    }

    /**
     * True when the line begins with c-ns-properties (anchor/tag), then — still before
     * NEWLINE — a flow mapping or flow sequence whose closing bracket is followed on the
     * same line by {@code VALUE_INDICATOR} (block implicit key whose key is a tagged or
     * anchored flow collection, e.g. {@code &k [a]: b}).
     */
    private function isNodePropertiesFollowedByFlowCollectionImplicitBlockKeyOnSameLine(Harvester $harvester): bool
    {
        $offset = 0;
        if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
            $offset = 1;
        }

        if (!$this->isNodePropertyToken($harvester->tokens->peek($offset))) {
            return false;
        }

        $sawProperty = false;
        while (true) {
            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }
            if (TokenType::NEWLINE === $peeked->type) {
                return false;
            }
            if (TokenType::WHITESPACE === $peeked->type || TokenType::COMMENT === $peeked->type) {
                ++$offset;
                continue;
            }
            if (TokenType::ANCHOR === $peeked->type || TokenType::TAG === $peeked->type) {
                $sawProperty = true;
                ++$offset;
                continue;
            }

            break;
        }

        if (!$sawProperty) {
            return false;
        }

        if (!\in_array($peeked->type, [TokenType::FLOW_MAPPING_START, TokenType::FLOW_SEQUENCE_START], true)) {
            return false;
        }

        return $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($harvester, $offset);
    }

    /**
     * True when the line begins with c-ns-properties (anchor/tag), then — still before
     * NEWLINE — an implicit YAML key (scalar followed by VALUE_INDICATOR). Distinguishes
     * "&a: key: value" from a properties-only prefix line whose value continues below.
     */
    private function isNodePropertiesFollowedByImplicitYamlKeyOnSameLine(Harvester $harvester): bool
    {
        $offset = 0;
        if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
            $offset = 1;
        }

        if (!$this->isNodePropertyToken($harvester->tokens->peek($offset))) {
            return false;
        }

        while (true) {
            $token = $harvester->tokens->peek($offset);
            if (null === $token) {
                return false;
            }
            if (TokenType::NEWLINE === $token->type) {
                return false;
            }
            if (TokenType::WHITESPACE === $token->type || TokenType::COMMENT === $token->type) {
                ++$offset;
                continue;
            }
            if (TokenType::ANCHOR === $token->type || TokenType::TAG === $token->type) {
                ++$offset;
                continue;
            }

            if (!$token->type->isScalar()) {
                return false;
            }

            $peekOffset = $offset + 1;
            while (true) {
                $peeked = $harvester->tokens->peek($peekOffset);
                if (null === $peeked) {
                    return false;
                }
                if (TokenType::NEWLINE === $peeked->type) {
                    return false;
                }
                if (TokenType::WHITESPACE !== $peeked->type) {
                    return TokenType::VALUE_INDICATOR === $peeked->type;
                }
                ++$peekOffset;
            }
        }
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

            if ($this->isNodePropertyToken($token)) {
                if ($seenTag) {
                    return false;
                }
                $seenTag = true;
                ++$i;
                continue;
            }

            return false;
        }
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
            TokenType::TAG,
        ], true);
    }

    private function isNodePropertyToken(?Token $token): bool
    {
        if (null === $token) {
            return false;
        }

        return \in_array($token->type, [
            TokenType::ANCHOR,
            TokenType::TAG,
        ], true);
    }

    /**
     * Implicit YAML key detector (YAML 1.2.2 rule [154] ns-s-implicit-yaml-key):
     * current token is a scalar and the next significant token is ':' (VALUE_INDICATOR).
     * Used for flow-pair entries (§7.4.1 [139]) and compact block-mapping in a sequence (§8.2.1 [185]).
     *
     * When {@code $allowFlowSeparation} is true (flow collections only), COMMENT and NEWLINE tokens may
     * appear between the scalar and ':' (YAML test suite K3WX / flow line breaks).
     */
    private function isScalarFollowedByValueIndicator(Harvester $harvester, bool $allowFlowSeparation = false): bool
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
            if (TokenType::WHITESPACE === $peeked->type) {
                ++$offset;
                continue;
            }
            if ($allowFlowSeparation && \in_array($peeked->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                ++$offset;
                continue;
            }

            return TokenType::VALUE_INDICATOR === $peeked->type;
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

            // Column-0 entries at the bare document root (YAML 1.2.2 rule [211]) have no INDENTATION token.
            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif (self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen && $this->isKeyValueCoupleStart($harvester)) {
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

            // Column-0 entries at the bare document root (YAML 1.2.2 rule [211]) have no INDENTATION token.
            if (TokenType::INDENTATION === $token->type) {
                $indentLen = \strlen($token->text);
            } elseif (self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen && TokenType::SEQUENCE_ENTRY === $token->type) {
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
        $addedDocs = [];
        $document = new DocumentNode();
        while (!$harvester->tokens->isEnd()) {
            $token = $harvester->tokens->current();

            if (TokenType::DOCUMENT_START === $token->type) {
                if ($document->getChildren()) {
                    $this->tryAddDocumentToStream($stream, $document, $addedDocs);
                    $document = new DocumentNode();
                }

                $document->addChild(new DocumentStartNode($token));
                $this->tryAddDocumentToStream($stream, $document, $addedDocs);
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DOCUMENT_END === $token->type) {
                $document->addChild(new DocumentEndNode($token));
                $this->tryAddDocumentToStream($stream, $document, $addedDocs);
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

            // Preserve trailing spaces on otherwise blank lines: whitespace before NEWLINE is not structural.
            if (TokenType::WHITESPACE === $token->type && TokenType::NEWLINE === $harvester->tokens->peek(1)?->type) {
                $document->addChild(new WhitespaceNode($token));
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

            if ($this->isBlockScalarStartAtDocumentRoot($harvester)) {
                while (true) {
                    $separation = $harvester->tokens->current();
                    if (TokenType::INDENTATION === $separation?->type) {
                        $document->addChild(new IndentationNode($separation));
                        $harvester->tokens->advance();
                        continue;
                    }
                    if (TokenType::WHITESPACE === $separation?->type) {
                        $document->addChild(new WhitespaceNode($separation));
                        $harvester->tokens->advance();
                        continue;
                    }
                    break;
                }

                $document->addChild($this->parseValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));
                continue;
            }

            if (TokenType::ALIAS === $token->type) {
                $document->addChild($this->parseValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));
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

            if ($token->type->isScalar()) {
                $document->addChild($this->parseValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));
                continue;
            }

            if ($this->isNodePropertyAtDocumentRoot($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->parseValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));
                continue;
            }

            if ($this->isFlowMappingStart($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->runFlowMappingDriver($harvester));
                continue;
            }

            if ($this->isFlowSequenceStart($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->runFlowSequenceDriver($harvester));
                continue;
            }

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected type: %s', $token->type->value), $token));
        }

        if ($document->getChildren()) {
            $this->tryAddDocumentToStream($stream, $document, $addedDocs);
        }
    }

    private function parseFlowContextValue(Harvester $harvester): ValueNode
    {
        return $this->parseValue($harvester, self::FLOW_COLLECTION_VALUE_PARENT_INDENT);
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
                        ? $this->runFlowSequenceDriver($harvester)
                        : $this->runFlowMappingDriver($harvester),
                );

                return;
            }

            if (
                \in_array($afterIndent->type, [
                    TokenType::DOUBLE_QUOTED_SCALAR,
                    TokenType::SINGLE_QUOTED_SCALAR,
                    TokenType::PLAIN_SCALAR,
                ], true)
                && !$this->isImplicitYamlKeyOnContinuationLine($harvester, $afterIndentOffset)
            ) {
                $this->consumeIndentedBlockScalarValue($harvester, $valueNode, $token, $parentIndentLen);

                return;
            }

            $valueNode->addChild($this->parseBlockMappingValue($harvester, $parentIndentLen));

            return;
        }

        // Column-0 block collection (no leading INDENTATION token) — only
        // accepted at bare document root (n = -1 per YAML 1.2.2 rule [211]).
        if (self::BARE_DOCUMENT_BLOCK_PARENT_INDENT === $parentIndentLen) {
            if (TokenType::SEQUENCE_ENTRY === $afterIndent->type) {
                $valueNode->addChild($this->parseBlockSequenceValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));

                return;
            }
            if (
                TokenType::EXPLICIT_KEY_INDICATOR === $afterIndent->type
                || TokenType::MERGE_INDICATOR === $afterIndent->type
                || $afterIndent->type->isScalar()
            ) {
                $valueNode->addChild($this->parseBlockMappingValue($harvester, self::BARE_DOCUMENT_BLOCK_PARENT_INDENT));
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

        $entryIndentLen = 0;
        if (TokenType::INDENTATION === $token->type) {
            $entryIndentLen = \strlen($token->text);
            $keyValueCouple->setIndentation(new IndentationNode($token));
            $harvester->tokens->advance();
        }

        $keyValueCouple->setKey($this->getKeyNode($harvester, true, $entryIndentLen));
        if (null !== $keyValueCouple->getKey()->getExplicitKeyIndicatorNode()) {
            $this->consumeExplicitKeyMultilinePlainScalarContinuation($harvester, $keyValueCouple->getKey(), $entryIndentLen);
        }

        // YAML 1.2.2 explicit block mapping entry may put ':' on the next line:
        //   ? key
        //   : value
        // When that happens, treat the NEWLINE and any empty/comment lines as part
        // of this couple so the upcoming VALUE_INDICATOR is consumed here.
        $afterKey = $harvester->tokens->current();
        if (
            null !== $afterKey
            && null !== $keyValueCouple->getKey()->getExplicitKeyIndicatorNode()
        ) {
            $this->collectTypes($harvester, [TokenType::WHITESPACE], $keyValueCouple);
            $afterKey = $harvester->tokens->current();

            if (null === $afterKey || TokenType::NEWLINE !== $afterKey->type) {
                // Compact in-line explicit entry ("? key : value") or other forms
                // are handled by the regular VALUE_INDICATOR consumption below.
                $afterKey = null;
            }
        }

        if (null !== $afterKey && TokenType::NEWLINE === $afterKey->type) {
            $head = $this->peekFirstSignificantBlockHead($harvester);
            if (null !== $head) {
                [$headIndentLen, $significantToken] = $head;
                if (TokenType::VALUE_INDICATOR === $significantToken->type && $headIndentLen === $entryIndentLen) {
                    $this->collectTypes($harvester, [
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
            $this->collectTypes($harvester, [TokenType::INDENTATION], $keyValueCouple);
        }

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

        $value = $this->parseValue($harvester, self::FLOW_COLLECTION_VALUE_PARENT_INDENT);
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
        $token = $harvester->tokens->current();
        $nodePropertiesFollowedByValueIndicator = false;
        if (null !== $token && $this->isNodePropertyToken($token)) {
            $offset = 0;
            while (true) {
                $peeked = $harvester->tokens->peek($offset);
                if (null === $peeked || TokenType::NEWLINE === $peeked->type) {
                    break;
                }
                if (TokenType::VALUE_INDICATOR === $peeked->type) {
                    $nodePropertiesFollowedByValueIndicator = true;
                    break;
                }
                if ($this->isNodePropertyToken($peeked) || TokenType::WHITESPACE === $peeked->type) {
                    ++$offset;
                    continue;
                }
                break;
            }
        }

        if (
            $this->isScalarFollowedByValueIndicator($harvester)
            || TokenType::VALUE_INDICATOR === $token?->type
            || $nodePropertiesFollowedByValueIndicator
        ) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->parseCompactBlockMapping($harvester, $compactIndent));

            return $valueNode;
        }

        if (TokenType::SEQUENCE_ENTRY === $harvester->tokens->current()?->type) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->parseCompactBlockSequence($harvester, $compactIndent));

            return $valueNode;
        }

        $flowOpen = $harvester->tokens->current();
        if (
            \in_array($flowOpen?->type, [TokenType::FLOW_SEQUENCE_START, TokenType::FLOW_MAPPING_START], true)
            && $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($harvester, 0)
        ) {
            $valueNode = new ValueNode();
            $valueNode->addChild($this->parseCompactBlockMapping($harvester, $compactIndent));

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

    /**
     * @param int $parentIndentLen Key-line indent length (spaces),
     *                             {@see self::BARE_DOCUMENT_BLOCK_PARENT_INDENT} at bare document root (YAML 1.2.2 rule [211]),
     *                             or {@see self::FLOW_COLLECTION_VALUE_PARENT_INDENT} for flow / merge RHS values.
     */
    private function parseValue(Harvester $harvester, int $parentIndentLen): ValueNode
    {
        $valueNode = new ValueNode();

        $this->collectValueProperties($harvester, $valueNode);

        if ($anchor = $valueNode->getAnchor()) {
            $harvester->registry->anchors[$anchor->getName()] = $anchor;
        }

        $this->collectTypes($harvester, [TokenType::WHITESPACE, TokenType::COMMENT], $valueNode);

        $token = $harvester->tokens->current();
        if (
            null !== $token
            && TokenType::NEWLINE === $token->type
            && self::FLOW_COLLECTION_VALUE_PARENT_INDENT === $parentIndentLen
        ) {
            $this->collectTypes($harvester, [
                TokenType::COMMENT,
                TokenType::NEWLINE,
                TokenType::WHITESPACE,
            ], $valueNode);
        }

        $this->parseValuePrimaryPayload($harvester, $valueNode, $parentIndentLen);

        $this->collectTypes($harvester, [
            TokenType::COMMENT,
            TokenType::WHITESPACE,
        ], $valueNode);

        return $valueNode;
    }

    /**
     * Parses the main value payload (block scalar, block-after-newline, scalars, aliases, compact collections, flow nodes).
     */
    private function parseValuePrimaryPayload(Harvester $harvester, ValueNode $valueNode, int $parentIndentLen): void
    {
        $token = $harvester->tokens->current();
        if (null === $token) {
            return;
        }
        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $valueNode->addChild(new BlockScalarIndicatorNode($token));
            $harvester->tokens->advance();
            $this->collectUntil($harvester, TokenType::NEWLINE, $valueNode);

            $token = $harvester->tokens->current();
            if (!$token) {
                return;
            }

            if (TokenType::NEWLINE !== $token->type) {
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected newline, but %s given', $token->type->value), $token));
            }
            $valueNode->addChild(new NewLineNode($token));
            $harvester->tokens->advance();

            while (TokenType::NEWLINE === $harvester->tokens->current()?->type) {
                $leadingEmptyLineBreak = $harvester->tokens->current();
                $valueNode->addChild(new NewLineNode($leadingEmptyLineBreak));
                $harvester->tokens->advance();
            }

            // YAML 1.2.2 §8.1.1.1: with an explicit indentation indicator (|N, >N, |N-, >N+, ...),
            // the body may start with leading spaces that are part of the content but surface
            // to the parser as a separate INDENTATION token before the scalar payload.
            if (TokenType::INDENTATION === $harvester->tokens->current()?->type) {
                $valueNode->addChild(new IndentationNode($harvester->tokens->current()));
                $harvester->tokens->advance();
            }

            $token = $harvester->tokens->current();
            if (null === $token || !$token->type->isScalar()) {
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Scalar expected, but %s given', $token?->type->value ?? '_nothing_'), $token));
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
                $probe = 2;
                while (TokenType::WHITESPACE === $harvester->tokens->peek($probe)?->type) {
                    ++$probe;
                }
                $afterIndentation = $harvester->tokens->peek($probe);
                if (null !== $afterIndentation && TokenType::NEWLINE !== $afterIndentation->type) {
                    break;
                }
                $valueNode->addChild(new NewLineNode($newLineToken));
                $harvester->tokens->advance();
                $valueNode->addChild(new IndentationNode($indentationToken));
                $harvester->tokens->advance();
                $emptyLineSpace = $harvester->tokens->current();
                while (TokenType::WHITESPACE === $emptyLineSpace->type) {
                    $valueNode->addChild(new WhitespaceNode($emptyLineSpace));
                    $harvester->tokens->advance();
                    $emptyLineSpace = $harvester->tokens->current();
                }
            }

            // Non-empty continuation lines (| / > body): same newline + indent + scalar
            // structure as multiline plain scalars (YAML 1.2.2 §8.1.1).
            $this->appendMultilinePlainScalarContinuations($harvester, $valueNode, $parentIndentLen);
        } elseif (TokenType::NEWLINE === $token->type) {
            if (self::FLOW_COLLECTION_VALUE_PARENT_INDENT === $parentIndentLen) {
                $this->collectTypes($harvester, [
                    TokenType::COMMENT,
                    TokenType::NEWLINE,
                    TokenType::WHITESPACE,
                ], $valueNode);
                $this->parseValuePrimaryPayload($harvester, $valueNode, $parentIndentLen);

                return;
            }
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
                $this->appendMultilinePlainScalarContinuations($harvester, $valueNode, $parentIndentLen);
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
            $valueNode->addChild($this->runFlowSequenceDriver($harvester));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->runFlowMappingDriver($harvester));
        } else {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected type while parsing of value: %s', $token->type->value), $token));
        }
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

    private function postProcessKeyValueCouple(Harvester $harvester, KeyValueCoupleNode $couple): void
    {
        $anchors = [];

        if (null !== ($valueAnchor = $couple->getValue()?->getAnchor())) {
            $anchors[] = $valueAnchor;
        }
        if (null !== ($keyAnchor = $couple->getKey()->getAnchor())) {
            $anchors[] = $keyAnchor;
        }

        foreach ($anchors as $anchor) {
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

    private function runFlowMappingDriver(Harvester $harvester): FlowMappingNode
    {
        $flowMappingNode = new FlowMappingNode();
        $token = $harvester->tokens->current();
        if (TokenType::FLOW_MAPPING_START !== $token?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected FLOW_MAPPING_START token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $flowMappingNode->addChild($this->createSyntaxTokenNode($token));
        $harvester->tokens->advance();

        /** @var FlowMappingNode $result */
        $result = (new Driver())->run(
            $harvester,
            new Frame(
                new FlowMappingBuilder($this->createFlowHost()),
                new ParseContext(),
                $flowMappingNode,
            ),
        );

        return $result;
    }

    private function runFlowSequenceDriver(Harvester $harvester): FlowSequenceNode
    {
        $flowSequenceNode = new FlowSequenceNode();
        $token = $harvester->tokens->current();
        if (TokenType::FLOW_SEQUENCE_START !== $token?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('There is no expected FLOW_SEQUENCE_START token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $flowSequenceNode->addChild($this->createSyntaxTokenNode($token));
        $harvester->tokens->advance();

        /** @var FlowSequenceNode $result */
        $result = (new Driver())->run(
            $harvester,
            new Frame(
                new FlowSequenceBuilder($this->createFlowHost()),
                new ParseContext(),
                $flowSequenceNode,
            ),
        );

        return $result;
    }

    /**
     * @param array<int, bool> $addedDocs
     */
    private function tryAddDocumentToStream(StreamNode $stream, DocumentNode $document, array &$addedDocs): void
    {
        $objectId = spl_object_id($document);
        if (isset($addedDocs[$objectId])) {
            return;
        }

        $stream->addChild($document);
        $addedDocs[$objectId] = true;
    }

    private function tryConsumeFlowMappingValueIndicator(Harvester $harvester, KeyValueCoupleNode $couple): bool
    {
        $this->collectTypes($harvester, [
            TokenType::COMMENT,
            TokenType::NEWLINE,
            TokenType::WHITESPACE,
        ], $couple);

        $token = $harvester->tokens->current();
        if (null === $token || TokenType::VALUE_INDICATOR !== $token->type) {
            return false;
        }

        $couple->setMappingValueIndicator(new SyntaxTokenNode($token));
        $harvester->tokens->advance();

        $this->collectTypes($harvester, [TokenType::WHITESPACE], $couple);

        return true;
    }

    private function wrapParseStateIndentationException(\Exception $previous, TokenStreamProxy $tokens): void
    {
        throw new ($previous::class)($this->appendTokenLocation($previous->getMessage(), $tokens), (int) $previous->getCode(), $previous);
    }
}
