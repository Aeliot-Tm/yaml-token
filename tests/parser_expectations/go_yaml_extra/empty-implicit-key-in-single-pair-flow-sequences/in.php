<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 3135255158,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4034001581,
            'properties' => [],
            'children' => [
                [
                    'type' => SequenceEntryNode::class,
                    'hash' => 2198627846,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2464648563,
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
                            'hash' => 2464648563,
                            'properties' => [
                                'flowSequence' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 4047240367,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 4047240367,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 129675021,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 3296102772,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                                    'text' => '[',
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
                                            'hash' => 129675021,
                                            'properties' => [
                                                'keyValueCouple' => [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 2644754176,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 2644754176,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 223405430,
                                                        ],
                                                        'mappingValueIndicator' => [
                                                            'type' => SyntaxTokenNode::class,
                                                            'hash' => 675194587,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 1903862432,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 223405430,
                                                            'properties' => [],
                                                            'children' => [],
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
                                                            'hash' => 1903862432,
                                                            'properties' => [
                                                                'scalar' => [
                                                                    'type' => ScalarNode::class,
                                                                    'hash' => 3448432817,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => ScalarNode::class,
                                                                    'hash' => 3448432817,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'empty key',
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
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 2678523598,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                                    'text' => ']',
                                                ],
                                            ],
                                            'children' => [],
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
                    'hash' => 3870784440,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4216769160,
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
                            'hash' => 4216769160,
                            'properties' => [
                                'flowSequence' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 341112522,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 341112522,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 2321676163,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 3296102772,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_SEQUENCE_START,
                                                    'text' => '[',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => ValueNode::class,
                                            'hash' => 2321676163,
                                            'properties' => [
                                                'keyValueCouple' => [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 1831707394,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 1831707394,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 223405430,
                                                        ],
                                                        'mappingValueIndicator' => [
                                                            'type' => SyntaxTokenNode::class,
                                                            'hash' => 675194587,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 2624197704,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 223405430,
                                                            'properties' => [],
                                                            'children' => [],
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
                                                            'hash' => 2624197704,
                                                            'properties' => [
                                                                'scalar' => [
                                                                    'type' => ScalarNode::class,
                                                                    'hash' => 718042682,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => ScalarNode::class,
                                                                    'hash' => 718042682,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'another empty key',
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
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 2678523598,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                                    'text' => ']',
                                                ],
                                            ],
                                            'children' => [],
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
