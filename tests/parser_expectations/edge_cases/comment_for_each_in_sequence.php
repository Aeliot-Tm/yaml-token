<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
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
                    'type' => KeyValueCoupleNode::class,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'sequence with comments',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                            'children' => [],
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'properties' => [
                                'blockSequence' => [
                                    'type' => BlockSequenceNode::class,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => SequenceEntryNode::class,
                                                'properties' => [
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [
                                                            'scalar' => [
                                                                'type' => ScalarNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::PLAIN_SCALAR,
                                                                        'text' => 'a',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                                'children' => [
                                                    [
                                                        'type' => IndentationNode::class,
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
                                                        'properties' => [
                                                            'token' => [
                                                                'type' => TokenType::WHITESPACE,
                                                                'text' => ' ',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'type' => SequenceEntryNode::class,
                                                'properties' => [
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [
                                                            'scalar' => [
                                                                'type' => ScalarNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::PLAIN_SCALAR,
                                                                        'text' => 'b',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                                'children' => [
                                                    [
                                                        'type' => IndentationNode::class,
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
                                                        'properties' => [
                                                            'token' => [
                                                                'type' => TokenType::WHITESPACE,
                                                                'text' => ' ',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                            ],
                                            [
                                                'type' => SequenceEntryNode::class,
                                                'properties' => [
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [
                                                            'scalar' => [
                                                                'type' => ScalarNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::PLAIN_SCALAR,
                                                                        'text' => 'c',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                                'children' => [
                                                    [
                                                        'type' => IndentationNode::class,
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
                                                        'properties' => [
                                                            'token' => [
                                                                'type' => TokenType::WHITESPACE,
                                                                'text' => ' ',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => NewLineNode::class,
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
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::INDENTATION,
                                                    'text' => '  ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => CommentNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::COMMENT,
                                                    'text' => '# Comment for A',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => NewLineNode::class,
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
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::INDENTATION,
                                                    'text' => '  ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => CommentNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::COMMENT,
                                                    'text' => '# Comment for B',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => NewLineNode::class,
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
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::INDENTATION,
                                                    'text' => '  ',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => CommentNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::COMMENT,
                                                    'text' => '# Comment for C',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => NewLineNode::class,
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
                            'children' => [],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::VALUE_INDICATOR,
                                    'text' => ':',
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
