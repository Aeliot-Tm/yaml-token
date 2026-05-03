<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
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
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'properties' => [
                                    'key' => [
                                        'type' => KeyNode::class,
                                        'properties' => [
                                            'name' => [
                                                'type' => ScalarNode::class,
                                                'properties' => [
                                                    'token' => [
                                                        'type' => TokenType::PLAIN_SCALAR,
                                                        'text' => 'https://example.com',
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [],
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'properties' => [
                                    'key' => [
                                        'type' => KeyNode::class,
                                        'properties' => [
                                            'name' => [
                                                'type' => ScalarNode::class,
                                                'properties' => [
                                                    'token' => [
                                                        'type' => TokenType::PLAIN_SCALAR,
                                                        'text' => 'omitted value',
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                    'mappingValueIndicator' => [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::VALUE_INDICATOR,
                                                'text' => ':',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => WhitespaceNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::WHITESPACE,
                                                'text' => ' ',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
                            [
                                'type' => KeyValueCoupleNode::class,
                                'properties' => [
                                    'key' => [
                                        'type' => KeyNode::class,
                                        'properties' => [
                                            'explicitKeyIndicatorNode' => [
                                                'type' => ExplicitKeyIndicatorNode::class,
                                                'properties' => [
                                                    'token' => [
                                                        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                        'text' => '?',
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [
                                            [
                                                'type' => WhitespaceNode::class,
                                                'properties' => [
                                                    'token' => [
                                                        'type' => TokenType::WHITESPACE,
                                                        'text' => ' ',
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                        ],
                                    ],
                                    'mappingValueIndicator' => [
                                        'type' => SyntaxTokenNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::VALUE_INDICATOR,
                                                'text' => ':',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                    'value' => [
                                        'type' => ValueNode::class,
                                        'properties' => [
                                            'scalar' => [
                                                'type' => ScalarNode::class,
                                                'properties' => [
                                                    'token' => [
                                                        'type' => TokenType::PLAIN_SCALAR,
                                                        'text' => 'omitted key',
                                                    ],
                                                ],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                                'children' => [
                                    [
                                        'type' => WhitespaceNode::class,
                                        'properties' => [
                                            'token' => [
                                                'type' => TokenType::WHITESPACE,
                                                'text' => ' ',
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_START,
                                    'text' => '{',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
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
