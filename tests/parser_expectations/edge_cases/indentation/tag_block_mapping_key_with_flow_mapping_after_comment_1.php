<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1660578701,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1039688391,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 534990637,
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
                            'hash' => 4018604734,
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
                            'hash' => 4018604734,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 3210924750,
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
                                    'hash' => 3210924750,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 2214085287,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 2214085287,
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
                                                    'hash' => 3111775550,
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
                                                    'hash' => 3111775550,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 1528718977,
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
                                                            'hash' => 1528718977,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 3909811015,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 3909811015,
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
                                                                            'hash' => 426716613,
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
                                                                            'hash' => 426716613,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 2205960074,
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
                                                                                    'hash' => 2205960074,
                                                                                    'properties' => [
                                                                                        'entries' => [
                                                                                            [
                                                                                                'type' => KeyValueCoupleNode::class,
                                                                                                'hash' => 448092394,
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyValueCoupleNode::class,
                                                                                            'hash' => 448092394,
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
                                                                                                    'hash' => 978910718,
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
                                                                                                    'hash' => 978910718,
                                                                                                    'properties' => [
                                                                                                        'payload' => [
                                                                                                            'type' => FlowMappingNode::class,
                                                                                                            'hash' => 1635316207,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => FlowMappingNode::class,
                                                                                                            'hash' => 1635316207,
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
                                                                                                                    'type' => SyntaxTokenNode::class,
                                                                                                                    'hash' => 3965909453,
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
