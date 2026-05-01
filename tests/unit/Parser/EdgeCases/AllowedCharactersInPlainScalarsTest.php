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
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
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
#[UsesClass(DocumentNode::class)]
#[UsesClass(IndentationNode::class)]
#[UsesClass(KeyNode::class)]
#[UsesClass(KeyValueCoupleNode::class)]
#[UsesClass(MultilinePlainScalarNode::class)]
#[UsesClass(NewLineNode::class)]
#[UsesClass(ScalarNode::class)]
#[UsesClass(StreamNode::class)]
#[UsesClass(SyntaxTokenNode::class)]
#[UsesClass(ValueNode::class)]
#[UsesClass(WhitespaceNode::class)]
final class AllowedCharactersInPlainScalarsTest extends ParserMappingTestCase
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
                            'type' => KeyValueCoupleNode::class,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'safe',
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
                                        'multilinePlainScalar' => [
                                            'type' => MultilinePlainScalarNode::class,
                                            'properties' => [],
                                            'children' => [
                                                [
                                                    'type' => ScalarNode::class,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => "a!\"#$%&'()*+,-./09:;<=>?@AZ[\\]^_`az{|}~",
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => ScalarNode::class,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => '!"#$%&\'()*+,-./09:;<=>?@AZ[\\]^_`az{|}~',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => "a!\"#$%&'()*+,-./09:;<=>?@AZ[\\]^_`az{|}~",
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
                                        [
                                            'type' => IndentationNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::INDENTATION,
                                                    'text' => '     ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => '!"#$%&\'()*+,-./09:;<=>?@AZ[\\]^_`az{|}~',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
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
                                'key' => [
                                    'type' => KeyNode::class,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'safe question mark',
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
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => '?foo',
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
                                'key' => [
                                    'type' => KeyNode::class,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'safe colon',
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
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => ':foo',
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
                                'key' => [
                                    'type' => KeyNode::class,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'safe dash',
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
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => '-foo',
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
                                'key' => [
                                    'type' => KeyNode::class,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'safe percentage',
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
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => '%foo',
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
                    ],
                ],
            ],
        ], __DIR__.'/../../../fixture/edge_cases/allowed_characters_in_plain_scalars.yaml'];
    }
}
