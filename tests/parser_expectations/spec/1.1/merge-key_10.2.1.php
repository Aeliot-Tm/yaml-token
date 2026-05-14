<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 4007742398,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3942951914,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2409939830,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3941355737,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3066308031,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3941355737,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 852541227,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 852541227,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'defaults',
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
                            'hash' => 3066308031,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2417927891,
                                ],
                                'blockMapping' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 2133006693,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2417927891,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'hash' => 4294061073,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorNode::class,
                                            'hash' => 4294061073,
                                            'properties' => [
                                                'name' => 'defaults',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&defaults',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 2133006693,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 2964215952,
                                            ],
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1568365528,
                                            ],
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
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 2964215952,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 4151421375,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2729608846,
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
                                                    'hash' => 4151421375,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3965521038,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3965521038,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'color',
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
                                                    'hash' => 2729608846,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 261895824,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 261895824,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'blue',
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
                                            'hash' => 1568365528,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2146018458,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2695470223,
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
                                                    'hash' => 2146018458,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1090514709,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1090514709,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'size',
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
                                                    'hash' => 2695470223,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 224645929,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 224645929,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'large',
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
                        ],
                    ],
                ],
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3275103301,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2255011990,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2459422688,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2255011990,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2551272142,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2551272142,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'custom',
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
                            'hash' => 2459422688,
                            'properties' => [
                                'blockMapping' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 3543724072,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 3543724072,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 4259725143,
                                            ],
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
                                            'type' => MergeInstructionNode::class,
                                            'hash' => 4050370841,
                                            'properties' => [],
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
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 3666465458,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::MERGE_INDICATOR,
                                                            'text' => '<<',
                                                        ],
                                                    ],
                                                    'children' => [],
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
                                                    'hash' => 1566575856,
                                                    'properties' => [
                                                        'alias' => [
                                                            'type' => AliasNode::class,
                                                            'hash' => 984651932,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => AliasNode::class,
                                                            'hash' => 984651932,
                                                            'properties' => [
                                                                'name' => 'defaults',
                                                                'anchorName' => 'defaults',
                                                                'token' => [
                                                                    'type' => TokenType::ALIAS,
                                                                    'text' => '*defaults',
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
                                            'hash' => 4259725143,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3313254637,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 3420067959,
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
                                                    'hash' => 3313254637,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1068658772,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1068658772,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'name',
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
                                                    'hash' => 3420067959,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1724361908,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 1724361908,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'Custom',
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
                        ],
                    ],
                ],
            ],
        ],
    ],
];
