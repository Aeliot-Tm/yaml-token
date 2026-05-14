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
    'hash' => 2148895837,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2807094339,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 1664019158,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 4238986954,
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 3080111316,
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
                            'hash' => 4238986954,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 692052378,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 2729608846,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 692052378,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 3200970852,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3200970852,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'sky',
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
                                    'hash' => 2729608846,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 261895824,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 261895824,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'blue',
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 3080111316,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 1852958950,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 1734867649,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 1852958950,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 3184631180,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3184631180,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'sea',
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
                                    'hash' => 1734867649,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2844407591,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2844407591,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'green',
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
