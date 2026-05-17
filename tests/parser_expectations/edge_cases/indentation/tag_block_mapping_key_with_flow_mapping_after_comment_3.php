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
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1616870414,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3388141546,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 4075272308,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2568107997,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 637709337,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2568107997,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2919648891,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2919648891,
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
                            'type' => SyntaxTokenNode::class,
                            'hash' => 675194587,
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
                            'hash' => 637709337,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 944659714,
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
                                    'hash' => 944659714,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 357084968,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 357084968,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 443636159,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 822642692,
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
                                                    'hash' => 443636159,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 2612414966,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 2612414966,
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
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
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
                                                    'hash' => 822642692,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 3924392354,
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
                                                            'hash' => 3924392354,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 4098343911,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 4098343911,
                                                                    'properties' => [
                                                                        'indentation' => [
                                                                            'type' => IndentationNode::class,
                                                                            'hash' => 3551679428,
                                                                        ],
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 646346952,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 4097194835,
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
                                                                            'hash' => 646346952,
                                                                            'properties' => [
                                                                                'nodeProperties' => [
                                                                                    'type' => NodePropertiesNode::class,
                                                                                    'hash' => 131013440,
                                                                                ],
                                                                                'name' => [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 630245432,
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
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 630245432,
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
                                                                            'type' => SyntaxTokenNode::class,
                                                                            'hash' => 675194587,
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
                                                                            'hash' => 4097194835,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 1588812937,
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
                                                                                    'hash' => 2695069651,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::INDENTATION,
                                                                                            'text' => '        ',
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [],
                                                                                ],
                                                                                [
                                                                                    'type' => CommentNode::class,
                                                                                    'hash' => 3124014477,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::COMMENT,
                                                                                            'text' => '# comment 1',
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
                                                                                    'type' => IndentationNode::class,
                                                                                    'hash' => 2695069651,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::INDENTATION,
                                                                                            'text' => '        ',
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [],
                                                                                ],
                                                                                [
                                                                                    'type' => CommentNode::class,
                                                                                    'hash' => 425863972,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::COMMENT,
                                                                                            'text' => '# comment 2',
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
                                                                                    'type' => IndentationNode::class,
                                                                                    'hash' => 2695069651,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::INDENTATION,
                                                                                            'text' => '        ',
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [],
                                                                                ],
                                                                                [
                                                                                    'type' => CommentNode::class,
                                                                                    'hash' => 3464539004,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::COMMENT,
                                                                                            'text' => '# comment 3',
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
                                                                                    'hash' => 1588812937,
                                                                                    'properties' => [
                                                                                        'entries' => [
                                                                                            [
                                                                                                'type' => KeyValueCoupleNode::class,
                                                                                                'hash' => 3136465997,
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyValueCoupleNode::class,
                                                                                            'hash' => 3136465997,
                                                                                            'properties' => [
                                                                                                'indentation' => [
                                                                                                    'type' => IndentationNode::class,
                                                                                                    'hash' => 4110986796,
                                                                                                ],
                                                                                                'key' => [
                                                                                                    'type' => KeyNode::class,
                                                                                                    'hash' => 4094834478,
                                                                                                ],
                                                                                                'value' => [
                                                                                                    'type' => ValueNode::class,
                                                                                                    'hash' => 3912432594,
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
                                                                                                    'hash' => 4094834478,
                                                                                                    'properties' => [
                                                                                                        'name' => [
                                                                                                            'type' => ScalarNode::class,
                                                                                                            'hash' => 581416071,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => ScalarNode::class,
                                                                                                            'hash' => 581416071,
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
                                                                                                    'type' => SyntaxTokenNode::class,
                                                                                                    'hash' => 675194587,
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
                                                                                                    'hash' => 3912432594,
                                                                                                    'properties' => [
                                                                                                        'payload' => [
                                                                                                            'type' => FlowMappingNode::class,
                                                                                                            'hash' => 1345612565,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => FlowMappingNode::class,
                                                                                                            'hash' => 1345612565,
                                                                                                            'properties' => [
                                                                                                                'entries' => [
                                                                                                                    [
                                                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                                                        'hash' => 1782981016,
                                                                                                                    ],
                                                                                                                    [
                                                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                                                        'hash' => 1712500472,
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
                                                                                                                    'hash' => 1782981016,
                                                                                                                    'properties' => [
                                                                                                                        'key' => [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 874425984,
                                                                                                                        ],
                                                                                                                        'valueIndicator' => [
                                                                                                                            'type' => ValueIndicatorNode::class,
                                                                                                                            'hash' => 3779730559,
                                                                                                                        ],
                                                                                                                        'value' => [
                                                                                                                            'type' => ValueNode::class,
                                                                                                                            'hash' => 3941075354,
                                                                                                                        ],
                                                                                                                    ],
                                                                                                                    'children' => [
                                                                                                                        [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 874425984,
                                                                                                                            'properties' => [
                                                                                                                                'name' => [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 1583972959,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 1583972959,
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
                                                                                                                            'hash' => 3941075354,
                                                                                                                            'properties' => [
                                                                                                                                'payload' => [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 118829598,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 118829598,
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
                                                                                                                    'hash' => 1712500472,
                                                                                                                    'properties' => [
                                                                                                                        'key' => [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 3626635258,
                                                                                                                        ],
                                                                                                                        'valueIndicator' => [
                                                                                                                            'type' => ValueIndicatorNode::class,
                                                                                                                            'hash' => 3779730559,
                                                                                                                        ],
                                                                                                                        'value' => [
                                                                                                                            'type' => ValueNode::class,
                                                                                                                            'hash' => 3941075354,
                                                                                                                        ],
                                                                                                                    ],
                                                                                                                    'children' => [
                                                                                                                        [
                                                                                                                            'type' => KeyNode::class,
                                                                                                                            'hash' => 3626635258,
                                                                                                                            'properties' => [
                                                                                                                                'name' => [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 4248765686,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 4248765686,
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
                                                                                                                            'hash' => 3941075354,
                                                                                                                            'properties' => [
                                                                                                                                'payload' => [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 118829598,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 118829598,
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
