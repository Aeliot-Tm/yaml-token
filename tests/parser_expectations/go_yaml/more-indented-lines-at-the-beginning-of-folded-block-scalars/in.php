<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 148701136,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1075118580,
            'properties' => [],
            'children' => [
                [
                    'type' => DocumentStartNode::class,
                    'hash' => 2270658446,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DOCUMENT_START,
                            'text' => '---',
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
                    'hash' => 937037901,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 874425984,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 445961233,
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
                            'hash' => 445961233,
                            'properties' => [
                                'multilinePlainScalar' => [
                                    'type' => MultilinePlainScalarNode::class,
                                    'hash' => 1454013204,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3848523395,
                                        ],
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 1477621501,
                                        ],
                                    ],
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
                                    'hash' => 3446037835,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::INDENTATION,
                                            'text' => '   ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3848523395,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'more indented',
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
                                    'type' => ScalarNode::class,
                                    'hash' => 1477621501,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'regular',
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
                    'hash' => 1060260450,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3626635258,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 70229305,
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
                            'hash' => 70229305,
                            'properties' => [
                                'multilinePlainScalar' => [
                                    'type' => MultilinePlainScalarNode::class,
                                    'hash' => 1454013204,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3848523395,
                                        ],
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 1477621501,
                                        ],
                                    ],
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
                                    'hash' => 3446037835,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::INDENTATION,
                                            'text' => '   ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3848523395,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'more indented',
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
                                    'type' => ScalarNode::class,
                                    'hash' => 1477621501,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'regular',
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
