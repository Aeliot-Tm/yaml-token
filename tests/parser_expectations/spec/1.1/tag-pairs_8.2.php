<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
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
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'properties' => [
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
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'properties' => [
                                                                                'name' => [
                                                                                    'type' => ScalarNode::class,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'meeting',
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
                                                                                            'text' => 'with team',
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
                                                        'properties' => [
                                                            'entries' => [
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
                                                                                            'text' => 'meeting',
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
                                                                                            'text' => 'with boss',
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
                                                        'properties' => [
                                                            'entries' => [
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
                                                                                            'text' => 'lunch',
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
                                                                                            'text' => 'with friend',
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
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!!pairs',
                                        ],
                                    ],
                                    'children' => [],
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
