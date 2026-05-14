<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1632998020,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1529322125,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2952043338,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3584508095,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3990066456,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3584508095,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1569829917,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1569829917,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'integer',
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
                            'hash' => 3990066456,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 427106851,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 427106851,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '3:25:45',
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
                    'hash' => 2085124753,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 267431938,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3272118695,
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
                            'hash' => 3272118695,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3879442992,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3879442992,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '190:20:30.15',
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
