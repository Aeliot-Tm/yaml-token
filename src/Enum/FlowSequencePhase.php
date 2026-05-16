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

/**
 * Lexer state for an open flow sequence {@code [...]}: entry start, value separator after a JSON-style key, value payload.
 */
enum FlowSequencePhase
{
    /** Expect {@code :} after a JSON-style key (quoted scalar or flow node, rule [153]). */
    case Colon;

    /** Expect the next sequence entry (start of sequence or after {@code ,}). */
    case Entry;

    /** Expect the value node after {@see TokenType::VALUE_INDICATOR}. */
    case Value;
}
