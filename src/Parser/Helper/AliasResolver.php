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

namespace Aeliot\YamlToken\Parser\Helper;

use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Parser\Dto\ParseContext;
use Aeliot\YamlToken\Parser\Exception\AnchorUndefinedException;
use Aeliot\YamlToken\Token\Token;

final readonly class AliasResolver
{
    public function __construct(private ErrorHelper $errorHelper)
    {
    }

    public function resolveAlias(ParseContext $parseContext, Token $token): AliasNode
    {
        $aliasNode = new AliasNode($token);
        $aliasName = $aliasNode->getName();
        $anchor = $parseContext->anchorsRegistry->anchors[$aliasName] ?? null;
        if (null === $anchor) {
            throw new AnchorUndefinedException($this->errorHelper->appendTokenLocation(\sprintf('Undefined alias "%s"', $aliasName), $token));
        }
        $aliasNode->setAnchor($anchor);

        return $aliasNode;
    }
}
