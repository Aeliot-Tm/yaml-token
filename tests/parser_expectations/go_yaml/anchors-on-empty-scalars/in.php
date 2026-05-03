<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
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
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&a',
                                                ],
                                                'name' => 'a',
                                                'declarationKeyText' => null,
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
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&a',
                                                                            ],
                                                                            'name' => 'a',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
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
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&b',
                                                                            ],
                                                                            'name' => 'b',
                                                                            'declarationKeyText' => 'b',
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
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&c',
                                                                            ],
                                                                            'name' => 'c',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
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
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&a',
                                                                            ],
                                                                            'name' => 'a',
                                                                            'declarationKeyText' => null,
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
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                                                            'explicitKeyIndicatorNode' => [
                                                                'type' => ExplicitKeyIndicatorNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                                        'text' => '?',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&d',
                                                                            ],
                                                                            'name' => 'd',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
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
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [],
                                                        'children' => [],
                                                    ],
                                                ],
                                                'children' => [],
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
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                                                            'explicitKeyIndicatorNode' => [
                                                                'type' => ExplicitKeyIndicatorNode::class,
                                                                'properties' => [
                                                                    'token' => [
                                                                        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                                        'text' => '?',
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&e',
                                                                            ],
                                                                            'name' => 'e',
                                                                            'declarationKeyText' => null,
                                                                        ],
                                                                        'children' => [],
                                                                    ],
                                                                ],
                                                                'children' => [],
                                                            ],
                                                        ],
                                                        'children' => [
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
                                                    'value' => [
                                                        'type' => ValueNode::class,
                                                        'properties' => [
                                                            'nodeProperties' => [
                                                                'type' => NodePropertiesNode::class,
                                                                'properties' => [
                                                                    'anchor' => [
                                                                        'type' => AnchorNode::class,
                                                                        'properties' => [
                                                                            'token' => [
                                                                                'type' => TokenType::ANCHOR,
                                                                                'text' => '&a',
                                                                            ],
                                                                            'name' => 'a',
                                                                            'declarationKeyText' => null,
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
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
