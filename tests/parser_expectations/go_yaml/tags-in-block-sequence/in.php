<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3256349826,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 590662927,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 3120961955,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1373724271,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => IndentNode::class,
                            'hash' => 2725803330,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::INDENT,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 1373724271,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3273011123,
                                ],
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4136715254,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3273011123,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 907070353,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 907070353,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG_PROPERTY,
                                                    'text' => '!!str',
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
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4136715254,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'a',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 4218379802,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1154444269,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => IndentNode::class,
                            'hash' => 2725803330,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::INDENT,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 1154444269,
                            'properties' => [
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1439155551,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1439155551,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'b',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 1916399072,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 102148832,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => IndentNode::class,
                            'hash' => 2725803330,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::INDENT,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 102148832,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 1456294572,
                                ],
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4279995708,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 1456294572,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 2530070910,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 2530070910,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG_PROPERTY,
                                                    'text' => '!!int',
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
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4279995708,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '42',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 2508740682,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 999563081,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => IndentNode::class,
                            'hash' => 2725803330,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::INDENT,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
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
                            'hash' => 999563081,
                            'properties' => [
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3357265484,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3357265484,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'd',
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
