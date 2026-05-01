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
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
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
#[UsesClass(AnchorNode::class)]
#[UsesClass(BlockMappingNode::class)]
#[UsesClass(DocumentNode::class)]
#[UsesClass(ExplicitKeyIndicatorNode::class)]
#[UsesClass(IndentationNode::class)]
#[UsesClass(KeyNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(Lexer::class)]
#[UsesClass(NewLineNode::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(SequenceEntryNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(SyntaxTokenNode::class)]
#[UsesClass(Token::class)]
#[UsesClass(TokenType::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(WhitespaceNode::class)]
final class AnchorsOnEmptyScalarsTest extends ParserMappingTestCase
{
    public static function getDataForTestMapping(): iterable
    {
        yield [
            [
                'type' => StreamNode::class,
                'properties' => [],
                'children' => [
                    [
                        'type' => DocumentNode::class,
                        'properties' => [],
                        'children' => [
                            [
                                'type' => SequenceEntryNode::class,
                                'properties' => [
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'anchor' => [
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
                                        ],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::SEQUENCE_ENTRY,
                                                'text' => '-',
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
                                'type' => NewLineNode::class,
                                'properties' => [
                                    'token' => [
                                        'type' => TokenType::NEWLINE,
                                        'text' => "\n",
                                    ],
                                ],
                                'children' => [],
                            ],
                            [
                                'type' => SequenceEntryNode::class,
                                'properties' => [
                                    'value' => [
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
                                ],
                                'children' => [
                                    [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::SEQUENCE_ENTRY,
                                                'text' => '-',
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
                                'type' => NewLineNode::class,
                                'properties' => [
                                    'token' => [
                                        'type' => TokenType::NEWLINE,
                                        'text' => "\n",
                                    ],
                                ],
                                'children' => [],
                            ],
                            [
                                'type' => SequenceEntryNode::class,
                                'properties' => [
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'blockMapping' => [
                                                'type' => BlockMappingNode::class,
                                                'properties' => [],
                                                'children' => [
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
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'properties' => [
                                                            'indentation' => [
                                                                'type' => IndentationNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::INDENTATION,
                                                                        'text' => '  ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'key' => [
                                                                'type' => KeyNode::class,
                                                                'properties' => [],
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
                                                            'value' => [
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
                                                        ],
                                                        'children' => [
                                                            [
                                                                'type' => SyntaxTokenNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::VALUE_INDICATOR,
                                                                        'text' => ':',
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
                                                        'type' => NewLineNode::class,
                                                        'properties' => [
                                                            'token' => [
                                                                'type' => TokenType::NEWLINE,
                                                                'text' => "\n",
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'properties' => [
                                                            'indentation' => [
                                                                'type' => IndentationNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::INDENTATION,
                                                                        'text' => '  ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'key' => [
                                                                'type' => KeyNode::class,
                                                                'properties' => [
                                                                    'name' => [
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
                                                                'children' => [],
                                                            ],
                                                            'value' => [
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
                                                                            'declarationKeyText' => 'b',
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
                                                            [
                                                                'type' => SyntaxTokenNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::VALUE_INDICATOR,
                                                                        'text' => ':',
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
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::SEQUENCE_ENTRY,
                                                'text' => '-',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
                            [
                                'type' => SequenceEntryNode::class,
                                'properties' => [
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'blockMapping' => [
                                                'type' => BlockMappingNode::class,
                                                'properties' => [],
                                                'children' => [
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
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'properties' => [
                                                            'indentation' => [
                                                                'type' => IndentationNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::INDENTATION,
                                                                        'text' => '  ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'key' => [
                                                                'type' => KeyNode::class,
                                                                'properties' => [],
                                                                'children' => [
                                                                    [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&c',
                                                                            ],
                                                                            'name' => 'c',
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
                                                            'value' => [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
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
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
                                                            [
                                                                'type' => SyntaxTokenNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::VALUE_INDICATOR,
                                                                        'text' => ':',
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
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::SEQUENCE_ENTRY,
                                                'text' => '-',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
                            [
                                'type' => SequenceEntryNode::class,
                                'properties' => [
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'blockMapping' => [
                                                'type' => BlockMappingNode::class,
                                                'properties' => [],
                                                'children' => [
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
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'properties' => [
                                                            'indentation' => [
                                                                'type' => IndentationNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::INDENTATION,
                                                                        'text' => '  ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'key' => [
                                                                'type' => KeyNode::class,
                                                                'properties' => [
                                                                    'explicitKeyIndicatorNode' => [
                                                                        'type' => ExplicitKeyIndicatorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                                                'text' => '?',
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
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&d',
                                                                            ],
                                                                            'name' => 'd',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                            ],
                                                            'value' => [
                                                                'type' => ValueNode::class,
                                                                'properties' => [],
                                                                'children' => [],
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
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::SEQUENCE_ENTRY,
                                                'text' => '-',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
                            [
                                'type' => SequenceEntryNode::class,
                                'properties' => [
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'blockMapping' => [
                                                'type' => BlockMappingNode::class,
                                                'properties' => [],
                                                'children' => [
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
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'properties' => [
                                                            'indentation' => [
                                                                'type' => IndentationNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::INDENTATION,
                                                                        'text' => '  ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'key' => [
                                                                'type' => KeyNode::class,
                                                                'properties' => [
                                                                    'explicitKeyIndicatorNode' => [
                                                                        'type' => ExplicitKeyIndicatorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                                                'text' => '?',
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
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&e',
                                                                            ],
                                                                            'name' => 'e',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                            ],
                                                            'value' => [
                                                                'type' => ValueNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
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
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
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
                                                            [
                                                                'type' => IndentationNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::INDENTATION,
                                                                        'text' => '  ',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            [
                                                                'type' => SyntaxTokenNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::VALUE_INDICATOR,
                                                                        'text' => ':',
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
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::SEQUENCE_ENTRY,
                                                'text' => '-',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            __DIR__.'/../../../fixture/edge_cases/anchors_on_empty_scalars.yaml',
        ];
    }
}
