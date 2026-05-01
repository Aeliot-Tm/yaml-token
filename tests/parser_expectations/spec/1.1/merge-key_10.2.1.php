<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\MergeInstructionNode;
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
                                            'text' => 'defaults',
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
                                'anchor' => [
                                    'type' => AnchorNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::ANCHOR,
                                            'text' => '&defaults',
                                        ],
                                        'name' => 'defaults',
                                        'declarationKeyText' => 'defaults',
                                    ],
                                    'children' => [],
                                ],
                                'blockMapping' => [
                                    'type' => BlockMappingNode::class,
                                    'properties' => [],
                                    'children' => [
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
                                                                    'text' => 'color',
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
                                                                    'text' => 'blue',
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
                                                    'text' => '
',
                                                ],
                                            ],
                                            'children' => [],
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
                                                                    'text' => 'size',
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
                                                                    'text' => 'large',
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
                                                    'text' => '
',
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
                                            'text' => 'custom',
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
                                    'properties' => [],
                                    'children' => [
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
                                            'type' => MergeInstructionNode::class,
                                            'properties' => [],
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
                                                            'type' => TokenType::MERGE_INDICATOR,
                                                            'text' => '<<',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
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
                                                [
                                                    'type' => ValueNode::class,
                                                    'properties' => [
                                                        'alias' => [
                                                            'type' => AliasNode::class,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::ALIAS,
                                                                    'text' => '*defaults',
                                                                ],
                                                                'name' => 'defaults',
                                                                'anchorName' => 'defaults',
                                                            ],
                                                            'children' => [],
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
                                                                    'text' => 'name',
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
                                                                    'text' => 'Custom',
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
                                                    'text' => '
',
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
