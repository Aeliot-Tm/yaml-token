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

namespace Aeliot\YamlToken\Lexer\Dto;

use Aeliot\YamlToken\Enum\BlockScalarChomping;
use Aeliot\YamlToken\Enum\TokenType;

/**
 * Lexer cursor: {@see self::$position} is a byte offset into the input string;
 * {@see self::$column} is a 1-based Unicode code point index on the current line.
 */
final class Cursor
{
    /**
     * After a newline that followed {@see TokenType::PLAIN_SCALAR} content, the next line may continue that
     * plain scalar with greater indentation than {@see self::$plainScalarContinuationBaseIndent} (block mapping
     * value, block sequence entry with plain on the same line, or explicit document after
     * {@see TokenType::DOCUMENT_START}).
     */
    public bool $awaitingBlockPlainContinuation = false;

    /**
     * Leading-space count of the block mapping key line when {@see TokenType::VALUE_INDICATOR} was emitted in block context;
     * null when not tracking an open block mapping value for multiline-plain continuation.
     */
    public ?int $blockMappingKeyIndent = null;

    /**
     * Digit (1–9) from {@see TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR} on the current header line; cleared when the header ends.
     */
    public ?int $blockScalarAdditionalIndentFromIndicator = null;

    /**
     * Set when emitting {@see TokenType::LITERAL_BLOCK_SCALAR_INDICATOR} or {@see TokenType::FOLDED_BLOCK_SCALAR_INDICATOR}:
     * {@see TokenType::LITERAL_BLOCK_SCALAR} or {@see TokenType::FOLDED_BLOCK_SCALAR} for the upcoming body token.
     *
     * @var TokenType::LITERAL_BLOCK_SCALAR|TokenType::FOLDED_BLOCK_SCALAR|null
     */
    public ?TokenType $blockScalarBodyTokenType = null;

    /**
     * Chomping from the block scalar header: set on {@see TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR},
     * default {@see BlockScalarChomping::Clip} when the header line ends without +/-.
     */
    public ?BlockScalarChomping $blockScalarChomping = null;

    /**
     * Sum of mapping-key parent indent and explicit digit (YAML 1.2.2 §8.1); used only to derive body line rules;
     * cleared when block scalar body reading starts.
     */
    public ?int $blockScalarExplicitContentMinIndent = null;

    /**
     * True after {@see TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR} on the current block header line.
     */
    public bool $blockScalarExplicitIndentIndicator = false;

    /**
     * Leading-space count before the block mapping key (same line as {@see TokenType::VALUE_INDICATOR}); cleared when the block scalar header ends.
     */
    public ?int $blockScalarValueParentIndent = null;

    public int $column = 1;

    public int $currentIndent = 0;

    /**
     * One stack frame per open flow collection ({@see FlowMapFrame}, {@see FlowSequenceFrame}): a map frame tracks
     * phase so ':' after a key is a {@see TokenType::VALUE_INDICATOR} even when the value is adjacent (K3WX {@code :bar}).
     *
     * @var list<FlowCollectionFrameInterface>
     */
    public array $flowCollectionStack = [];

    /**
     * Nesting depth of flow collections (incremented on FLOW_MAPPING_START / FLOW_SEQUENCE_START,
     * decremented on FLOW_MAPPING_END / FLOW_SEQUENCE_END). When zero, the lexer is in a block
     * context and the flow indicators "}", "]", "," are not treated as structural tokens
     * (they are allowed inside plain scalars per YAML 1.2 §7.3.3).
     */
    public int $flowDepth = 0;

    /**
     * After {@see TokenType::LITERAL_BLOCK_SCALAR_INDICATOR} / {@see TokenType::FOLDED_BLOCK_SCALAR_INDICATOR} until the header line break.
     */
    public bool $inBlockScalarHeaderLine = false;

    /**
     * When set, block body after the header newline is emitted as line tokens
     * ({@see TokenType::INDENTATION}, {@see TokenType::PLAIN_SCALAR}, {@see TokenType::NEWLINE}), not a single block body token.
     */
    public bool $inExplicitIndentBlockScalarBody = false;

    public int $line = 1;

    /**
     * After the block scalar header newline (or EOF before body), the next token is block body.
     *
     * @var TokenType::LITERAL_BLOCK_SCALAR|TokenType::FOLDED_BLOCK_SCALAR|null
     */
    public ?TokenType $pendingBlockScalarBody = null;

    /**
     * Indent (space count) of the line that started a block-context plain scalar or mapping value;
     * continuation lines with greater indent may treat {@code &}, {@code *}, {@code !} as plain content (YAML 1.2.2 §7.3.3).
     */
    public ?int $plainScalarContinuationBaseIndent = null;

    /** Byte offset from the start of the input. */
    public int $position = 0;

    /**
     * When true, {@code &} and {@code *} are not lexed as anchor/alias (multiline plain continuation line).
     */
    public bool $suppressAnchorAlias = false;

    /**
     * When true, explicit tag lexing must not run for leading {@code !}
     * (continuation line of a multiline block plain scalar); cleared at end of line.
     */
    public bool $suppressExplicitTagForBang = false;
}
