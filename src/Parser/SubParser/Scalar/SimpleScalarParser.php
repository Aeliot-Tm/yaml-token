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

namespace Aeliot\YamlToken\Parser\SubParser\Scalar;

use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParseContext;

final readonly class SimpleScalarParser implements SubParserInterface
{
    public function __construct(
        private NodeFactory $nodeFactory,
    ) {
    }

    public function parse(ParseContext $parseContext): ScalarNode
    {
        $token = $parseContext->tokens->current();
        $node = $this->nodeFactory->createScalarNode($token);
        $parseContext->tokens->advance();

        return $node;
    }
}
