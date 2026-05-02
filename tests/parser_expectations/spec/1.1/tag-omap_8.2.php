<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagNode;
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
                    'type' => ValueNode::class,
                    'properties' => [
                        'blockSequence' => [
                            'type' => BlockSequenceNode::class,
                            'properties' => [],
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
                                    'type' => SequenceEntryNode::class,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'properties' => [
                                                'blockMapping' => [
                                                    'type' => BlockMappingNode::class,
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
                                                                                    'text' => 'Mark McGwire',
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
                                                                                    'text' => '65',
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
                                            'children' => [],
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
                                    'type' => SequenceEntryNode::class,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'properties' => [
                                                'blockMapping' => [
                                                    'type' => BlockMappingNode::class,
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
                                                                                    'text' => 'Sammy Sosa',
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
                                                                                    'text' => '63',
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
                                            'children' => [],
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
                                    'type' => SequenceEntryNode::class,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'properties' => [
                                                'blockMapping' => [
                                                    'type' => BlockMappingNode::class,
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
                                                                                    'text' => 'Ken Griffey',
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
                                                                                    'text' => '58',
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
                                            'children' => [],
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
                            ],
                        ],
                        'tag' => [
                            'type' => TagNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::TAG,
                                    'text' => '!!omap',
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
                    'children' => [],
                ],
            ],
        ],
    ],
];
