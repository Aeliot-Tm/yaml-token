<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3207488823,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3362290867,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 634514490,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 135986500,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1522927857,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 135986500,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1034554003,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1034554003,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'literal',
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
                            'hash' => 1522927857,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3285778361,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarIndicatorNode::class,
                                    'hash' => 1768284065,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                            'text' => '|',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarIndentationIndicatorNode::class,
                                    'hash' => 2586049209,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
                                            'text' => '2',
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
                                    'type' => ScalarNode::class,
                                    'hash' => 3285778361,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'Content indented relative to indicator',
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
                    'hash' => 2731960043,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3086796722,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2852119390,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3086796722,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 733004347,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 733004347,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'folded',
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
                            'hash' => 2852119390,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 733004347,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarIndicatorNode::class,
                                    'hash' => 3228385119,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                            'text' => '>',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarIndentationIndicatorNode::class,
                                    'hash' => 964000784,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
                                            'text' => '1',
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
                                    'hash' => 2218577147,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::INDENTATION,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 733004347,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'folded',
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
                    'hash' => 4272469200,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3911010953,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2226486142,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3911010953,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3733193554,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3733193554,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'combined',
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
                            'hash' => 2226486142,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2891959995,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarIndicatorNode::class,
                                    'hash' => 3228385119,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                            'text' => '>',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarIndentationIndicatorNode::class,
                                    'hash' => 964000784,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
                                            'text' => '1',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarChompingIndicatorNode::class,
                                    'hash' => 2238875574,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
                                            'text' => '-',
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
                                    'hash' => 2218577147,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::INDENTATION,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2891959995,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'strip',
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
