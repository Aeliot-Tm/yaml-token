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
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 212746413,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4129126292,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1171663449,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2568107997,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2408312507,
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
                            'hash' => 2408312507,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 2760338980,
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
                                    'hash' => 2760338980,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 493458471,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 493458471,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3003511219,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 94999476,
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
                                                    'hash' => 3003511219,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1472050655,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1472050655,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'level2',
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
                                                    'hash' => 94999476,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => FlowMappingNode::class,
                                                            'hash' => 2290912161,
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
                                                            'type' => FlowMappingNode::class,
                                                            'hash' => 2290912161,
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
