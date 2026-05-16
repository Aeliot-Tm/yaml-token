<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3008669252,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1538378284,
            'properties' => [],
            'children' => [
                [
                    'type' => SequenceEntryNode::class,
                    'hash' => 3188745687,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2605769208,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 990219541,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                            'hash' => 2605769208,
                            'properties' => [
                                'flowMapping' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 607140111,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 607140111,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1441630689,
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
                                            'hash' => 1441630689,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4047632291,
                                                ],
                                                'mappingValueIndicator' => [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 1087047134,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4047632291,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 680814648,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 680814648,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                                    'text' => '"key"',
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
                                                    'hash' => 1087047134,
                                                    'properties' => [
                                                        'scalar' => [
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
                ],
                [
                    'type' => SequenceEntryNode::class,
                    'hash' => 1540000735,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 24367691,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 990219541,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                            'hash' => 24367691,
                            'properties' => [
                                'flowMapping' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 977423460,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 977423460,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1332677214,
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
                                            'hash' => 1332677214,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4047632291,
                                                ],
                                                'mappingValueIndicator' => [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 4243570079,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4047632291,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 680814648,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 680814648,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                                    'text' => '"key"',
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
                                                    'hash' => 4243570079,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3014146343,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3014146343,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => ':value',
                                                                ],
                                                            ],
                                                            'children' => [],
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
                ],
            ],
        ],
    ],
];
