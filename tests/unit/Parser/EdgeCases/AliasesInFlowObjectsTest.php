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

namespace Aeliot\YamlToken\Test\Unit\Parser\EdgeCases;

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Lexer\Lexer;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Parser\Parser;
use Aeliot\YamlToken\Test\Unit\Parser\ParserMappingTestCase;
use Aeliot\YamlToken\Token\Token;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(Parser::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
#[UsesClass(AliasNode::class)]
#[UsesClass(AnchorNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(FlowMappingNode::class)]
#[UsesClass(FlowSequenceNode::class)]
#[UsesClass(KeyNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(NewLineNode::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(SyntaxTokenNode::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(WhitespaceNode::class)]
final class AliasesInFlowObjectsTest extends ParserMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [[
            'type' => StreamNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => DocumentNode::class,
                    'properties' => [],
                    'children' => [
                        [
                            'type' => FlowMappingNode::class,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => SyntaxTokenNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_MAPPING_START,
                                            'text' => '{',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => WhitespaceNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::WHITESPACE,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'properties' => [
                                                'name' => [
                                                    'type' => FlowSequenceNode::class,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'scalar' => [
                                                                        'type' => ScalarNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::PLAIN_SCALAR,
                                                                                'text' => 'a',
                                                                            ],
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => WhitespaceNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::WHITESPACE,
                                                                        'text' => ' ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&b',
                                                                            ],
                                                                            'name' => 'b',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                    'scalar' => [
                                                                        'type' => ScalarNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::PLAIN_SCALAR,
                                                                                'text' => 'b',
                                                                            ],
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [
                                                                    [
                                                                        'type' => WhitespaceNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::WHITESPACE,
                                                                                'text' => ' ',
                                                                            ],
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                                                    'text' => '[',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_ENTRY,
                                                                    'text' => ',',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                                                    'text' => ']',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => AnchorNode::class,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::ANCHOR,
                                                            'text' => '&a',
                                                        ],
                                                        'name' => 'a',
                                                        'declarationKeyText' => null,
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => WhitespaceNode::class,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::WHITESPACE,
                                                            'text' => ' ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        'mappingValueIndicator' => [
                                            'type' => SyntaxTokenNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::VALUE_INDICATOR,
                                                    'text' => ':',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'properties' => [
                                                'alias' => [
                                                    'type' => AliasNode::class,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::ALIAS,
                                                            'text' => '*b',
                                                        ],
                                                        'name' => 'b',
                                                        'anchorName' => 'b',
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => WhitespaceNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::WHITESPACE,
                                                    'text' => ' ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => SyntaxTokenNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_ENTRY,
                                            'text' => ',',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => WhitespaceNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::WHITESPACE,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'properties' => [
                                                'name' => [
                                                    'type' => AliasNode::class,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::ALIAS,
                                                            'text' => '*a',
                                                        ],
                                                        'name' => 'a',
                                                        'anchorName' => 'a',
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        'mappingValueIndicator' => [
                                            'type' => SyntaxTokenNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::VALUE_INDICATOR,
                                                    'text' => ':',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'properties' => [
                                                'flowSequence' => [
                                                    'type' => FlowSequenceNode::class,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'scalar' => [
                                                                        'type' => ScalarNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::PLAIN_SCALAR,
                                                                                'text' => 'c',
                                                                            ],
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => WhitespaceNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::WHITESPACE,
                                                                        'text' => ' ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'alias' => [
                                                                        'type' => AliasNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ALIAS,
                                                                                'text' => '*b',
                                                                            ],
                                                                            'name' => 'b',
                                                                            'anchorName' => 'b',
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => WhitespaceNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::WHITESPACE,
                                                                        'text' => ' ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'scalar' => [
                                                                        'type' => ScalarNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::PLAIN_SCALAR,
                                                                                'text' => 'd',
                                                                            ],
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                                                    'text' => '[',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_ENTRY,
                                                                    'text' => ',',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_ENTRY,
                                                                    'text' => ',',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => SyntaxTokenNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                                                    'text' => ']',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                    ],
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => WhitespaceNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::WHITESPACE,
                                                    'text' => ' ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => WhitespaceNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::WHITESPACE,
                                                    'text' => ' ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => SyntaxTokenNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_MAPPING_END,
                                            'text' => '}',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => NewLineNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::NEWLINE,
                                            'text' => "\n",
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ], __DIR__.'/../../../fixture/edge_cases/aliases_in_flow_objects.yaml'];
    }
}
