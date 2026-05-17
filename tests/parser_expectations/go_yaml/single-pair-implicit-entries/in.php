<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1900366420,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 343377207,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 2996133425,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1905276162,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 1905276162,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 997203468,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 997203468,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 1398140095,
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
                                            'hash' => 1398140095,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 720828766,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 720828766,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 3088934805,
                                                        ],
                                                        'valueIndicator' => [
                                                            'type' => ValueIndicatorNode::class,
                                                            'hash' => 3779730559,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 1838453234,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 3088934805,
                                                            'properties' => [
                                                                'name' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 3118396138,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 3118396138,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'YAML',
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
                                                            'hash' => 1838453234,
                                                            'properties' => [
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 882721736,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 882721736,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'separate',
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
                ],
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 3851099180,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3230208140,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 3230208140,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 3115669410,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 3115669410,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 268335868,
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
                                            'hash' => 268335868,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 62886346,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 62886346,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 4164499502,
                                                        ],
                                                        'valueIndicator' => [
                                                            'type' => ValueIndicatorNode::class,
                                                            'hash' => 3779730559,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 627110608,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 4164499502,
                                                            'properties' => [
                                                                'name' => [
                                                                    'type' => DoubleQuotedScalarNode::class,
                                                                    'hash' => 2243928382,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => DoubleQuotedScalarNode::class,
                                                                    'hash' => 2243928382,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                                            'text' => '"JSON like"',
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
                                                            'type' => ValueNode::class,
                                                            'hash' => 627110608,
                                                            'properties' => [
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 2231817774,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 2231817774,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'adjacent',
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
                ],
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 1551371093,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2787142743,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 2787142743,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 1353795121,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 1353795121,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 1887179489,
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
                                            'hash' => 1887179489,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 1582974488,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 1582974488,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 4149938580,
                                                        ],
                                                        'valueIndicator' => [
                                                            'type' => ValueIndicatorNode::class,
                                                            'hash' => 3779730559,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 627110608,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 4149938580,
                                                            'properties' => [
                                                                'name' => [
                                                                    'type' => FlowMappingNode::class,
                                                                    'hash' => 945920188,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => FlowMappingNode::class,
                                                                    'hash' => 945920188,
                                                                    'properties' => [
                                                                        'entries' => [
                                                                            [
                                                                                'type' => KeyValueCoupleNode::class,
                                                                                'hash' => 3302195777,
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
                                                                            'type' => KeyValueCoupleNode::class,
                                                                            'hash' => 3302195777,
                                                                            'properties' => [
                                                                                'key' => [
                                                                                    'type' => KeyNode::class,
                                                                                    'hash' => 425469894,
                                                                                ],
                                                                                'valueIndicator' => [
                                                                                    'type' => ValueIndicatorNode::class,
                                                                                    'hash' => 3779730559,
                                                                                ],
                                                                                'value' => [
                                                                                    'type' => ValueNode::class,
                                                                                    'hash' => 38926127,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => KeyNode::class,
                                                                                    'hash' => 425469894,
                                                                                    'properties' => [
                                                                                        'name' => [
                                                                                            'type' => PlainScalarNode::class,
                                                                                            'hash' => 940275207,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => PlainScalarNode::class,
                                                                                            'hash' => 940275207,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                    'text' => 'JSON',
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
                                                                                    'hash' => 38926127,
                                                                                    'properties' => [
                                                                                        'payload' => [
                                                                                            'type' => PlainScalarNode::class,
                                                                                            'hash' => 119396113,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => PlainScalarNode::class,
                                                                                            'hash' => 119396113,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                    'text' => 'like',
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
                                                                            'hash' => 2204982300,
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
                                                            'type' => ValueNode::class,
                                                            'hash' => 627110608,
                                                            'properties' => [
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 2231817774,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 2231817774,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'adjacent',
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
                ],
            ],
        ],
    ],
];
