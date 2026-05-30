<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
use Aeliot\YamlToken\Node\BlockIndentationNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
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
    'hash' => 3124656143,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 568275386,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 674992207,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 4278132585,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 326146698,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 4278132585,
                            'properties' => [
                                'explicitKeyIndicatorNode' => [
                                    'type' => ExplicitKeyIndicatorNode::class,
                                    'hash' => 3326054058,
                                ],
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2621467804,
                                ],
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4136715254,
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
                                    'type' => BlockIndentationNode::class,
                                    'hash' => 2285796975,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_INDENT,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
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
                    'hash' => 2908400584,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 223405430,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3740785683,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 223405430,
                            'properties' => [],
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
                            'hash' => 3740785683,
                            'properties' => [
                                'payload' => [
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
