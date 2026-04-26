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

namespace Aeliot\YamlToken\Test\Unit\Lexer\EdgeCases;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Test\Unit\Lexer\LexerMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
final class LexerColonFollowedByFlowIndicatorInFlowMappingTest extends LexerMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'brace',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_START,
                'text' => '{',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'a',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_START,
                'text' => '{',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'b',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '1',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_END,
                'text' => '}',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_END,
                'text' => '}',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'bracket',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_START,
                'text' => '{',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'a',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::FLOW_SEQUENCE_START,
                'text' => '[',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '1',
            ],
            [
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2',
            ],
            [
                'type' => TokenType::FLOW_SEQUENCE_END,
                'text' => ']',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_END,
                'text' => '}',
            ],
            [
                'type' => TokenType::NEWLINE,
                'text' => "\n",
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'comma',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_START,
                'text' => '{',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'a',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::FLOW_ENTRY,
                'text' => ',',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => 'b',
            ],
            [
                'type' => TokenType::VALUE_INDICATOR,
                'text' => ':',
            ],
            [
                'type' => TokenType::WHITESPACE,
                'text' => ' ',
            ],
            [
                'type' => TokenType::PLAIN_SCALAR,
                'text' => '2',
            ],
            [
                'type' => TokenType::FLOW_MAPPING_END,
                'text' => '}',
            ],
        ], __DIR__.'/../../../fixture/edge_cases/colon_followed_by_flow_indicator_in_flow_mapping.yaml'];
    }
}
