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

use Aeliot\YamlToken\Parser\Assembler\ParserAssembler;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\Helper\PeekOffsetHelper;

final class ParserBuilder
{
    public function createParser(): Parser
    {
        $assembler = $this->createAssembler();

        return new Parser(new ParserRegistry($assembler));
    }

    private function createAssembler(): ParserAssembler
    {
        $anchorPostProcessor = new AnchorPostProcessor();
        $errorHelper = new ErrorHelper();
        $indentationHelper = new IndentationHelper($errorHelper);
        $peekOffsetHelper = new PeekOffsetHelper();
        $multilineContinuationHelper = new MultilineContinuationHelper($peekOffsetHelper);
        $nodeFactory = new NodeFactory();
        $consumer = new Consumer($nodeFactory, $peekOffsetHelper);
        $lookAheadHelper = new LookAheadHelper($consumer);

        return new ParserAssembler(
            $anchorPostProcessor,
            $consumer,
            $errorHelper,
            $indentationHelper,
            $lookAheadHelper,
            $multilineContinuationHelper,
            $nodeFactory,
            $peekOffsetHelper,
        );
    }
}
