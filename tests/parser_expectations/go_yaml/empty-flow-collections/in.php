<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
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
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3827452130,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3207618778,
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
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1133041993,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2993228715,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4172322135,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2993228715,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 2320799958,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 2320799958,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'nested sequences',
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
                            'hash' => 4172322135,
                            'properties' => [],
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 2644165422,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 91534146,
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
                            'hash' => 91534146,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 488996131,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 488996131,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => BlockSequenceEntryNode::class,
                                                'hash' => 2005160303,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => BlockSequenceEntryNode::class,
                                            'hash' => 2005160303,
                                            'properties' => [
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 1575944843,
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
                                                    'hash' => 1575944843,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 3725142393,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 3725142393,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => BlockSequenceEntryNode::class,
                                                                        'hash' => 3527918314,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => BlockSequenceEntryNode::class,
                                                                    'hash' => 3527918314,
                                                                    'properties' => [
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 3434105358,
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
                                                                            'hash' => 3434105358,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => FlowSequenceNode::class,
                                                                                    'hash' => 4127089306,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => FlowSequenceNode::class,
                                                                                    'hash' => 4127089306,
                                                                                    'properties' => [
                                                                                        'entries' => [],
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
                    'hash' => 780932611,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 887549272,
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
                            'hash' => 887549272,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 1494942822,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 1494942822,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => BlockSequenceEntryNode::class,
                                                'hash' => 3168899719,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => BlockSequenceEntryNode::class,
                                            'hash' => 3168899719,
                                            'properties' => [
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 207520888,
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
                                                    'hash' => 207520888,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 4226196032,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 4226196032,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => BlockSequenceEntryNode::class,
                                                                        'hash' => 108212150,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => BlockSequenceEntryNode::class,
                                                                    'hash' => 108212150,
                                                                    'properties' => [
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 371040480,
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
                                                                            'hash' => 371040480,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => FlowMappingNode::class,
                                                                                    'hash' => 639776339,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => FlowMappingNode::class,
                                                                                    'hash' => 639776339,
                                                                                    'properties' => [
                                                                                        'entries' => [],
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
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3241737354,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 998259313,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3434105358,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 998259313,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3370509301,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3370509301,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'key1',
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
                            'hash' => 3434105358,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 4127089306,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 4127089306,
                                    'properties' => [
                                        'entries' => [],
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
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3668478861,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2515133576,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 371040480,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2515133576,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1806919004,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1806919004,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'key2',
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
                            'hash' => 371040480,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 639776339,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 639776339,
                                    'properties' => [
                                        'entries' => [],
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
