<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1804546144,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1050001981,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3021994988,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1253468283,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1721164880,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1253468283,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2984777658,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2984777658,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'canonical',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 675194587,
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
                            'hash' => 1067539092,
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
                            'hash' => 1721164880,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 61029531,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 816654948,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 61029531,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 1823009045,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 1823009045,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!!binary',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => WhitespaceNode::class,
                                    'hash' => 1067539092,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::WHITESPACE,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 816654948,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                            'text' => "\"\\\n R0lGODlhDAAMAIQAAP//9/X17unp5WZmZgAAAOfn515eXvPz7Y6OjuDg4J+fn5\\\n OTk6enp56enmlpaWNjY6Ojo4SEhP/++f/++f/++f/++f/++f/++f/++f/++f/+\\\n +f/++f/++f/++f/++f/++SH+Dk1hZGUgd2l0aCBHSU1QACwAAAAADAAMAAAFLC\\\n AgjoEwnuNAFOhpEMTRiggcz4BNJHrv/zCFcLiwMWYNG84BwwEeECcgggoBADs=\"",
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => NewLineNode::class,
                    'hash' => 763369711,
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
                    'hash' => 1226941641,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2475988506,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1552728084,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2475988506,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2908674921,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2908674921,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'generic',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 675194587,
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
                            'hash' => 1067539092,
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
                            'hash' => 1552728084,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 61029531,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2441565727,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 61029531,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 1823009045,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 1823009045,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!!binary',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => WhitespaceNode::class,
                                    'hash' => 1067539092,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::WHITESPACE,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarIndicatorNode::class,
                                    'hash' => 1768284065,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                            'text' => '|',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => NewLineNode::class,
                                    'hash' => 763369711,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::NEWLINE,
                                            'text' => "\n",
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2441565727,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                            'text' => " R0lGODlhDAAMAIQAAP//9/X17unp5WZmZgAAAOfn515eXvPz7Y6OjuDg4J+fn5\n OTk6enp56enmlpaWNjY6Ojo4SEhP/++f/++f/++f/++f/++f/++f/++f/++f/+\n +f/++f/++f/++f/++f/++SH+Dk1hZGUgd2l0aCBHSU1QACwAAAAADAAMAAAFLC\n AgjoEwnuNAFOhpEMTRiggcz4BNJHrv/zCFcLiwMWYNG84BwwEeECcgggoBADs=\n",
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 624030759,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3046990450,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2344585671,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3046990450,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 709560201,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 709560201,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'description',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 675194587,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::VALUE_INDICATOR,
                                    'text' => ':',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => ValueNode::class,
                            'hash' => 2344585671,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1752634058,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NewLineNode::class,
                                    'hash' => 763369711,
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
                                    'hash' => 2218577147,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::INDENTATION,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1752634058,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'The binary value above is a tiny arrow encoded as a gif image.',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => NewLineNode::class,
                    'hash' => 763369711,
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
];
