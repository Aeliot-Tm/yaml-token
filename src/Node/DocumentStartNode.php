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

class DocumentStartNode extends AbstractNode
{
    public function __construct(
        private Token $token,
    ) {
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
