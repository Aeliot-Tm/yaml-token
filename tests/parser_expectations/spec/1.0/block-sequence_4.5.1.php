<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3220263450,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3662828865,
            'properties' => [],
            'children' => [
                [
                    'type' => SequenceEntryNode::class,
                    'hash' => 245835379,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3669709017,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 990219541,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                            'hash' => 3669709017,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 438572087,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 438572087,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'one',
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
                    'type' => SequenceEntryNode::class,
                    'hash' => 435813025,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 268489493,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 990219541,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                            'hash' => 268489493,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1782829291,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1782829291,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'two',
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
                    'type' => SequenceEntryNode::class,
                    'hash' => 94598226,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4102506316,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 990219541,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                            'hash' => 4102506316,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1745691151,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1745691151,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'three',
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
