<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1855866482,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2616262963,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 53070790,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 467195616,
                        ],
                        'payload' => [
                            'type' => FlowMappingNode::class,
                            'hash' => 1194245573,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 467195616,
                            'properties' => [
                                'tag' => [
                                    'type' => TagPropertyNode::class,
                                    'hash' => 298035206,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagPropertyNode::class,
                                    'hash' => 298035206,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG_PROPERTY,
                                            'text' => '!!map',
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
                            'type' => FlowMappingNode::class,
                            'hash' => 1194245573,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 1429183580,
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
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 1429183580,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 263945691,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 3197038888,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 263945691,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2340706434,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2340706434,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'k',
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
                                            'hash' => 3197038888,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 2569658227,
                                                ],
                                                'payload' => [
                                                    'type' => FlowSequenceNode::class,
                                                    'hash' => 3513216852,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 2569658227,
                                                    'properties' => [
                                                        'tag' => [
                                                            'type' => TagPropertyNode::class,
                                                            'hash' => 283630939,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => TagPropertyNode::class,
                                                            'hash' => 283630939,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::TAG_PROPERTY,
                                                                    'text' => '!!seq',
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
                                                    'type' => FlowSequenceNode::class,
                                                    'hash' => 3513216852,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => ValueNode::class,
                                                                'hash' => 1439690933,
                                                            ],
                                                            [
                                                                'type' => ValueNode::class,
                                                                'hash' => 4140337807,
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
                                                            'hash' => 4140337807,
                                                            'properties' => [
                                                                'nodeProperties' => [
                                                                    'type' => NodePropertiesNode::class,
                                                                    'hash' => 3273011123,
                                                                ],
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 1439155551,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => NodePropertiesNode::class,
                                                                    'hash' => 3273011123,
                                                                    'properties' => [
                                                                        'tag' => [
                                                                            'type' => TagPropertyNode::class,
                                                                            'hash' => 907070353,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => TagPropertyNode::class,
                                                                            'hash' => 907070353,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::TAG_PROPERTY,
                                                                                    'text' => '!!str',
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
