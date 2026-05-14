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
    'hash' => 450014241,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2954270452,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 432514559,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1426273043,
                        ],
                        'blockSequence' => [
                            'type' => BlockSequenceNode::class,
                            'hash' => 705253511,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1426273043,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'hash' => 3478994343,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagNode::class,
                                    'hash' => 3478994343,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!!pairs',
                                        ],
                                    ],
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
                        [
                            'type' => BlockSequenceNode::class,
                            'hash' => 705253511,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'hash' => 1777611546,
                                    ],
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'hash' => 77276306,
                                    ],
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'hash' => 453942975,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => SequenceEntryNode::class,
                                    'hash' => 1777611546,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 3115374668,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 990219541,
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
                                            'hash' => 3115374668,
                                            'properties' => [
                                                'blockMapping' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 3057435282,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 3057435282,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 4184471181,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 4184471181,
                                                            'properties' => [
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2430423755,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 406523904,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2430423755,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3298035729,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3298035729,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'meeting',
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
                                                                    'hash' => 406523904,
                                                                    'properties' => [
                                                                        'scalar' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2630707606,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2630707606,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'with team',
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
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => SequenceEntryNode::class,
                                    'hash' => 77276306,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2972494232,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 990219541,
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
                                            'hash' => 2972494232,
                                            'properties' => [
                                                'blockMapping' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 3926420056,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 3926420056,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 2200714340,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 2200714340,
                                                            'properties' => [
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2430423755,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 908260258,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2430423755,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3298035729,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3298035729,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'meeting',
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
                                                                    'hash' => 908260258,
                                                                    'properties' => [
                                                                        'scalar' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 734691689,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 734691689,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'with boss',
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
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => SequenceEntryNode::class,
                                    'hash' => 453942975,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2210392848,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 990219541,
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
                                            'hash' => 2210392848,
                                            'properties' => [
                                                'blockMapping' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 2104015948,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 2104015948,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 1859310455,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 1859310455,
                                                            'properties' => [
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 1193640897,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1779941030,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 1193640897,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 4246498863,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 4246498863,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'lunch',
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
                                                                    'hash' => 1779941030,
                                                                    'properties' => [
                                                                        'scalar' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2126745386,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2126745386,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'with friend',
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
            ],
        ],
    ],
];
