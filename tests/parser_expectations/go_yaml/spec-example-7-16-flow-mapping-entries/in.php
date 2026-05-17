<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
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
    'hash' => 641490574,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 130117387,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 148454686,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 2470312548,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 1597785465,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 3385104331,
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 2470312548,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 2668262237,
                                ],
                                'valueIndicator' => [
                                    'type' => ValueIndicatorNode::class,
                                    'hash' => 3779730559,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 2191598648,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 2668262237,
                                    'properties' => [
                                        'explicitKeyIndicatorNode' => [
                                            'type' => ExplicitKeyIndicatorNode::class,
                                            'hash' => 3326054058,
                                        ],
                                        'name' => [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 1334998506,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ExplicitKeyIndicatorNode::class,
                                            'hash' => 3326054058,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                    'text' => '?',
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
                                            'type' => PlainScalarNode::class,
                                            'hash' => 1334998506,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'explicit',
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
                                    'hash' => 2191598648,
                                    'properties' => [
                                        'payload' => [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 548396445,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 548396445,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'entry',
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
                            'hash' => 1597785465,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 360664100,
                                ],
                                'valueIndicator' => [
                                    'type' => ValueIndicatorNode::class,
                                    'hash' => 3779730559,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 2191598648,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 360664100,
                                    'properties' => [
                                        'name' => [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 906900243,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 906900243,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'implicit',
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
                                    'hash' => 2191598648,
                                    'properties' => [
                                        'payload' => [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 548396445,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => PlainScalarNode::class,
                                            'hash' => 548396445,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'entry',
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
                            'hash' => 3385104331,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 3843059533,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 3843059533,
                                    'properties' => [
                                        'explicitKeyIndicatorNode' => [
                                            'type' => ExplicitKeyIndicatorNode::class,
                                            'hash' => 3326054058,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ExplicitKeyIndicatorNode::class,
                                            'hash' => 3326054058,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                    'text' => '?',
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
