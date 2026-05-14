<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
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
    'hash' => 685479496,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 323268200,
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
                    'type' => FlowSequenceNode::class,
                    'hash' => 196375785,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 58186209,
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
                            'type' => WhitespaceNode::class,
                            'hash' => 3308018566,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => '  ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => ValueNode::class,
                            'hash' => 58186209,
                            'properties' => [
                                'keyValueCouple' => [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 3305413002,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 3305413002,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 3290628233,
                                        ],
                                        'mappingValueIndicator' => [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 675194587,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2324860879,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 3290628233,
                                            'properties' => [
                                                'name' => [
                                                    'type' => FlowSequenceNode::class,
                                                    'hash' => 3194995433,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => FlowSequenceNode::class,
                                                    'hash' => 3194995433,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => ValueNode::class,
                                                                'hash' => 3271794012,
                                                            ],
                                                            [
                                                                'type' => ValueNode::class,
                                                                'hash' => 2518224138,
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
                                                            'hash' => 3271794012,
                                                            'properties' => [
                                                                'scalar' => [
                                                                    'type' => ScalarNode::class,
                                                                    'hash' => 1583972959,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => ScalarNode::class,
                                                                    'hash' => 1583972959,
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
                                                            'hash' => 2518224138,
                                                            'properties' => [
                                                                'flowSequence' => [
                                                                    'type' => FlowSequenceNode::class,
                                                                    'hash' => 3378051981,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => FlowSequenceNode::class,
                                                                    'hash' => 3378051981,
                                                                    'properties' => [
                                                                        'entries' => [
                                                                            [
                                                                                'type' => ValueNode::class,
                                                                                'hash' => 4140903282,
                                                                            ],
                                                                            [
                                                                                'type' => ValueNode::class,
                                                                                'hash' => 1789193627,
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
                                                                            'hash' => 4140903282,
                                                                            'properties' => [
                                                                                'keyValueCouple' => [
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 3578371367,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 3578371367,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2020661103,
                                                                                        ],
                                                                                        'mappingValueIndicator' => [
                                                                                            'type' => SyntaxTokenNode::class,
                                                                                            'hash' => 675194587,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 1342275416,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2020661103,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => FlowSequenceNode::class,
                                                                                                    'hash' => 1136585283,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => FlowSequenceNode::class,
                                                                                                    'hash' => 1136585283,
                                                                                                    'properties' => [
                                                                                                        'entries' => [
                                                                                                            [
                                                                                                                'type' => ValueNode::class,
                                                                                                                'hash' => 2811047125,
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
                                                                                                            'hash' => 2811047125,
                                                                                                            'properties' => [
                                                                                                                'flowSequence' => [
                                                                                                                    'type' => FlowSequenceNode::class,
                                                                                                                    'hash' => 998458694,
                                                                                                                ],
                                                                                                            ],
                                                                                                            'children' => [
                                                                                                                [
                                                                                                                    'type' => FlowSequenceNode::class,
                                                                                                                    'hash' => 998458694,
                                                                                                                    'properties' => [
                                                                                                                        'entries' => [
                                                                                                                            [
                                                                                                                                'type' => ValueNode::class,
                                                                                                                                'hash' => 792149030,
                                                                                                                            ],
                                                                                                                            [
                                                                                                                                'type' => ValueNode::class,
                                                                                                                                'hash' => 3569730860,
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
                                                                                                                            'hash' => 792149030,
                                                                                                                            'properties' => [
                                                                                                                                'scalar' => [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 4248765686,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 4248765686,
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
                                                                                                                            'type' => ValueNode::class,
                                                                                                                            'hash' => 3569730860,
                                                                                                                            'properties' => [
                                                                                                                                'scalar' => [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 719160494,
                                                                                                                                ],
                                                                                                                            ],
                                                                                                                            'children' => [
                                                                                                                                [
                                                                                                                                    'type' => ScalarNode::class,
                                                                                                                                    'hash' => 719160494,
                                                                                                                                    'properties' => [
                                                                                                                                        'token' => [
                                                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                                                            'text' => 'c',
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
                                                                                            'hash' => 1342275416,
                                                                                            'properties' => [
                                                                                                'scalar' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 1625493477,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 1625493477,
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
                                                                            'hash' => 1789193627,
                                                                            'properties' => [
                                                                                'scalar' => [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 3070332861,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 3070332861,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'e',
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
                                            'hash' => 2324860879,
                                            'properties' => [
                                                'scalar' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 58225468,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 58225468,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => '23',
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
];
