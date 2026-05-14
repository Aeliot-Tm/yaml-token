<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 150493617,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3330615343,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3286020628,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2036196603,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3692501641,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2036196603,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1798278468,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1798278468,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'year',
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
                            'hash' => 3692501641,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2475638295,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1972954758,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2475638295,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 1497988158,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 1497988158,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!example.com,2000/timesheet',
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
                                    'hash' => 1972954758,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'valueA',
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
                    'hash' => 141117880,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3890303469,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1637165278,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3890303469,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1493773452,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1493773452,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'month',
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
                            'hash' => 1637165278,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2071950946,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3603849263,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2071950946,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 3110683299,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 3110683299,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!example.com,2000-01/timesheet',
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
                                    'hash' => 3603849263,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'valueB',
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
                    'hash' => 887346493,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 989663309,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1625529012,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 989663309,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3420243182,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3420243182,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'day',
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
                            'hash' => 1625529012,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3978997911,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 19718263,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3978997911,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagNode::class,
                                            'hash' => 906580565,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagNode::class,
                                            'hash' => 906580565,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG,
                                                    'text' => '!example.com,2000-01-01/timesheet',
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
                                    'hash' => 19718263,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'valueC',
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
];
