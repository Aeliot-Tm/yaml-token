<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
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
    'hash' => 1116564568,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 7882401,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowSequenceNode::class,
                    'hash' => 940718892,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 2437735693,
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
                            'hash' => 2437735693,
                            'properties' => [
                                'keyValueCouple' => [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 2335643525,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 2335643525,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 1059383168,
                                        ],
                                        'mappingValueIndicator' => [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 675194587,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 3831843336,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 1059383168,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 197720585,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
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
                                                    'type' => ScalarNode::class,
                                                    'hash' => 197720585,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'foo bar',
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
                                            'hash' => 3831843336,
                                            'properties' => [
                                                'scalar' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 2662811521,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 2662811521,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'baz',
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
];
