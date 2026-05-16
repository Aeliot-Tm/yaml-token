<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 4093902843,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1538347880,
            'properties' => [],
            'children' => [
                [
                    'type' => DocumentStartNode::class,
                    'hash' => 2270658446,
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
                    'type' => FlowMappingNode::class,
                    'hash' => 2777118189,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 935548602,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 2741709072,
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 1300945157,
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 935548602,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 3175425762,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 20540873,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 3175425762,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 858566253,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 858566253,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'top1',
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
                                    'hash' => 20540873,
                                    'properties' => [
                                        'flowSequence' => [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 3983741081,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => FlowSequenceNode::class,
                                            'hash' => 3983741081,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 3660564068,
                                                    ],
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 1637813094,
                                                    ],
                                                    [
                                                        'type' => ValueNode::class,
                                                        'hash' => 3378094783,
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
                                                    'hash' => 3660564068,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3053898661,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3053898661,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'item1',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 3965909453,
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
                                                    'hash' => 1637813094,
                                                    'properties' => [
                                                        'flowMapping' => [
                                                            'type' => FlowMappingNode::class,
                                                            'hash' => 2660283605,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => FlowMappingNode::class,
                                                            'hash' => 2660283605,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 277266608,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => SyntaxTokenNode::class,
                                                                    'hash' => 1300945157,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::FLOW_MAPPING_START,
                                                                            'text' => '{',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 277266608,
                                                                    'properties' => [
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 2063680013,
                                                                        ],
                                                                        'mappingValueIndicator' => [
                                                                            'type' => SyntaxTokenNode::class,
                                                                            'hash' => 675194587,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 605431298,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 2063680013,
                                                                            'properties' => [
                                                                                'name' => [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 3701317434,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 3701317434,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'key2',
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
                                                                            'hash' => 605431298,
                                                                            'properties' => [
                                                                                'scalar' => [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 2919285017,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 2919285017,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'value2',
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [],
                                                                                ],
                                                                            ],
                                                                        ],
                                                                    ],
                                                                ],
                                                                [
                                                                    'type' => SyntaxTokenNode::class,
                                                                    'hash' => 2204982300,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::FLOW_MAPPING_END,
                                                                            'text' => '}',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                            ],
                                                        ],
                                                    ],
                                                ],
                                                [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 3965909453,
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
                                                    'hash' => 3378094783,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3266497876,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 3266497876,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'item3',
                                                                ],
                                                            ],
                                                            'children' => [],
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
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 3965909453,
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 2741709072,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 3095221707,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 605431298,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 3095221707,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2423924932,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2423924932,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'top2',
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
                                    'hash' => 605431298,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2919285017,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2919285017,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'value2',
                                                ],
                                            ],
                                            'children' => [],
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
                            'hash' => 2204982300,
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
];
