<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\IndentNode;
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
    'hash' => 3046502902,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1987373004,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 623092551,
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
                            'hash' => 1782718578,
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
                            'hash' => 1782718578,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 2628158438,
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
                                    'hash' => 2628158438,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3018746673,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 3018746673,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
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
                                                    'hash' => 1115682210,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
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
                                                    'hash' => 1115682210,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 3794187116,
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
                                                            'hash' => 3794187116,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 1232694229,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 1232694229,
                                                                    'properties' => [
                                                                        'indent' => [
                                                                            'type' => IndentNode::class,
                                                                            'hash' => 1569392133,
                                                                        ],
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 3748611013,
                                                                        ],
                                                                        'valueIndicator' => [
                                                                            'type' => ValueIndicatorNode::class,
                                                                            'hash' => 3779730559,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 3022903984,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => IndentNode::class,
                                                                            'hash' => 1569392133,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::INDENT,
                                                                                    'text' => '    ',
                                                                                ],
                                                                            ],
                                                                            'children' => [],
                                                                        ],
                                                                        [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 3748611013,
                                                                            'properties' => [
                                                                                'nodeProperties' => [
                                                                                    'type' => NodePropertiesNode::class,
                                                                                    'hash' => 3136363957,
                                                                                ],
                                                                                'name' => [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 2180391599,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => NodePropertiesNode::class,
                                                                                    'hash' => 3136363957,
                                                                                    'properties' => [
                                                                                        'tag' => [
                                                                                            'type' => TagPropertyNode::class,
                                                                                            'hash' => 1261422290,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => TagPropertyNode::class,
                                                                                            'hash' => 1261422290,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::TAG_PROPERTY,
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
                                                                            'hash' => 3022903984,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 3632927373,
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
                                                                                    'type' => CommentNode::class,
                                                                                    'hash' => 3518869618,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::COMMENT,
                                                                                            'text' => '# comment',
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
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 3632927373,
                                                                                    'properties' => [
                                                                                        'entries' => [
                                                                                            [
                                                                                                'type' => KeyValueCoupleNode::class,
                                                                                                'hash' => 2791569830,
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyValueCoupleNode::class,
                                                                                            'hash' => 2791569830,
                                                                                            'properties' => [
                                                                                                'indent' => [
                                                                                                    'type' => IndentNode::class,
                                                                                                    'hash' => 1021862753,
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
                                                                                                    'hash' => 2355337782,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => IndentNode::class,
                                                                                                    'hash' => 1021862753,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::INDENT,
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
                                                                                                    'hash' => 2355337782,
                                                                                                    'properties' => [
                                                                                                        'payload' => [
                                                                                                            'type' => FlowMappingNode::class,
                                                                                                            'hash' => 12835748,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => FlowMappingNode::class,
                                                                                                            'hash' => 12835748,
                                                                                                            'properties' => [
                                                                                                                'entries' => [
                                                                                                                    [
                                                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                                                        'hash' => 550951854,
                                                                                                                    ],
                                                                                                                    [
                                                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                                                        'hash' => 3745079427,
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
                                                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                                                    'hash' => 550951854,
                                                                                                                    'properties' => [
                                                                                                                        'key' => [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 1763095533,
                                                                                                                        ],
                                                                                                                        'valueIndicator' => [
                                                                                                                            'type' => ValueIndicatorNode::class,
                                                                                                                            'hash' => 3779730559,
                                                                                                                        ],
                                                                                                                        'value' => [
                                                                                                                            'type' => ValueNode::class,
                                                                                                                            'hash' => 184253543,
                                                                                                                        ],
                                                                                                                    ],
                                                                                                                    'children' => [
                                                                                                                        [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 1763095533,
                                                                                                                            'properties' => [
                                                                                                                                'name' => [
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
                                                                                                                            'hash' => 184253543,
                                                                                                                            'properties' => [
                                                                                                                                'payload' => [
                                                                                                                                    'type' => PlainScalarNode::class,
                                                                                                                                    'hash' => 2951607223,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => PlainScalarNode::class,
                                                                                                                                    'hash' => 2951607223,
                                                                                                                                    'properties' => [
                                                                                                                                        'token' => [
                                                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                                                            'text' => 'v',
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
                                                                                                                    'hash' => 3745079427,
                                                                                                                    'properties' => [
                                                                                                                        'key' => [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 2014718133,
                                                                                                                        ],
                                                                                                                        'valueIndicator' => [
                                                                                                                            'type' => ValueIndicatorNode::class,
                                                                                                                            'hash' => 3779730559,
                                                                                                                        ],
                                                                                                                        'value' => [
                                                                                                                            'type' => ValueNode::class,
                                                                                                                            'hash' => 184253543,
                                                                                                                        ],
                                                                                                                    ],
                                                                                                                    'children' => [
                                                                                                                        [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 2014718133,
                                                                                                                            'properties' => [
                                                                                                                                'name' => [
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
                                                                                                                            'hash' => 184253543,
                                                                                                                            'properties' => [
                                                                                                                                'payload' => [
                                                                                                                                    'type' => PlainScalarNode::class,
                                                                                                                                    'hash' => 2951607223,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => PlainScalarNode::class,
                                                                                                                                    'hash' => 2951607223,
                                                                                                                                    'properties' => [
                                                                                                                                        'token' => [
                                                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                                                            'text' => 'v',
                                                                                                                                        ],
                                                                                                                                    ],
                                                                                                                                    'children' => [],
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
