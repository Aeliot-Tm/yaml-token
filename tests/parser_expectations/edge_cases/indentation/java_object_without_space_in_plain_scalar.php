<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
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
    'hash' => 4095442730,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4255894842,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 894648233,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3062719336,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1323872218,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3062719336,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 932022495,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 932022495,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'level1A',
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
                            'hash' => 1323872218,
                            'properties' => [
                                'blockMapping' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 4242498476,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 4242498476,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3313807096,
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
                                            'hash' => 3313807096,
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
                                                    'hash' => 4001166339,
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
                                                    'hash' => 4001166339,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 2203889430,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 2203889430,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'manning symbols in plain scalar {level1:{level2:value}}',
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
                    'hash' => 3339210821,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1477487568,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1087047134,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1477487568,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2497384054,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2497384054,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'level1B',
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
                            'hash' => 1087047134,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1394411103,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1394411103,
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
            ],
        ],
    ],
];
