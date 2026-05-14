<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
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
    'hash' => 3585456817,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1083952855,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 639821206,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2568107997,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3203258929,
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
                            'hash' => 3203258929,
                            'properties' => [
                                'flowSequence' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 2311710291,
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
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 2311710291,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 3271794012,
                                            ],
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 792149030,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 3296102772,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                                    'text' => '[',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => ValueNode::class,
                                            'hash' => 3271794012,
                                            'properties' => [
                                                'scalar' => [
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
                                            'type' => ValueNode::class,
                                            'hash' => 792149030,
                                            'properties' => [
                                                'scalar' => [
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
                                            'hash' => 2678523598,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                                    'text' => ']',
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
