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

namespace Aeliot\YamlToken\Enum;

enum TokenType: string
{
    case ALIAS_NODE = 'ALIAS_NODE';
    case ANCHOR_PROPERTY = 'ANCHOR_PROPERTY';
    case BLOCK_INDENT = 'BLOCK_INDENT';
    case BYTE_ORDER_MARK = 'BYTE_ORDER_MARK';
    case CHOMPING_INDICATOR = 'CHOMPING_INDICATOR';
    case COMMENT = 'COMMENT';
    case DOCUMENT_START = 'DOCUMENT_START';
    case DOCUMENT_END = 'DOCUMENT_END';
    case DOUBLE_QUOTED_SCALAR = 'DOUBLE_QUOTED_SCALAR';
    case EXPLICIT_KEY_INDICATOR = 'EXPLICIT_KEY_INDICATOR';
    case FLOW_ENTRY = 'FLOW_ENTRY';
    case FLOW_MAPPING_END = 'FLOW_MAPPING_END';
    case FLOW_MAPPING_START = 'FLOW_MAPPING_START';
    case FLOW_SEQUENCE_END = 'FLOW_SEQUENCE_END';
    case FLOW_SEQUENCE_START = 'FLOW_SEQUENCE_START';
    case FOLDED_BLOCK_SCALAR = 'FOLDED_BLOCK_SCALAR';
    case FOLDED_BLOCK_SCALAR_INDICATOR = 'FOLDED_BLOCK_SCALAR_INDICATOR';
    case INDENT = 'INDENT';
    case INDENTATION_INDICATOR = 'INDENTATION_INDICATOR';
    case LITERAL_BLOCK_SCALAR = 'LITERAL_BLOCK_SCALAR';
    case LITERAL_BLOCK_SCALAR_INDICATOR = 'LITERAL_BLOCK_SCALAR_INDICATOR';
    case MERGE_INDICATOR = 'MERGE_INDICATOR';
    case NEWLINE = 'NEWLINE';
    case PLAIN_SCALAR = 'PLAIN_SCALAR';
    case RESERVED_DIRECTIVE = 'RESERVED_DIRECTIVE';
    case SEQUENCE_ENTRY = 'SEQUENCE_ENTRY';
    case SINGLE_QUOTED_SCALAR = 'SINGLE_QUOTED_SCALAR';
    case TAG_DIRECTIVE = 'TAG_DIRECTIVE';
    case TAG_HANDLE = 'TAG_HANDLE';
    case TAG_PREFIX = 'TAG_PREFIX';
    case TAG_PROPERTY = 'TAG_PROPERTY';
    case VALUE_INDICATOR = 'VALUE_INDICATOR';
    case WHITESPACE = 'WHITESPACE';
    case YAML_DIRECTIVE = 'YAML_DIRECTIVE';
    case YAML_VERSION = 'YAML_VERSION';

    public const BLOCK_SCALAR_INDICATORS = [
        self::FOLDED_BLOCK_SCALAR_INDICATOR,
        self::LITERAL_BLOCK_SCALAR_INDICATOR,
    ];

    public function isFoldedBlockScalarIndicator(): bool
    {
        return self::FOLDED_BLOCK_SCALAR_INDICATOR === $this;
    }

    public function isLiteralBlockScalarIndicator(): bool
    {
        return self::LITERAL_BLOCK_SCALAR_INDICATOR === $this;
    }

    public function isMergeIndicator(): bool
    {
        return self::MERGE_INDICATOR === $this;
    }

    public function isScalar(): bool
    {
        return \in_array($this, [
            self::DOUBLE_QUOTED_SCALAR,
            self::FOLDED_BLOCK_SCALAR,
            self::LITERAL_BLOCK_SCALAR,
            self::PLAIN_SCALAR,
            self::SINGLE_QUOTED_SCALAR,
        ], true);
    }
}
