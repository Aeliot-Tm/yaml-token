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

/**
 * 'Especial indents' is not ideal solution. This is most likely a crutch.
 * But let this be some temporary solution.
 */
enum EspecialIndent: int
{
    /**
     * Bare-document block parent indent (YAML 1.2.2 rule [211], grammar uses n = -1). Not a column count;
     * keeps “$lineIndent <= $parentIndent” checks uniform: no non-negative indent is <= this value.
     */
    case BARE_DOCUMENT_BLOCK_PARENT = -1;

    /**
     * Sentinel for {@see parseValue()} when the value is parsed inside a flow collection or merge RHS.
     * Flow lines use {@see TokenType::WHITESPACE} (not {@see TokenType::INDENTATION}) before the node,
     * so a newline-prefixed value must not use block-oriented {@see IndentedBlockValueParser::parseIndentedBlockValue()} with indent 0.
     */
    case FLOW_COLLECTION_VALUE_PARENT = -2;
}
