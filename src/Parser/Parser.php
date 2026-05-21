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
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\ByteOrderNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DirectiveNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\Node;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagDirectiveHandleNode;
use Aeliot\YamlToken\Node\TagDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Node\TagDirectivePrefixNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedEndException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedStateException;
use Aeliot\YamlToken\Parser\Exception\UnexpectedTokenException;
use Aeliot\YamlToken\Parser\Flow\FlowHost;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Token\Token;
use Aeliot\YamlToken\Token\TokenStream;

final class Parser
{
    /**
     * Bare-document block parent indent (YAML 1.2.2 rule [211], grammar uses n = -1). Not a column count;
     * keeps “$lineIndent <= $parentIndent” checks uniform: no non-negative indent is <= this value.
     */
    private const BARE_DOCUMENT_BLOCK_PARENT_INDENT = MultilineContinuationHelper::BARE_DOCUMENT_BLOCK_PARENT_INDENT;

    /**
     * Sentinel for {@see parseValue()} when the value is parsed inside a flow collection or merge RHS.
     * Flow lines use {@see TokenType::WHITESPACE} (not {@see TokenType::INDENTATION}) before the node,
     * so a newline-prefixed value must not use block-oriented {@see parseIndentedBlockValue()} with indent 0.
     */
    private const FLOW_COLLECTION_VALUE_PARENT_INDENT = -2;

    public function __construct(
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
        private ParserRegistry $parserRegistry,
    ) {
        $this->parserRegistry->setBlockParserBridge(
            function (Harvester $h, ValueNode $v): void { $this->collectValueProperties($h, $v); },
            fn (Harvester $h, int $offset): bool => $this->isFlowCollectionFollowedByBlockValueIndicatorOnSameLine($h, $offset),
            fn (Harvester $h): bool => $this->isKeyValueCoupleStart($h),
            fn (Harvester $h): bool => $this->isKeyValueCoupleStartAllowingNodeProperties($h),
            fn (Harvester $h, int $offset): bool => $this->isNodePropertiesFollowedByImplicitKeyFromOffset($h, $offset),
            fn (Harvester $h, bool $allowFlowSeparation = false): bool => $this->isScalarFollowedByValueIndicator($h, $allowFlowSeparation),
            fn (Harvester $h, int $indent): BlockMappingNode => $this->parserRegistry->getBlockMappingParser()->parseBlockMappingValue($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $this->parserRegistry->getBlockSequenceParser()->parseBlockSequenceValue($h, $indent),
            fn (Harvester $h, int $indent): BlockMappingNode => $this->parseCompactBlockMapping($h, $indent),
            fn (Harvester $h, int $indent): BlockSequenceNode => $this->parseCompactBlockSequence($h, $indent),
            fn (Harvester $h): MergeInstructionNode => $this->parseMergeInstructionAtCurrentPosition($h),
            fn (Harvester $h, int $parentIndentLen): ValueNode => $this->parseValue($h, $parentIndentLen),
        );
    }

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    public function parseStream(TokenStream $tokens): StreamNode
    {
        $harvester = new Harvester(new TokenStreamProxy($tokens));
        $harvester->flowHost = $this->createFlowHost();
        $harvester->anchorsRegistry = new AnchorsRegistry();
        $harvester->state = new ParseState();
        $harvester->parseContext = new ParseContext($harvester->tokens, $harvester->anchorsRegistry, $harvester->state);
        $harvester->stream = $stream = new StreamNode();

        $token = $harvester->tokens->current();
        if (null !== $token && TokenType::BYTE_ORDER_MARK === $token->type) {
            $harvester->stream->addChild(new ByteOrderNode($token));
            $harvester->tokens->advance();
        }

        $this->parseDocuments($harvester, $stream);

        return $stream;
    }

    private function appendTokenLocation(string $message, Token|TokenStreamProxy $tokens): string
    {
        return $this->errorHelper->appendTokenLocation($message, $tokens);
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

    private function collectValueProperties(Harvester $harvester, ValueNode $valueNode): void
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
                    throw new UnexpectedStateException($this->appendTokenLocation('Only one anchor is supported per value node', $token));
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
                    throw new UnexpectedStateException($this->appendTokenLocation('Only one tag is supported per value node', $token));
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

    /**
     * Consumes the line suffix after a document end marker (YAML 1.2.2 rule [209] c-document-end).
     */
    private function consumeDocumentEndLineSuffix(Harvester $harvester, DocumentNode $document): void
    {
        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                break;
            }

            if (TokenType::WHITESPACE === $token->type) {
                $document->addChild(new WhitespaceNode($token));
                $harvester->tokens->advance();
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
            }

            break;
        }
    }

