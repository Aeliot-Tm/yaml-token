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
    'hash' => 2007989556,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 386274138,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowSequenceNode::class,
                    'hash' => 1924098547,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 3271794012,
                            ],
                            [
                                'type' => ValueNode::class,
                                'hash' => 559927547,
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
                            'type' => ValueNode::class,
                            'hash' => 3271794012,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1583972959,
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
                            'hash' => 559927547,
                            'properties' => [
                                'flowSequence' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 1816315590,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 1816315590,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 792149030,
                                            ],
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 3569730860,
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
                                            'type' => ValueNode::class,
                                            'hash' => 792149030,
                                            'properties' => [
                                                'scalar' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 4248765686,
                                                ],
                                            ],
                                            'children' => [
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
                                            'hash' => 3569730860,
                                            'properties' => [
                                                'scalar' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 719160494,
                                                ],
                                            ],
                                            'children' => [
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
                                    ],
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
