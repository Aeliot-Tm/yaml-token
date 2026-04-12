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

namespace Aeliot\YamlToken\Node;

use Aeliot\YamlToken\Token\Token;

/**
 * Wraps a structural token (e.g. VALUE_INDICATOR, EXPLICIT_KEY_INDICATOR, SEQUENCE_ENTRY, flow brackets, FLOW_ENTRY)
 * so entry nodes contain only Node instances.
 */
class SyntaxTokenNode extends AbstractNode
{
    public function __construct(
        private readonly Token $token,
    ) {
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
