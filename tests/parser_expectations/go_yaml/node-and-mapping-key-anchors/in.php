<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
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
                    'type' => DocumentStartNode::class,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DOCUMENT_START,
                            'text' => '---',
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
                                            'text' => 'top1',
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
                                                                        'text' => 'key1',
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
                                                                                'text' => '&k1',
                                                                            ],
                                                                            'name' => 'k1',
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
                                                                        'text' => 'one',
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
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&node1',
                                                ],
                                                'name' => 'node1',
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
                                            'text' => 'top2',
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
                                                                        'text' => 'key2',
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
                                                                        'text' => 'two',
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
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&node2',
                                                ],
                                                'name' => 'node2',
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
                                [
                                    'type' => CommentNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::COMMENT,
                                            'text' => '# comment',
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
                                            'text' => 'top3',
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
                                                                        'text' => 'key3',
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
                                                                                'text' => '&k3',
                                                                            ],
                                                                            'name' => 'k3',
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
                                                                        'text' => 'three',
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
                        'key' => [
                            'type' => KeyNode::class,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'top4',
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
                                                                        'text' => 'key4',
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
                                                                                'text' => '&k4',
                                                                            ],
                                                                            'name' => 'k4',
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
                                                                        'text' => 'four',
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
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&node4',
                                                ],
                                                'name' => 'node4',
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
                            ],
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
                                            'text' => 'top5',
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
                                                                        'text' => 'key5',
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
                                                                        'text' => 'five',
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
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&node5',
                                                ],
                                                'name' => 'node5',
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
                            ],
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
                                            'text' => 'top6',
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
                                                    'text' => '&val6',
                                                ],
                                                'name' => 'val6',
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'six',
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
                            ],
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
                                            'text' => 'top7',
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
                                                                        'text' => 'seven',
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
                                                                                'text' => '&val7',
                                                                            ],
                                                                            'name' => 'val7',
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
