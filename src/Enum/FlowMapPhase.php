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
 * Lexer state for an open flow mapping {@code {...}}: implicit key, value separator, value, then entry separator.
 */
enum FlowMapPhase
{
    /** Expect {@code :} after a complete key node (including K3WX-style adjacent value {@code :bar}). */
    case Colon;

    /** Expect the next implicit key (start of map or after {@code ,}). */
    case Key;

    /** After a complete value: expect {@code ,} or closing {@code }}. */
    case Sep;

    /** Expect the value node after {@see TokenType::VALUE_INDICATOR}. */
    case Value;
}
