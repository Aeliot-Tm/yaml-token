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

namespace Aeliot\YamlToken\Parser\SubParser\Flow;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;
use Aeliot\YamlToken\Parser\SubParser\Consumer;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class FlowMultilinePlainScalarConsumer
{
    public function __construct(
        private Consumer $consumer,
        private NodeFactory $nodeFactory,
        private PeekOffsetHelper $peekOffsetHelper,
    ) {
    }

    /**
     * Flow-context multiline plain value (YAML 1.2.2 §7.3.3 / §7.4.1): NEWLINE WHITESPACE* PLAIN_SCALAR
     * fragments may follow the first scalar. Unlike flow key continuation, the continuation must not
     * be a flow-pair key (PLAIN_SCALAR followed by VALUE_INDICATOR).
     */
    public function tryConsume(
        TokenStreamInterface $tokens,
        MultilinePlainScalarNode $multiline,
        bool $rejectValueIndicatorAfterScalar,
    ): bool {
        if (TokenType::NEWLINE !== $tokens->current()?->type) {
            return false;
        }

        $scalarOffset = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, 1);
        $scalarToken = $tokens->peek($scalarOffset);
        if (TokenType::PLAIN_SCALAR !== $scalarToken?->type) {
            return false;
        }

        if ($rejectValueIndicatorAfterScalar) {
            $afterScalar = $this->peekOffsetHelper->skipWhitespaceOffset($tokens, $scalarOffset + 1);
            if (TokenType::VALUE_INDICATOR === $tokens->peek($afterScalar)?->type) {
                return false;
            }
        }

        $newLine = $tokens->current();
        $multiline->addChild(new NewLineNode($newLine));
        $tokens->advance();

        $this->consumer->collectWhitespace($tokens, $multiline);

        $multiline->addChild($this->nodeFactory->createScalarNode($scalarToken));
        $tokens->advance();

        return true;
    }
}
