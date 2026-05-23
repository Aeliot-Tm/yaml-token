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

use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Exception\IndentationInvalidException;
use Aeliot\YamlToken\Parser\Exception\IndentationOverrideException;
use Aeliot\YamlToken\Parser\Exception\IndentationUndefinedException;
use Aeliot\YamlToken\Token\TokenStreamInterface;

final readonly class IndentationHelper
{
    public function __construct(
        private ErrorHelper $errorHelper,
    ) {
    }

    public function assertIndentLenIsValid(ParseState $state, TokenStreamInterface $tokens, int $indentLen): void
    {
        try {
            $state->assertIndentLenIsValid($indentLen);
        } catch (IndentationInvalidException|IndentationUndefinedException $e) {
            $this->errorHelper->wrapParseStateIndentationException($e, $tokens);
        }
    }

    public function registerIndentStepIfNeeded(ParseState $state, TokenStreamInterface $tokens, int $indentLen): void
    {
        if ($state->isIndentLenRegistered()) {
            return;
        }

        try {
            $state->registerIndentStepLen($indentLen);
        } catch (IndentationInvalidException|IndentationOverrideException $e) {
            $this->errorHelper->wrapParseStateIndentationException($e, $tokens);
        }
    }
}
