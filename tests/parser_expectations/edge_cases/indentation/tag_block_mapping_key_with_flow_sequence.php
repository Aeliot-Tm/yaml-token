<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2511832960,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3087628474,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2687034256,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 307232827,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1380847798,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 307232827,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 422097949,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 422097949,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'root',
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
                            'hash' => 1380847798,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 1906915192,
                                ],
                            ],
                            'children' => [
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
                                    'type' => BlockMappingNode::class,
                                    'hash' => 1906915192,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3400794395,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 3400794395,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4178987570,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 1509111250,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENTATION,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4178987570,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 4118358523,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 4118358523,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'tagged',
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
                                                    'hash' => 1509111250,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 3452227211,
                                                        ],
                                                    ],
                                                    'children' => [
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
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 3452227211,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 448756829,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 448756829,
                                                                    'properties' => [
                                                                        'indentation' => [
                                                                            'type' => IndentationNode::class,
                                                                            'hash' => 3551679428,
                                                                        ],
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 2483576074,
                                                                        ],
                                                                        'valueIndicator' => [
                                                                            'type' => ValueIndicatorNode::class,
                                                                            'hash' => 3779730559,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 1341247175,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => IndentationNode::class,
                                                                            'hash' => 3551679428,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::INDENTATION,
                                                                                    'text' => '    ',
                                                                                ],
                                                                            ],
                                                                            'children' => [],
                                                                        ],
                                                                        [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 2483576074,
                                                                            'properties' => [
                                                                                'nodeProperties' => [
                                                                                    'type' => NodePropertiesNode::class,
                                                                                    'hash' => 131013440,
                                                                                ],
                                                                                'name' => [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 2180391599,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => NodePropertiesNode::class,
                                                                                    'hash' => 131013440,
                                                                                    'properties' => [
                                                                                        'tag' => [
                                                                                            'type' => TagNode::class,
                                                                                            'hash' => 3852800516,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => TagNode::class,
                                                                                            'hash' => 3852800516,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::TAG,
                                                                                                    'text' => '!localTag',
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
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 2180391599,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'child',
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
                                                                            'hash' => 1341247175,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 1237202225,
                                                                                ],
                                                                            ],
                                                                            'children' => [
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
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 1237202225,
                                                                                    'properties' => [
                                                                                        'entries' => [
                                                                                            [
                                                                                                'type' => KeyValueCoupleNode::class,
                                                                                                'hash' => 3428224769,
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyValueCoupleNode::class,
                                                                                            'hash' => 3428224769,
                                                                                            'properties' => [
                                                                                                'indentation' => [
                                                                                                    'type' => IndentationNode::class,
                                                                                                    'hash' => 4110986796,
                                                                                                ],
                                                                                                'key' => [
                                                                                                    'type' => KeyNode::class,
                                                                                                    'hash' => 1764810289,
                                                                                                ],
                                                                                                'valueIndicator' => [
                                                                                                    'type' => ValueIndicatorNode::class,
                                                                                                    'hash' => 3779730559,
                                                                                                ],
                                                                                                'value' => [
                                                                                                    'type' => ValueNode::class,
                                                                                                    'hash' => 1151994897,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => IndentationNode::class,
                                                                                                    'hash' => 4110986796,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::INDENTATION,
                                                                                                            'text' => '      ',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                                [
                                                                                                    'type' => KeyNode::class,
                                                                                                    'hash' => 1764810289,
                                                                                                    'properties' => [
                                                                                                        'name' => [
                                                                                                            'type' => PlainScalarNode::class,
                                                                                                            'hash' => 2508803809,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => PlainScalarNode::class,
                                                                                                            'hash' => 2508803809,
                                                                                                            'properties' => [
                                                                                                                'token' => [
                                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                                    'text' => 'next',
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
                                                                                                    'hash' => 1151994897,
                                                                                                    'properties' => [
                                                                                                        'payload' => [
                                                                                                            'type' => FlowSequenceNode::class,
                                                                                                            'hash' => 1519454359,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => FlowSequenceNode::class,
                                                                                                            'hash' => 1519454359,
                                                                                                            'properties' => [
                                                                                                                'entries' => [
                                                                                                                    [
                                                                                                                        'type' => ValueNode::class,
                                                                                                                        'hash' => 1439690933,
                                                                                                                    ],
                                                                                                                    [
                                                                                                                        'type' => ValueNode::class,
                                                                                                                        'hash' => 1154444269,
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
                                                                                                                    'hash' => 1439690933,
                                                                                                                    'properties' => [
                                                                                                                        'payload' => [
                                                                                                                            'type' => PlainScalarNode::class,
                                                                                                                            'hash' => 4136715254,
                                                                                                                        ],
                                                                                                                    ],
                                                                                                                    'children' => [
                                                                                                                        [
                                                                                                                            'type' => PlainScalarNode::class,
                                                                                                                            'hash' => 4136715254,
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
                                                                                                                    'hash' => 1154444269,
                                                                                                                    'properties' => [
                                                                                                                        'payload' => [
                                                                                                                            'type' => PlainScalarNode::class,
                                                                                                                            'hash' => 1439155551,
                                                                                                                        ],
                                                                                                                    ],
                                                                                                                    'children' => [
                                                                                                                        [
                                                                                                                            'type' => PlainScalarNode::class,
                                                                                                                            'hash' => 1439155551,
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
