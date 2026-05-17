<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2319508938,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1095847491,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowSequenceNode::class,
                    'hash' => 2704586363,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 2151650593,
                            ],
                            [
                                'type' => ValueNode::class,
                                'hash' => 3975149267,
                            ],
                            [
                                'type' => ValueNode::class,
                                'hash' => 336578228,
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => FlowSequenceStartNode::class,
                            'hash' => 2336973104,
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
                            'hash' => 2151650593,
                            'properties' => [
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 2563088871,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 2563088871,
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
                            'type' => FlowEntryNode::class,
                            'hash' => 1715075807,
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
                            'hash' => 3975149267,
                            'properties' => [
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1405710813,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1405710813,
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
                            'type' => FlowEntryNode::class,
                            'hash' => 1715075807,
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
                            'hash' => 336578228,
                            'properties' => [
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1299815739,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1299815739,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'https://with.anchor?a=b#anc',
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
                            'type' => FlowSequenceEndNode::class,
                            'hash' => 539304155,
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
