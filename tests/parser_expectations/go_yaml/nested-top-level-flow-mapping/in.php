<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
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
    'hash' => 3889030119,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3741909465,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 2384231736,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 827044494,
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 1300945157,
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
                            'hash' => 827044494,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 1885271233,
                                ],
                                'valueIndicator' => [
                                    'type' => ValueIndicatorNode::class,
                                    'hash' => 3779730559,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 2727961499,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 1885271233,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 3374620825,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3374620825,
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
                                    'hash' => 2727961499,
                                    'properties' => [
                                        'payload' => [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 3685628273,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 3685628273,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 388654617,
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
                                                    'hash' => 388654617,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => FlowSequenceNode::class,
                                                            'hash' => 2509099817,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => FlowSequenceNode::class,
                                                            'hash' => 2509099817,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => ValueNode::class,
                                                                        'hash' => 390449243,
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
                                                                    'hash' => 390449243,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => FlowSequenceNode::class,
                                                                            'hash' => 2004784441,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => FlowSequenceNode::class,
                                                                            'hash' => 2004784441,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => ValueNode::class,
                                                                                        'hash' => 2835940159,
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
                                                                                    'hash' => 2835940159,
                                                                                    'properties' => [
                                                                                        'payload' => [
                                                                                            'type' => ScalarNode::class,
                                                                                            'hash' => 1394411103,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => ScalarNode::class,
                                                                                            'hash' => 1394411103,
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
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 2204982300,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_END,
                                    'text' => '}',
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
