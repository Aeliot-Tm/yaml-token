<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 571325000,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 255999805,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowSequenceNode::class,
                    'hash' => 338291420,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 722256075,
                            ],
                            [
                                'type' => ValueNode::class,
                                'hash' => 1686713637,
                            ],
                            [
                                'type' => ValueNode::class,
                                'hash' => 2421855274,
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 3296102772,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                    'text' => '[',
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
                            'hash' => 722256075,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 22999485,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 22999485,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'https://simple.uri',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 3965909453,
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
                            'hash' => 1686713637,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2722535919,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2722535919,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'https://with.query?a[]=b&a[]=b',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 3965909453,
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
                            'hash' => 2421855274,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 679854168,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 679854168,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'https://with.anchor?a=b#anc',
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
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 2678523598,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                    'text' => ']',
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
                    ],
                ],
            ],
        ],
    ],
];
