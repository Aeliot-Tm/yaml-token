<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3805592283,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 130764662,
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
                    'hash' => 1726893412,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3526002945,
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
                            'hash' => 3526002945,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 759474370,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 759474370,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => BlockSequenceEntryNode::class,
                                                'hash' => 2391308900,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => BlockSequenceEntryNode::class,
                                            'hash' => 2391308900,
                                            'properties' => [
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 3975584155,
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
                                                    'hash' => 3975584155,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 3665051819,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 3665051819,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => BlockSequenceEntryNode::class,
                                                                        'hash' => 336791643,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => BlockSequenceEntryNode::class,
                                                                    'hash' => 336791643,
                                                                    'properties' => [
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 485136513,
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
                                                                            'hash' => 485136513,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => FlowSequenceNode::class,
                                                                                    'hash' => 1573408224,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => FlowSequenceNode::class,
                                                                                    'hash' => 1573408224,
                                                                                    'properties' => [
                                                                                        'entries' => [],
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 3539385022,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1600051824,
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
                            'hash' => 1600051824,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 176565083,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockSequenceNode::class,
                                    'hash' => 176565083,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => BlockSequenceEntryNode::class,
                                                'hash' => 3177665731,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => BlockSequenceEntryNode::class,
                                            'hash' => 3177665731,
                                            'properties' => [
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2652296735,
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
                                                    'hash' => 2652296735,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 4012410736,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockSequenceNode::class,
                                                            'hash' => 4012410736,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => BlockSequenceEntryNode::class,
                                                                        'hash' => 1509641260,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => BlockSequenceEntryNode::class,
                                                                    'hash' => 1509641260,
                                                                    'properties' => [
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 1826830261,
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
                                                                            'hash' => 1826830261,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => FlowMappingNode::class,
                                                                                    'hash' => 233425442,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => FlowMappingNode::class,
                                                                                    'hash' => 233425442,
                                                                                    'properties' => [
                                                                                        'entries' => [],
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
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1339369122,
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
                            'hash' => 485136513,
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
                            'hash' => 485136513,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 1573408224,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 1573408224,
                                    'properties' => [
                                        'entries' => [],
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
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 535130109,
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
                            'hash' => 1826830261,
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
                            'hash' => 1826830261,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 233425442,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 233425442,
                                    'properties' => [
                                        'entries' => [],
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
