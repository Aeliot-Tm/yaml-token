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

namespace Aeliot\YamlToken\Parser\SubParser;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\ByteOrderNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Assembler\ParserRegistry;
use Aeliot\YamlToken\Parser\Dto\ParseContext;

final readonly class StreamParser
{
    public function __construct(
        private ParserRegistry $registry,
    ) {
    }

    public function parseStream(ParseContext $parseContext): StreamNode
    {
        $stream = new StreamNode();

        $token = $parseContext->tokens->current();
        if (null !== $token && TokenType::BYTE_ORDER_MARK === $token->type) {
            $stream->addChild(new ByteOrderNode($token));
            $parseContext->tokens->advance();
        }

        $this->registry->getDocumentParser()->parseDocuments($parseContext, $stream);

        return $stream;
    }
}
