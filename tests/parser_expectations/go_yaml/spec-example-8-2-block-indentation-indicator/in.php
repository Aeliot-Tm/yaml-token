<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FoldedBlockScalarNode;
use Aeliot\YamlToken\Node\IndentationIndicatorNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 800523093,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1032854134,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 159560921,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4184665516,
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
                            'hash' => 4184665516,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3629338310,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3629338310,
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
                                            'hash' => 819672301,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                    'text' => " detected\n",
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 4131735505,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2205342112,
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
                            'hash' => 2205342112,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 1629341911,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 1629341911,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => BlockScalarOptionsNode::class,
                                            'hash' => 556040850,
                                            'properties' => [
                                                'typeIndicator' => [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 3228385119,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 3228385119,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                                            'text' => '>',
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
                                            'type' => FoldedBlockScalarNode::class,
                                            'hash' => 3873476435,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                                    'text' => " \n  \n  # detected\n",
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 3088337772,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2903950323,
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
                            'hash' => 2903950323,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3572982356,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3572982356,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => BlockScalarOptionsNode::class,
                                            'hash' => 1732430262,
                                            'properties' => [
                                                'typeIndicator' => [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 1768284065,
                                                ],
                                                'indentationIndicator' => [
                                                    'type' => IndentationIndicatorNode::class,
                                                    'hash' => 3127960550,
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
                                                    'hash' => 3127960550,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENTATION_INDICATOR,
                                                            'text' => '1',
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
                                            'hash' => 3935849828,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                    'text' => "  explicit\n",
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 593626267,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 66407936,
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
                            'hash' => 66407936,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3623620970,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3623620970,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => BlockScalarOptionsNode::class,
                                            'hash' => 556040850,
                                            'properties' => [
                                                'typeIndicator' => [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 3228385119,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 3228385119,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                                            'text' => '>',
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
                                            'type' => FoldedBlockScalarNode::class,
                                            'hash' => 2646047998,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                                    'text' => " \t\n detected\n",
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
