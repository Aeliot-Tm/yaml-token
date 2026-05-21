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

namespace Aeliot\YamlToken\Parser\Assembler;

use Aeliot\YamlToken\Parser\Consumer;
use Aeliot\YamlToken\Parser\Helper\AnchorPostProcessor;
use Aeliot\YamlToken\Parser\Helper\ErrorHelper;
use Aeliot\YamlToken\Parser\Helper\IndentationHelper;
use Aeliot\YamlToken\Parser\Helper\LookAheadHelper;
use Aeliot\YamlToken\Parser\Helper\MultilineContinuationHelper;
use Aeliot\YamlToken\Parser\Helper\NodeFactory;
use Aeliot\YamlToken\Parser\ParserRegistry;
use Aeliot\YamlToken\Parser\SubParser\Scalar\SimpleScalarParser;

final class ParserAssembler
{
    public function __construct(
        private AnchorPostProcessor $anchorPostProcessor,
        private Consumer $consumer,
        private ErrorHelper $errorHelper,
        private IndentationHelper $indentationHelper,
        private LookAheadHelper $lookAheadHelper,
        private MultilineContinuationHelper $multilineContinuationHelper,
        private NodeFactory $nodeFactory,
    ) {
    }

    public function createSimpleScalarParser(ParserRegistry $registry): SimpleScalarParser
    {
        return new SimpleScalarParser($this->nodeFactory);
    }

    public function getAnchorPostProcessor(): AnchorPostProcessor
    {
        return $this->anchorPostProcessor;
    }

    public function getConsumer(): Consumer
    {
        return $this->consumer;
    }

    public function getErrorHelper(): ErrorHelper
    {
        return $this->errorHelper;
    }

    public function getIndentationHelper(): IndentationHelper
    {
        return $this->indentationHelper;
    }

    public function getLookAheadHelper(): LookAheadHelper
    {
        return $this->lookAheadHelper;
    }

    public function getMultilineContinuationHelper(): MultilineContinuationHelper
    {
        return $this->multilineContinuationHelper;
    }

    public function getNodeFactory(): NodeFactory
    {
        return $this->nodeFactory;
    }
}
