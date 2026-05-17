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

namespace Aeliot\YamlToken\Test\Unit\Parser;

use Aeliot\YamlToken\Parser\Dto\AnchorsRegistry;
use Aeliot\YamlToken\Parser\Dto\ContextFrame;
use Aeliot\YamlToken\Parser\Dto\ParseState;
use Aeliot\YamlToken\Parser\Dto\TokenStreamProxy;
use Aeliot\YamlToken\Parser\Enum\ParsingContext;
use Aeliot\YamlToken\Parser\ParseContext;
use Aeliot\YamlToken\Token\TokenStream;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ParseContext::class)]
#[UsesClass(AnchorsRegistry::class)]
#[UsesClass(ContextFrame::class)]
#[UsesClass(ParseState::class)]
#[UsesClass(TokenStreamProxy::class)]
final class ParseContextTest extends TestCase
{
    public function testContextStackPushPopCycle(): void
    {
        $ctx = $this->createContext();

        $blockFrame = new ContextFrame(ParsingContext::Block, 4);
        $ctx->pushContext($blockFrame);
        self::assertSame($blockFrame, $ctx->getCurrentContext());

        $flowFrame = new ContextFrame(ParsingContext::Flow);
        $ctx->pushContext($flowFrame);
        self::assertSame($flowFrame, $ctx->getCurrentContext());

        $ctx->popContext();
        self::assertSame($blockFrame, $ctx->getCurrentContext());

        $ctx->popContext();
    }

    public function testDepthDefaultsToZero(): void
    {
        $ctx = $this->createContext();
        self::assertSame(0, $ctx->depth);
    }

    public function testGetCurrentContextReturnsMostRecentFrame(): void
    {
        $ctx = $this->createContext();

        $bareFrame = new ContextFrame(ParsingContext::BareDocumentRoot);
        $ctx->pushContext($bareFrame);

        $blockFrame = new ContextFrame(ParsingContext::Block, 2);
        $ctx->pushContext($blockFrame);

        self::assertSame(ParsingContext::Block, $ctx->getCurrentContext()->context);
        self::assertSame(2, $ctx->getCurrentContext()->indentLen);
    }

    private function createContext(): ParseContext
    {
        return new ParseContext(
            new TokenStreamProxy(new TokenStream()),
            new AnchorsRegistry(),
            new ParseState(),
        );
    }
}
