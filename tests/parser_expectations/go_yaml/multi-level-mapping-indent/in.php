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
                                            'text' => 'a',
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
                                'blockMapping' => [
                                    'type' => BlockMappingNode::class,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'properties' => [
                                                    'indentation' => [
                                                        'type' => IndentationNode::class,
                                                        'properties' => [
                                                            'token' => [
                                                                'type' => TokenType::INDENTATION,
                                                                'text' => '  ',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                    'key' => [
                                                        'type' => KeyNode::class,
                                                        'properties' => [
                                                            'name' => [
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
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [
                                                            'blockMapping' => [
                                                                'type' => BlockMappingNode::class,
                                                                'properties' => [
                                                                    'entries' => [
                                                                        [
                                                                            'type' => KeyValueCoupleNode::class,
                                                                            'properties' => [
                                                                                'indentation' => [
                                                                                    'type' => IndentationNode::class,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::INDENTATION,
                                                                                            'text' => '    ',
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [],
                                                                                ],
                                                                                'key' => [
                                                                                    'type' => KeyNode::class,
                                                                                    'properties' => [
                                                                                        'name' => [
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
                                                                                'value' => [
                                                                                    'type' => ValueNode::class,
                                                                                    'properties' => [
                                                                                        'scalar' => [
                                                                                            'type' => ScalarNode::class,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                    'text' => 'd',
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
                                                                                    'type' => SyntaxTokenNode::class,
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
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'properties' => [
                                                    'indentation' => [
                                                        'type' => IndentationNode::class,
                                                        'properties' => [
                                                            'token' => [
                                                                'type' => TokenType::INDENTATION,
                                                                'text' => '  ',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                    'key' => [
                                                        'type' => KeyNode::class,
                                                        'properties' => [
                                                            'name' => [
                                                                'type' => ScalarNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::PLAIN_SCALAR,
                                                                        'text' => 'e',
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
                                                            'blockMapping' => [
                                                                'type' => BlockMappingNode::class,
                                                                'properties' => [
                                                                    'entries' => [
                                                                        [
                                                                            'type' => KeyValueCoupleNode::class,
                                                                            'properties' => [
                                                                                'indentation' => [
                                                                                    'type' => IndentationNode::class,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::INDENTATION,
                                                                                            'text' => '    ',
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [],
                                                                                ],
                                                                                'key' => [
                                                                                    'type' => KeyNode::class,
                                                                                    'properties' => [
                                                                                        'name' => [
                                                                                            'type' => ScalarNode::class,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                    'text' => 'f',
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
                                                                                        'scalar' => [
                                                                                            'type' => ScalarNode::class,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                    'text' => 'g',
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
                                                                                    'type' => SyntaxTokenNode::class,
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
                                            'text' => 'h',
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
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'i',
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
                            'type' => SyntaxTokenNode::class,
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
];
