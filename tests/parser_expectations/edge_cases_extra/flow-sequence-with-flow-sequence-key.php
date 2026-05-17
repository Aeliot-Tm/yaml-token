<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1719247490,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1145832622,
            'properties' => [],
            'children' => [
                [
                    'type' => DocumentStartNode::class,
                    'hash' => 2270658446,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DOCUMENT_START,
                            'text' => '---',
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
                    'type' => FlowSequenceNode::class,
                    'hash' => 1793890939,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 1549807650,
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
                            'hash' => 1549807650,
                            'properties' => [
                                'payload' => [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 346541256,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 346541256,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 4170534428,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2814916836,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 4170534428,
                                            'properties' => [
                                                'name' => [
                                                    'type' => FlowSequenceNode::class,
                                                    'hash' => 3086016597,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => FlowSequenceNode::class,
                                                    'hash' => 3086016597,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => ValueNode::class,
                                                                'hash' => 53231030,
                                                            ],
                                                            [
                                                                'type' => ValueNode::class,
                                                                'hash' => 4011367628,
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
                                                            'hash' => 53231030,
                                                            'properties' => [
                                                                'payload' => [
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
                                                            'hash' => 4011367628,
                                                            'properties' => [
                                                                'payload' => [
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
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
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
                                            'hash' => 2814916836,
                                            'properties' => [
                                                'payload' => [
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
                                    ],
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
