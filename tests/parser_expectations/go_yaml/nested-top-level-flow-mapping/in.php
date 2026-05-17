<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 321606553,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1114958167,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 2040650466,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 3766952649,
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => FlowMappingStartNode::class,
                            'hash' => 1553869732,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_START,
                                    'text' => '{',
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 3766952649,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 3646687587,
                                ],
                                'valueIndicator' => [
                                    'type' => ValueIndicatorNode::class,
                                    'hash' => 3779730559,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 2068922235,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 3646687587,
                                    'properties' => [
                                        'name' => [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 1518534119,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 1518534119,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'key',
                                                ],
                                            ],
                                            'children' => [],
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
                                    'hash' => 2068922235,
                                    'properties' => [
                                        'payload' => [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 2777544662,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 2777544662,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 2121144871,
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
                                                    'type' => ValueNode::class,
                                                    'hash' => 2121144871,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => FlowSequenceNode::class,
                                                            'hash' => 3636380883,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => FlowSequenceNode::class,
                                                            'hash' => 3636380883,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => ValueNode::class,
                                                                        'hash' => 2474129683,
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
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 2474129683,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => FlowSequenceNode::class,
                                                                            'hash' => 2682768003,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => FlowSequenceNode::class,
                                                                            'hash' => 2682768003,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => ValueNode::class,
                                                                                        'hash' => 2159477566,
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
                                                                                    'type' => ValueNode::class,
                                                                                    'hash' => 2159477566,
                                                                                    'properties' => [
                                                                                        'payload' => [
                                                                                            'type' => PlainScalarNode::class,
                                                                                            'hash' => 4152093896,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => PlainScalarNode::class,
                                                                                            'hash' => 4152093896,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                    'text' => 'value',
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
                                                                    ],
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
                                                    ],
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
                            'type' => FlowMappingEndNode::class,
                            'hash' => 1100359731,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_END,
                                    'text' => '}',
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
