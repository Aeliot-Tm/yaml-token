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
    'hash' => 1240166331,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 312841797,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3469618640,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2568107997,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3846243373,
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
                            'hash' => 3846243373,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 2150617672,
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
                                    'hash' => 2150617672,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 4108402979,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 4108402979,
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
                                                    'hash' => 2391144869,
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
                                                    'hash' => 2391144869,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 2251776358,
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
                                                            'hash' => 2251776358,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 3948663257,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 3948663257,
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
                                                                            'hash' => 1135117280,
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
                                                                            'hash' => 1135117280,
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
