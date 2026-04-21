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
    case ALIAS = 'ALIAS';
    case ANCHOR = 'ANCHOR';
    case BYTE_ORDER_MARK = 'BYTE_ORDER_MARK';
    case BLOCK_SCALAR_CHOMPING_INDICATOR = 'BLOCK_SCALAR_CHOMPING_INDICATOR';
    case BLOCK_SCALAR_INDENTATION_INDICATOR = 'BLOCK_SCALAR_INDENTATION_INDICATOR';
    case COMMENT = 'COMMENT';
    case DIRECTIVE = 'DIRECTIVE';
    case DIRECTIVE_TAG = 'DIRECTIVE_TAG';
    case DIRECTIVE_TAG_HANDLE = 'DIRECTIVE_TAG_HANDLE';
    case DIRECTIVE_TAG_PREFIX = 'DIRECTIVE_TAG_PREFIX';
    case DIRECTIVE_YAML = 'DIRECTIVE_YAML';
    case DIRECTIVE_YAML_VERSION = 'DIRECTIVE_YAML_VERSION';
    case DOCUMENT_START = 'DOCUMENT_START';
    case DOCUMENT_END = 'DOCUMENT_END';
    case DOUBLE_QUOTED_SCALAR = 'DOUBLE_QUOTED_SCALAR';
    case EMPTY_SCALAR = 'EMPTY_SCALAR';
    case EXPLICIT_KEY_INDICATOR = 'EXPLICIT_KEY_INDICATOR';
    case FLOW_ENTRY = 'FLOW_ENTRY';
    case FLOW_MAPPING_END = 'FLOW_MAPPING_END';
    case FLOW_MAPPING_START = 'FLOW_MAPPING_START';
    case FLOW_SEQUENCE_END = 'FLOW_SEQUENCE_END';
    case FLOW_SEQUENCE_START = 'FLOW_SEQUENCE_START';
    case FOLDED_BLOCK_SCALAR = 'FOLDED_BLOCK_SCALAR';
    case FOLDED_BLOCK_SCALAR_INDICATOR = 'FOLDED_BLOCK_SCALAR_INDICATOR';
    case INDENTATION = 'INDENTATION';
    case LITERAL_BLOCK_SCALAR = 'LITERAL_BLOCK_SCALAR';
    case LITERAL_BLOCK_SCALAR_INDICATOR = 'LITERAL_BLOCK_SCALAR_INDICATOR';
    case MERGE_INDICATOR = 'MERGE_INDICATOR';
    case NEWLINE = 'NEWLINE';
    case PLAIN_SCALAR = 'PLAIN_SCALAR';
    case SEQUENCE_ENTRY = 'SEQUENCE_ENTRY';
    case SINGLE_QUOTED_SCALAR = 'SINGLE_QUOTED_SCALAR';
    case TAG_BODY = 'TAG_BODY';
    case TAG_HANDLE_NAMED = 'TAG_HANDLE_NAMED';
    case TAG_HANDLE_PRIMARY = 'TAG_HANDLE_PRIMARY';
    case TAG_HANDLE_SECONDARY = 'TAG_HANDLE_SECONDARY';
    case TAG_HANDLE_VERBATIM = 'TAG_HANDLE_VERBATIM';
    case TAG_NON_SPECIFIC = 'TAG_NON_SPECIFIC';
    case UNRECOGNIZED = 'UNRECOGNIZED';
    case VALUE_INDICATOR = 'VALUE_INDICATOR';
    case WHITESPACE = 'WHITESPACE';

    public const BLOCK_SCALAR_INDICATORS = [
        self::FOLDED_BLOCK_SCALAR_INDICATOR,
        self::LITERAL_BLOCK_SCALAR_INDICATOR,
    ];

    public function isMergeIndicator(): bool
    {
        return self::MERGE_INDICATOR === $this;
    }

    public function isScalar(): bool
    {
        return \in_array($this, [
            self::DOUBLE_QUOTED_SCALAR,
            self::EMPTY_SCALAR,
            self::FOLDED_BLOCK_SCALAR,
            self::LITERAL_BLOCK_SCALAR,
            self::PLAIN_SCALAR,
            self::SINGLE_QUOTED_SCALAR,
        ], true);
    }
}
