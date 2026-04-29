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

namespace Aeliot\YamlToken\Test\Unit\Lexer;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Lexer::class)]
final class UnrecognizedTest extends TestCase
{
    public function testQuestionMarkNotMappingKeyIsPlainScalar(): void
    {
        $tokens = (new Lexer())->tokenize('?key')->getTokens();

        $this->assertSame(TokenType::PLAIN_SCALAR, $tokens[0]->type);
        $this->assertSame('?key', $tokens[0]->text);
    }
}
