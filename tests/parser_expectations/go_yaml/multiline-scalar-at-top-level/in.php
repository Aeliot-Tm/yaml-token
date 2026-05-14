<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2338247997,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4041768053,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 3609420687,
                    'properties' => [
                        'multilinePlainScalar' => [
                            'type' => MultilinePlainScalarNode::class,
                            'hash' => 760833516,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1583972959,
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 4248765686,
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 719160494,
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1625493477,
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3070332861,
                                ],
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => ScalarNode::class,
                            'hash' => 1583972959,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'a',
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
                            'hash' => 4248765686,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'b',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => WhitespaceNode::class,
                            'hash' => 3308018566,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => '  ',
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
                            'type' => IndentationNode::class,
                            'hash' => 412793561,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::INDENTATION,
                                    'text' => '  ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => ScalarNode::class,
                            'hash' => 719160494,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'c',
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
                            'hash' => 1625493477,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'd',
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
                            'hash' => 3070332861,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'e',
                                ],
                            ],
                            'children' => [],
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
