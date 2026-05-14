<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
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
    'hash' => 1096840310,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 850740284,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 560933158,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 118598401,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 529808230,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 118598401,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2288300108,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2288300108,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'str',
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
                            'hash' => 529808230,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2805732162,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2614968889,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2805732162,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 1166972359,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 1166972359,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!!str',
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
                                    'hash' => 2614968889,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '2002-04-28',
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
                    'hash' => 2804548979,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3117343986,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3530628326,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3117343986,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 683256483,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 683256483,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'int',
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
                            'hash' => 3530628326,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3840819627,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1354329777,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3840819627,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 3847458600,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 3847458600,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!!int',
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
                                    'hash' => 1354329777,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '42',
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
                    'hash' => 4011470966,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 267431938,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2206129515,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 267431938,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2972723230,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2972723230,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'float',
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
                            'hash' => 2206129515,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 347883714,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2576706415,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 347883714,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 574844979,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 574844979,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!!float',
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
                                    'hash' => 2576706415,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '3.14',
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
