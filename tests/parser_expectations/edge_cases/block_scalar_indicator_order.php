<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
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
                                            'text' => 'explicit indent and chomp',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarIndicatorNode::class,
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
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
                                            'text' => '2',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarChompingIndicatorNode::class,
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
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::NEWLINE,
                                            'text' => '
',
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
                            ],
                        ],
                    ],
                    'children' => [
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
                                            'text' => 'chomp and explicit indent',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarIndicatorNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                            'text' => '|',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarChompingIndicatorNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
                                            'text' => '-',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => BlockScalarIndentationIndicatorNode::class,
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
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::NEWLINE,
                                            'text' => '
',
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
                            ],
                        ],
                    ],
                    'children' => [
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
];
