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
    // Indicators (5.3)
    case ALIAS = 'ALIAS';
    case ANCHOR = 'ANCHOR';
    case BYTE_ORDER_MARK = 'BYTE_ORDER_MARK';
    case COMMENT = 'COMMENT';
    case DIRECTIVE = 'DIRECTIVE';
    case DIRECTIVE_TAG = 'DIRECTIVE_TAG';
    case DIRECTIVE_YAML = 'DIRECTIVE_YAML';
    case DOCUMENT_START = 'DOCUMENT_START';
    case DOCUMENT_END = 'DOCUMENT_END';
    case DOUBLE_QUOTE = 'DOUBLE_QUOTE';
    case EXPLICIT_KEY_INDICATOR = 'EXPLICIT_KEY_INDICATOR';
    case FLOW_ENTRY = 'FLOW_ENTRY';
    case FLOW_MAPPING_END = 'FLOW_MAPPING_END';
    case FLOW_MAPPING_START = 'FLOW_MAPPING_START';
    case FLOW_SEQUENCE_END = 'FLOW_SEQUENCE_END';
    case FLOW_SEQUENCE_START = 'FLOW_SEQUENCE_START';
    case FOLDED = 'FOLDED';
    case LITERAL = 'LITERAL';
    case SEQUENCE_ENTRY = 'SEQUENCE_ENTRY';
    case SINGLE_QUOTE = 'SINGLE_QUOTE';
    case TAG = 'TAG';
    case VALUE_INDICATOR = 'VALUE_INDICATOR';

    // Service characters
    case INDENTATION = 'INDENTATION';
    case NEWLINE = 'NEWLINE';
    case UNRECOGNIZED = 'UNRECOGNIZED';
    case WHITESPACE = 'WHITESPACE';

    // Scalars
    case DOUBLE_QUOTED_SCALAR = 'DOUBLE_QUOTED_SCALAR';
    case EMPTY_SCALAR = 'EMPTY_SCALAR';
    case FOLDED_BLOCK_SCALAR = 'FOLDED_BLOCK_SCALAR';
    case LITERAL_BLOCK_SCALAR = 'LITERAL_BLOCK_SCALAR';
    case PLAIN_SCALAR = 'PLAIN_SCALAR';
    case SINGLE_QUOTED_SCALAR = 'SINGLE_QUOTED_SCALAR';
}
