<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
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
    'hash' => 4219985726,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 506347115,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 862041382,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 3909469904,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 1526158700,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 2299118072,
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
                            'hash' => 3909469904,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 1455118663,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 2490292323,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 1455118663,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2769000140,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2769000140,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'unquoted',
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
                                    'hash' => 2490292323,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2604267959,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2604267959,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                    'text' => '"separate"',
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
                            'hash' => 1526158700,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 405409433,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 405409433,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 3280317270,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3280317270,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'http://foo.com',
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
                            'hash' => 2299118072,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 119875720,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 4172322135,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 119875720,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 4097327238,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 4097327238,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'omitted value',
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
                                    'type' => ValueNode::class,
                                    'hash' => 4172322135,
                                    'properties' => [],
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
