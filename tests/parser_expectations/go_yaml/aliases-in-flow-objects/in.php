<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
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
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 358084944,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3475261640,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 3260088964,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 1601968219,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 67671932,
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
                            'hash' => 1601968219,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 3084425204,
                                ],
                                'valueIndicator' => [
                                    'type' => ValueIndicatorNode::class,
                                    'hash' => 3779730559,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 801295602,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 3084425204,
                                    'properties' => [
                                        'nodeProperties' => [
                                            'type' => NodePropertiesNode::class,
                                            'hash' => 2621467804,
                                        ],
                                        'name' => [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 43911900,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => NodePropertiesNode::class,
                                            'hash' => 2621467804,
                                            'properties' => [
                                                'anchor' => [
                                                    'type' => AnchorPropertyNode::class,
                                                    'hash' => 2802398246,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => AnchorPropertyNode::class,
                                                    'hash' => 2802398246,
                                                    'properties' => [
                                                        'name' => 'a',
                                                        'token' => [
                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                            'text' => '&a',
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
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 43911900,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 1439690933,
                                                    ],
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 326146698,
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
                                                    'hash' => 326146698,
                                                    'properties' => [
                                                        'nodeProperties' => [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 3231633635,
                                                        ],
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 1439155551,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 3231633635,
                                                            'properties' => [
                                                                'anchor' => [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 1578124260,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 1578124260,
                                                                    'properties' => [
                                                                        'name' => 'b',
                                                                        'token' => [
                                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                                            'text' => '&b',
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
                                    'hash' => 801295602,
                                    'properties' => [
                                        'payload' => [
                                            'type' => AliasNode::class,
                                            'hash' => 1955139519,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AliasNode::class,
                                            'hash' => 1955139519,
                                            'properties' => [
                                                'name' => 'b',
                                                'anchorName' => 'b',
                                                'token' => [
                                                    'type' => TokenType::ALIAS_NODE,
                                                    'text' => '*b',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 67671932,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 2640921991,
                                ],
                                'valueIndicator' => [
                                    'type' => ValueIndicatorNode::class,
                                    'hash' => 3779730559,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 938903958,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 2640921991,
                                    'properties' => [
                                        'name' => [
                                            'type' => AliasNode::class,
                                            'hash' => 3399154601,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AliasNode::class,
                                            'hash' => 3399154601,
                                            'properties' => [
                                                'name' => 'a',
                                                'anchorName' => 'a',
                                                'token' => [
                                                    'type' => TokenType::ALIAS_NODE,
                                                    'text' => '*a',
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
                                    'hash' => 938903958,
                                    'properties' => [
                                        'payload' => [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 1850564923,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 1850564923,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 897038269,
                                                    ],
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 801295602,
                                                    ],
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 999563081,
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
                                                    'hash' => 897038269,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2183480583,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2183480583,
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
                                                    'hash' => 801295602,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => AliasNode::class,
                                                            'hash' => 1955139519,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => AliasNode::class,
                                                            'hash' => 1955139519,
                                                            'properties' => [
                                                                'name' => 'b',
                                                                'anchorName' => 'b',
                                                                'token' => [
                                                                    'type' => TokenType::ALIAS_NODE,
                                                                    'text' => '*b',
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
                                                    'hash' => 999563081,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3357265484,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3357265484,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'd',
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
