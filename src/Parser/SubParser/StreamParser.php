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
use Aeliot\YamlToken\Parser\Contract\SubParserInterface;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\ParserRegistry;

final readonly class StreamParser implements SubParserInterface
{
    public function __construct(
        private ParserRegistry $registry,
    ) {
    }

    public function parseStream(Harvester $harvester): StreamNode
    {
        $harvester->stream = $stream = new StreamNode();

        $token = $harvester->tokens->current();
        if (null !== $token && TokenType::BYTE_ORDER_MARK === $token->type) {
            $stream->addChild(new ByteOrderNode($token));
            $harvester->tokens->advance();
        }

        $this->registry->getDocumentParser()->parseDocuments($harvester, $stream);

        return $stream;
    }
}
