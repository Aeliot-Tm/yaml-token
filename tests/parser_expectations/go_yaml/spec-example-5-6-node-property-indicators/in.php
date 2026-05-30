<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
use Aeliot\YamlToken\Node\DocumentNode;
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
    'hash' => 2988920767,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3364485338,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3487833725,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2670279226,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1128287250,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2670279226,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 391647849,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 391647849,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'anchored',
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
                            'hash' => 1128287250,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3854331194,
                                ],
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4152093896,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3854331194,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 29328054,
                                        ],
                                        'tag' => [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 2813034140,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 2813034140,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG_PROPERTY,
                                                    'text' => '!local',
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
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 29328054,
                                            'properties' => [
                                                'name' => 'anchor',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR_PROPERTY,
                                                    'text' => '&anchor',
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
                    'hash' => 2415330553,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2239464968,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2213935690,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2239464968,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3756840106,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3756840106,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'alias',
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
                            'hash' => 2213935690,
                            'properties' => [
                                'payload' => [
                                    'type' => AliasNode::class,
                                    'hash' => 3134551282,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => AliasNode::class,
                                    'hash' => 3134551282,
                                    'properties' => [
                                        'name' => 'anchor',
                                        'anchorName' => 'anchor',
                                        'token' => [
                                            'type' => TokenType::ALIAS_NODE,
                                            'text' => '*anchor',
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
