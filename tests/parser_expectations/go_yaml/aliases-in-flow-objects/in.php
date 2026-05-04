<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
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
                    'type' => FlowMappingNode::class,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'properties' => [
                                    'key' => [
                                        'type' => KeyNode::class,
                                        'properties' => [
                                            'nodeProperties' => [
                                                'type' => NodePropertiesNode::class,
                                                'properties' => [
                                                    'anchor' => [
                                                        'type' => AnchorNode::class,
                                                        'properties' => [
                                                            'name' => 'a',
                                                            'token' => [
                                                                'type' => TokenType::ANCHOR,
                                                                'text' => '&a',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                            'name' => [
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
                                                                            'text' => 'a',
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
                                                                'nodeProperties' => [
                                                                    'type' => NodePropertiesNode::class,
                                                                    'properties' => [
                                                                        'anchor' => [
                                                                            'type' => AnchorNode::class,
                                                                            'properties' => [
                                                                                'name' => 'b',
                                                                                'token' => [
                                                                                    'type' => TokenType::ANCHOR,
                                                                                    'text' => '&b',
                                                                                ],
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
                                                                            'text' => 'b',
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
                                                                'type' => TokenType::FLOW_SEQUENCE_END,
                                                                'text' => ']',
                                                            ],
                                                        ],
                                                        'children' => [],
                                                    ],
                                                ],
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
                                    'mappingValueIndicator' => [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::VALUE_INDICATOR,
                                                'text' => ':',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'alias' => [
                                                'type' => AliasNode::class,
                                                'properties' => [
                                                    'name' => 'b',
                                                    'anchorName' => 'b',
                                                    'token' => [
                                                        'type' => TokenType::ALIAS,
                                                        'text' => '*b',
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
                                                'type' => AliasNode::class,
                                                'properties' => [
                                                    'name' => 'a',
                                                    'anchorName' => 'a',
                                                    'token' => [
                                                        'type' => TokenType::ALIAS,
                                                        'text' => '*a',
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                    'mappingValueIndicator' => [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::VALUE_INDICATOR,
                                                'text' => ':',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'flowSequence' => [
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
                                                                            'text' => 'c',
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
                                                                'alias' => [
                                                                    'type' => AliasNode::class,
                                                                    'properties' => [
                                                                        'name' => 'b',
                                                                        'anchorName' => 'b',
                                                                        'token' => [
                                                                            'type' => TokenType::ALIAS,
                                                                            'text' => '*b',
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
                                                                            'text' => 'd',
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
                                                ],
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
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_START,
                                    'text' => '{',
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
                                    'type' => TokenType::FLOW_MAPPING_END,
                                    'text' => '}',
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
        ],
    ],
];
