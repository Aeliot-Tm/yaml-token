<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\IndentNode;
use Aeliot\YamlToken\Node\IndentationIndicatorNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2038703396,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2117882207,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 2746259485,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2102705856,
                        ],
                    ],
                    'children' => [
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
                            'hash' => 2102705856,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 3259801016,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 3259801016,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1950842685,
                                            ],
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3258707448,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 1950842685,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2831104495,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 1497325974,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2831104495,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3485087802,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3485087802,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'aaa',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
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
                                                    'hash' => 1497325974,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockScalarEntryNode::class,
                                                            'hash' => 4241164302,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockScalarEntryNode::class,
                                                            'hash' => 4241164302,
                                                            'properties' => [],
                                                            'children' => [
                                                                [
                                                                    'type' => BlockScalarOptionsNode::class,
                                                                    'hash' => 1559085307,
                                                                    'properties' => [
                                                                        'typeIndicator' => [
                                                                            'type' => BlockScalarIndicatorNode::class,
                                                                            'hash' => 1768284065,
                                                                        ],
                                                                        'indentationIndicator' => [
                                                                            'type' => IndentationIndicatorNode::class,
                                                                            'hash' => 421946703,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => BlockScalarIndicatorNode::class,
                                                                            'hash' => 1768284065,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                                                                    'text' => '|',
                                                                                ],
                                                                            ],
                                                                            'children' => [],
                                                                        ],
                                                                        [
                                                                            'type' => IndentationIndicatorNode::class,
                                                                            'hash' => 421946703,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::INDENTATION_INDICATOR,
                                                                                    'text' => '2',
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
                                                                    'type' => LiteralBlockScalarNode::class,
                                                                    'hash' => 2108195102,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                                            'text' => "    xxx\n",
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
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 3258707448,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2336126823,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 765797328,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2336126823,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3093000634,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3093000634,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'bbb',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
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
                                                    'hash' => 765797328,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockScalarEntryNode::class,
                                                            'hash' => 2018994052,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockScalarEntryNode::class,
                                                            'hash' => 2018994052,
                                                            'properties' => [],
                                                            'children' => [
                                                                [
                                                                    'type' => BlockScalarOptionsNode::class,
                                                                    'hash' => 3707031435,
                                                                    'properties' => [
                                                                        'typeIndicator' => [
                                                                            'type' => BlockScalarIndicatorNode::class,
                                                                            'hash' => 1768284065,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => BlockScalarIndicatorNode::class,
                                                                            'hash' => 1768284065,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                                                                    'text' => '|',
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
                                                                    'type' => LiteralBlockScalarNode::class,
                                                                    'hash' => 2108195102,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                                            'text' => "    xxx\n",
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
        ],
    ],
];
