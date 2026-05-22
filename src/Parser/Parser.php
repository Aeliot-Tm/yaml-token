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

namespace Aeliot\YamlToken\Parser;

use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\Harvester;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Token\TokenStream;

final class Parser
{
    public function __construct(
        private ParserRegistry $parserRegistry,
    ) {
    }

    public function parse(string $input): StreamNode
    {
        return $this->parseStream((new Lexer())->tokenize($input));
    }

    public function parseStream(TokenStream $tokens): StreamNode
    {
        $harvester = new Harvester(new TokenStreamProxy($tokens));
        $harvester->flowHost = $this->parserRegistry->getFlowHost();
        $harvester->anchorsRegistry = new AnchorsRegistry();
        $harvester->state = new ParseState();
        $harvester->parseContext = new ParseContext($harvester->tokens, $harvester->anchorsRegistry, $harvester->state);

        return $this->parserRegistry->getStreamParser()->parseStream($harvester);
    }
}
