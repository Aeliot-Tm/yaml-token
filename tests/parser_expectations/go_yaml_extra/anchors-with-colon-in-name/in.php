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
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 828445376,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 916397254,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 504997181,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1877580106,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 964197947,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1877580106,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 231670350,
                                ],
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3374620825,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 231670350,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'hash' => 60958977,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorNode::class,
                                            'hash' => 60958977,
                                            'properties' => [
                                                'name' => 'a:',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&a:',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => WhitespaceNode::class,
                                    'hash' => 1067539092,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::WHITESPACE,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3374620825,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'key',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 675194587,
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
                            'hash' => 1067539092,
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
                            'hash' => 964197947,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 78035332,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1394411103,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 78035332,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'hash' => 406257572,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorNode::class,
                                            'hash' => 406257572,
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
                                ],
                                [
                                    'type' => WhitespaceNode::class,
                                    'hash' => 1067539092,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::WHITESPACE,
                                            'text' => ' ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1394411103,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'value',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => NewLineNode::class,
                    'hash' => 763369711,
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
                    'hash' => 61886211,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2394387173,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2859456531,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2394387173,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3095314157,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3095314157,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'foo',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 675194587,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::VALUE_INDICATOR,
                                    'text' => ':',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => ValueNode::class,
                            'hash' => 2859456531,
                            'properties' => [
                                'blockMapping' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 1236861348,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 1236861348,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1925241013,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => NewLineNode::class,
                                            'hash' => 763369711,
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
                                            'hash' => 1925241013,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 1687337580,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 4172322135,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENTATION,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 1687337580,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => AliasNode::class,
                                                            'hash' => 1686145209,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => AliasNode::class,
                                                            'hash' => 1686145209,
                                                            'properties' => [
                                                                'name' => 'a:',
                                                                'anchorName' => 'a:',
                                                                'token' => [
                                                                    'type' => TokenType::ALIAS,
                                                                    'text' => '*a:',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => ValueNode::class,
                                                    'hash' => 4172322135,
                                                    'properties' => [],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        [
                                            'type' => NewLineNode::class,
                                            'hash' => 763369711,
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
                ],
            ],
        ],
    ],
];
