<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowSequenceNode::class,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'properties' => [
                                    'scalar' => [
                                        'type' => ScalarNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::PLAIN_SCALAR,
                                                'text' => 'one',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [],
                            ],
                            [
                                'type' => ValueNode::class,
                                'properties' => [
                                    'scalar' => [
                                        'type' => ScalarNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::PLAIN_SCALAR,
                                                'text' => 'two',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [],
                            ],
                            [
                                'type' => ValueNode::class,
                                'properties' => [
                                    'scalar' => [
                                        'type' => ScalarNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::PLAIN_SCALAR,
                                                'text' => 'three',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [],
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                    'text' => '[',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
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
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
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
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                    'text' => ']',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => NewLineNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::NEWLINE,
                                    'text' => '
',
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
