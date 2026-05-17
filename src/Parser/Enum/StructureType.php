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

namespace Aeliot\YamlToken\Parser\Enum;

enum StructureType: string
{
    case ALIAS = 'ALIAS';
    case BLOCK_MAPPING = 'BLOCK_MAPPING';
    case BLOCK_SEQUENCE = 'BLOCK_SEQUENCE';
    case COMPACT_BLOCK_MAPPING = 'COMPACT_BLOCK_MAPPING';
    case COMPACT_BLOCK_SEQUENCE = 'COMPACT_BLOCK_SEQUENCE';
    case DIRECTIVE = 'DIRECTIVE';
    case DOCUMENT = 'DOCUMENT';
    case DOUBLE_QUOTED_SCALAR = 'DOUBLE_QUOTED_SCALAR';
    case EMPTY = 'EMPTY';
    case FLOW_MAPPING = 'FLOW_MAPPING';
    case FLOW_SEQUENCE = 'FLOW_SEQUENCE';
    case FOLDED_BLOCK_SCALAR = 'FOLDED_BLOCK_SCALAR';
    case LITERAL_BLOCK_SCALAR = 'LITERAL_BLOCK_SCALAR';
    case MERGE_INSTRUCTION = 'MERGE_INSTRUCTION';
    case MULTILINE_PLAIN_SCALAR = 'MULTILINE_PLAIN_SCALAR';
    case PLAIN_SCALAR = 'PLAIN_SCALAR';
    case SINGLE_QUOTED_SCALAR = 'SINGLE_QUOTED_SCALAR';
}
