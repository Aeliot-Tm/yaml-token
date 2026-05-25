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

use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Parser\Dto\IndentContext;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class BlockScalarValueConsumer
{
    public function __construct(
        private BlockScalarFirstFragmentConsumer $blockScalarFirstFragmentConsumer,
        private MultilinePlainScalarParser $multilinePlainScalarParser,
    ) {
    }

    /**
     * Consumes a block scalar (literal | or folded >) used as a mapping value
     * (YAML 1.2.2 §8.1.1). The assembled {@see BlockScalarEntryNode} is attached to
     * {@see ValueNode}; non-empty continuation lines are appended via
     * {@see MultilinePlainScalarParser::appendMultilinePlainScalarContinuations()}.
     */
    public function consume(TokenStreamInterface $tokens, ValueNode $valueNode, IndentContext $parentIndent): void
    {
        $entry = $this->blockScalarFirstFragmentConsumer->consume($tokens);
        $valueNode->addChild($entry);
        $this->multilinePlainScalarParser->appendMultilinePlainScalarContinuations($tokens, $valueNode, $parentIndent);
    }
}