    private function createFlowHost(): FlowHost
    {
        return new FlowHost(
            fn (Harvester $h): KeyNode => $this->parserRegistry->getKeyParser()->getKeyNode($h),
            fn (Harvester $h): bool => $this->isFlowMultilinePlainKeyStart($h),
            fn (Harvester $h): bool => $this->isScalarFollowedByValueIndicator($h, true),
            fn (Harvester $h): ValueNode => $this->parseFlowContextValue($h),
            fn (Harvester $h): MergeInstructionNode => $this->parseMergeInstructionAtCurrentPosition($h),
        );
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

    /**
     * In flow context, checks if the current PLAIN_SCALAR is the start of a multiline
     * implicit key: PLAIN_SCALAR (NEWLINE WS* PLAIN_SCALAR)+ WS* VALUE_INDICATOR.
     */
    private function isFlowMultilinePlainKeyStart(Harvester $harvester): bool
    {
        if (TokenType::PLAIN_SCALAR !== $harvester->tokens->current()?->type) {
            return false;
        }

        $offset = 1;
        $hasContinuation = false;

        while (true) {
            while (TokenType::WHITESPACE === $harvester->tokens->peek($offset)?->type) {
                ++$offset;
            }

            $peeked = $harvester->tokens->peek($offset);
            if (null === $peeked) {
                return false;
            }

            if (TokenType::VALUE_INDICATOR === $peeked->type) {
                return $hasContinuation;
            }

            if (TokenType::NEWLINE !== $peeked->type) {
                return false;
            }
            ++$offset;

            while (TokenType::WHITESPACE === $harvester->tokens->peek($offset)?->type) {
                ++$offset;
            }

            if (TokenType::PLAIN_SCALAR !== $harvester->tokens->peek($offset)?->type) {
                return false;
            }
            ++$offset;
            $hasContinuation = true;
        }
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

            return $this->multilineContinuationHelper
                ->isImplicitYamlKeyOnContinuationLine($harvester->tokens, $scalarLineOffset);
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

        return $this->isNodePropertiesFollowedByImplicitKeyFromOffset($harvester, $offset);
    }

    /**
     * Whether c-ns-properties at {@code $offset} are followed on the same line by an implicit YAML key
     * (scalar then VALUE_INDICATOR before NEWLINE).
     *
     * @param int $offset Peek offset to the first TAG or ANCHOR on the line
     */
    private function isNodePropertiesFollowedByImplicitKeyFromOffset(Harvester $harvester, int $offset): bool
    {
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

            // Key node whose name is empty but carries c-ns-properties, e.g. "&a : value".
            if (TokenType::VALUE_INDICATOR === $token->type) {
                return true;
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

    private function parseCompactBlockMapping(Harvester $harvester, int $indentLen): BlockMappingNode
    {
        return $this->parserRegistry->getCompactBlockMappingParser()->parseCompactBlockMapping($harvester, $indentLen);
    }

    private function parseCompactBlockSequence(Harvester $harvester, int $indentLen): BlockSequenceNode
    {
        return $this->parserRegistry->getCompactBlockSequenceParser()->parseCompactBlockSequence($harvester, $indentLen);
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
                $harvester->tokens->advance();
                $this->consumeDocumentEndLineSuffix($harvester, $document);
                $document = new DocumentNode();
                continue;
            }

            if (TokenType::DIRECTIVE === $token->type) {
                $document->addChild(new DirectiveNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE_YAML_INDICATOR === $token->type) {
                $document->addChild($this->parseYamlDirective($harvester));
                continue;
            }

            if (TokenType::DIRECTIVE_TAG_INDICATOR === $token->type) {
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
                $sequenceEntry = new BlockSequenceEntryNode();
                $document->addChild($sequenceEntry);

                $leadingIndent = 0;
                if (TokenType::INDENTATION === $token->type) {
                    $sequenceEntry->addChild(new IndentationNode($token));
                    $leadingIndent = \strlen($token->text);
                    $harvester->tokens->advance();
                }

                $compactIndent = $leadingIndent + $this->parserRegistry
                        ->getSequenceEntryParser()
                        ->consumeSequenceEntryIndicatorAndSpaces($harvester, $sequenceEntry);

                $sequenceEntry->addChild(
                    $this->parserRegistry
                        ->getSequenceEntryParser()
                        ->parseSequenceEntryValue($harvester, $leadingIndent, $compactIndent),
                );
                continue;
            }

            if ($this->isKeyValueCoupleStart($harvester)) {
                $indentLen = 0;
                if (TokenType::INDENTATION === $token->type) {
                    $indentLen = \strlen($token->text);
                }

                $this->parserRegistry
                    ->getKeyValueCoupleParser()
                    ->parseKeyValueCoupleAtCurrentPosition($harvester, $document, $indentLen);
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

                $document->addChild($this->parserRegistry->getFlowMappingParser()->parse($harvester));
                continue;
            }

            if ($this->isFlowSequenceStart($harvester)) {
                if (TokenType::INDENTATION === $token->type) {
                    $document->addChild(new IndentationNode($token));
                    $harvester->tokens->advance();
                }

                $document->addChild($this->parserRegistry->getFlowSequenceParser()->parse($harvester));
                continue;
            }

            if (TokenType::WHITESPACE === $token->type) {
                $document->addChild(new WhitespaceNode($token));
                $harvester->tokens->advance();
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
        $this->parserRegistry->getIndentedBlockValueParser()->parseIndentedBlockValue($harvester, $valueNode, $parentIndentLen);
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
        $mergeInstruction->addChild($this->nodeFactory->createSimpleNode($token));
        $harvester->tokens->advance();

        $this->consumer->collectTypes($harvester->tokens, [TokenType::VALUE_INDICATOR, TokenType::WHITESPACE], $mergeInstruction);

        $value = $this->parseValue($harvester, self::FLOW_COLLECTION_VALUE_PARENT_INDENT);
        $mergeInstruction->addChild($value);

        $aliases = $this->collectMergeAliases($value);
        foreach ($aliases as $alias) {
            $mergeInstruction->addAlias($alias);
        }

        return $mergeInstruction;
    }

    private function parseTagDirective(Harvester $harvester): TagDirectiveNode
    {
        $token = $harvester->tokens->current();
        if (TokenType::DIRECTIVE_TAG_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected DIRECTIVE_TAG_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $tagDirectiveNode = new TagDirectiveNode();
        $tagDirectiveNode->addChild(new TagDirectiveIndicatorNode($token));
        $harvester->tokens->advance();

        $seenHandle = false;
        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException($this->appendTokenLocation('Unexpected end of token stream: TAG directive handle and prefix are required', $harvester->tokens));
            }

            if (TokenType::WHITESPACE === $token->type) {
                $tagDirectiveNode->addChild($this->nodeFactory->createSimpleNode($token));
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

                $this->consumer->collectSpaceAndComments($harvester->tokens, $tagDirectiveNode);

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
            $harvester->anchorsRegistry->anchors[$anchor->getName()] = $anchor;
        }

        $this->consumer->collectSpaceAndComments($harvester->tokens, $valueNode);

        $token = $harvester->tokens->current();
        if (
            null !== $token
            && TokenType::NEWLINE === $token->type
            && self::FLOW_COLLECTION_VALUE_PARENT_INDENT === $parentIndentLen
        ) {
            $this->consumer->collectSpaceCommentEnds($harvester->tokens, $valueNode);
        }

        $this->parseValuePrimaryPayload($harvester, $valueNode, $parentIndentLen);

        // Trailing s-separate / s-l-comments before ',', ']', or '}' belong to the enclosing
        // FlowSequenceBuilder / FlowMappingBuilder (YAML 1.2.2 §6.3, §7.1), not this ValueNode.
        if (self::FLOW_COLLECTION_VALUE_PARENT_INDENT !== $parentIndentLen) {
            $this->consumer->collectSpaceAndComments($harvester->tokens, $valueNode);
        }

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
        // YAML 1.2.2 §7.2 e-node / §7.4: in flow contexts, scalar content may be empty right
        // after c-ns-properties (tag/anchor) — the next ',' / '}' / ']' terminates the entry.
        if (
            self::FLOW_COLLECTION_VALUE_PARENT_INDENT === $parentIndentLen
            && \in_array($token->type, [
                TokenType::FLOW_ENTRY,
                TokenType::FLOW_MAPPING_END,
                TokenType::FLOW_SEQUENCE_END,
            ], true)
        ) {
            return;
        }

        $multilinePlainScalarParser = $this->parserRegistry->getMultilinePlainScalarParser();

        if (\in_array($token->type, TokenType::BLOCK_SCALAR_INDICATORS, true)) {
            $valueNode->addChild(new BlockScalarIndicatorNode($token));
            $harvester->tokens->advance();
            $this->consumer->collectUntil($harvester->tokens, TokenType::NEWLINE, $valueNode);

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

            $valueNode->addChild($this->nodeFactory->createScalarNode($token));
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
            $multilinePlainScalarParser->appendMultilinePlainScalarContinuations($harvester->tokens, $valueNode, $parentIndentLen);
        } elseif (TokenType::NEWLINE === $token->type) {
            if (self::FLOW_COLLECTION_VALUE_PARENT_INDENT === $parentIndentLen) {
                $this->consumer->collectSpaceCommentEnds($harvester->tokens, $valueNode);
                $this->parseValuePrimaryPayload($harvester, $valueNode, $parentIndentLen);

                return;
            }
            $this->parseIndentedBlockValue($harvester, $valueNode, $parentIndentLen);
        } elseif ($token->type->isScalar()) {
            if (
                TokenType::PLAIN_SCALAR === $token->type
                && $this->multilineContinuationHelper
                    ->isMultilinePlainContinuationAhead($harvester->tokens, 1, $parentIndentLen)
            ) {
                $multiline = new MultilinePlainScalarNode();
                $multiline->addChild($this->nodeFactory->createScalarNode($token));
                $harvester->tokens->advance();
                $multilinePlainScalarParser->appendMultilinePlainScalarContinuations($harvester->tokens, $multiline, $parentIndentLen);
                $valueNode->addChild($multiline);
            } elseif (
                TokenType::PLAIN_SCALAR === $token->type
                && self::FLOW_COLLECTION_VALUE_PARENT_INDENT === $parentIndentLen
            ) {
                $head = $this->nodeFactory->createScalarNode($token);
                $harvester->tokens->advance();
                $multiline = new MultilinePlainScalarNode();
                $multiline->addChild($head);
                $consumedAny = false;
                while ($multilinePlainScalarParser->tryConsumeFlowValueMultilinePlainScalarLine($harvester->tokens, $multiline)) {
                    $consumedAny = true;
                }
                $valueNode->addChild($consumedAny ? $multiline : $head);
            } else {
                $valueNode->addChild($this->parserRegistry->getSimpleScalarParser()->parse($harvester->parseContext));
            }
        } elseif (TokenType::ALIAS === $token->type) {
            $aliasNode = new AliasNode($token);
            $aliasName = $aliasNode->getName();
            $anchor = $harvester->anchorsRegistry->anchors[$aliasName] ?? null;
            if (null === $anchor) {
                throw new AnchorUndefinedException($this->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
            }
            $aliasNode->setAnchor($anchor);
            $valueNode->addChild($aliasNode);
            $harvester->tokens->advance();
        } elseif (TokenType::SEQUENCE_ENTRY === $token->type) {
            $valueNode->addChild($this->parseCompactBlockSequence($harvester, $token->column - 1));
        } elseif (TokenType::FLOW_SEQUENCE_START === $token->type) {
            $valueNode->addChild($this->parserRegistry->getFlowSequenceParser()->parse($harvester));
        } elseif (TokenType::FLOW_MAPPING_START === $token->type) {
            $valueNode->addChild($this->parserRegistry->getFlowMappingParser()->parse($harvester));
        } else {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected type while parsing of value: %s', $token->type->value), $token));
        }
    }

    private function parseYamlDirective(Harvester $harvester): YamlDirectiveNode
    {
        $token = $harvester->tokens->current();
        if (TokenType::DIRECTIVE_YAML_INDICATOR !== $token?->type) {
            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected DIRECTIVE_YAML_INDICATOR token, but %s given', $token?->type->value ?? '_nothing_'), $harvester->tokens));
        }

        $yamlDirectiveNode = new YamlDirectiveNode();
        $yamlDirectiveNode->addChild(new YamlDirectiveIndicatorNode($token));
        $harvester->tokens->advance();

        while (true) {
            $token = $harvester->tokens->current();
            if (null === $token) {
                throw new UnexpectedEndException($this->appendTokenLocation('Unexpected end of token stream: YAML directive version is required', $harvester->tokens));
            }

            if (\in_array($token->type, [TokenType::WHITESPACE, TokenType::VALUE_INDICATOR], true)) {
                $yamlDirectiveNode->addChild($this->nodeFactory->createSimpleNode($token));
                $harvester->tokens->advance();
                continue;
            }

            if (TokenType::DIRECTIVE_YAML_VERSION === $token->type) {
                $yamlDirectiveNode->addChild($this->nodeFactory->createSimpleNode($token));
                $harvester->tokens->advance();

                $this->consumer->collectSpaceAndComments($harvester->tokens, $yamlDirectiveNode);

                return $yamlDirectiveNode;
            }

            if (\in_array($token->type, [TokenType::COMMENT, TokenType::NEWLINE], true)) {
                throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Expected YAML directive version before newline or comment, but %s given', $token->type->value), $token));
            }

            throw new UnexpectedTokenException($this->appendTokenLocation(\sprintf('Unexpected token in YAML directive: %s', $token->type->value), $token));
        }
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
}
