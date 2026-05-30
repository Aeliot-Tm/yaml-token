<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FoldedBlockScalarNode;
use Aeliot\YamlToken\Node\IndentationIndicatorNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1827893280,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3555281985,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3803765414,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 101218080,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 167488881,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 101218080,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1131788622,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1131788622,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'literal',
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
                            'hash' => 167488881,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 1174335126,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 1174335126,
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
                                            'hash' => 952119948,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                    'text' => "    Content indented relative to indicator\n",
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
                    'hash' => 2231574608,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2515320430,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1861791265,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2515320430,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1165992502,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1165992502,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'folded',
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
                            'hash' => 1861791265,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3082114691,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3082114691,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => BlockScalarOptionsNode::class,
                                            'hash' => 2278834283,
                                            'properties' => [
                                                'typeIndicator' => [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 3228385119,
                                                ],
                                                'indentationIndicator' => [
                                                    'type' => IndentationIndicatorNode::class,
                                                    'hash' => 3127960550,
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
                                            'type' => FoldedBlockScalarNode::class,
                                            'hash' => 220131641,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                                    'text' => " folded\n",
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
                    'hash' => 3881466335,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3223405986,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 810898168,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3223405986,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 647525000,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 647525000,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'combined',
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
                            'hash' => 810898168,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3600758530,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 3600758530,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => BlockScalarOptionsNode::class,
                                            'hash' => 3491708682,
                                            'properties' => [
                                                'typeIndicator' => [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 3228385119,
                                                ],
                                                'chompingIndicator' => [
                                                    'type' => BlockScalarChompingIndicatorNode::class,
                                                    'hash' => 2238875574,
                                                ],
                                                'indentationIndicator' => [
                                                    'type' => IndentationIndicatorNode::class,
                                                    'hash' => 3127960550,
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
                                                [
                                                    'type' => BlockScalarChompingIndicatorNode::class,
                                                    'hash' => 2238875574,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
                                                            'text' => '-',
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
                                            'hash' => 1115429887,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                                    'text' => ' strip',
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
