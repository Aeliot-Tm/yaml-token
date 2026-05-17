<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 571014870,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1880524702,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 1023662130,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 82230387,
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
                            'hash' => 82230387,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 1580415764,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 1580415764,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1162510444,
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
                                            'hash' => 1162510444,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3336724559,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2159477566,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3336724559,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => DoubleQuotedScalarNode::class,
                                                            'hash' => 2021487631,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => DoubleQuotedScalarNode::class,
                                                            'hash' => 2021487631,
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 138498764,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2521781017,
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
                            'hash' => 2521781017,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 177108721,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 177108721,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1282109863,
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
                                            'hash' => 1282109863,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3336724559,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2758889272,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3336724559,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => DoubleQuotedScalarNode::class,
                                                            'hash' => 2021487631,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => DoubleQuotedScalarNode::class,
                                                            'hash' => 2021487631,
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
                                                    'hash' => 2758889272,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3714537770,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3714537770,
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
