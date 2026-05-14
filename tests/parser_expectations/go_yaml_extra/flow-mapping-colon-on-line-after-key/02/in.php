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
    'hash' => 308264128,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1042102774,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 1016210121,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 2138555783,
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
                            'hash' => 2138555783,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 2394387173,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 605329290,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 2394387173,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 3095314157,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 3095314157,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'foo',
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
                                    'hash' => 605329290,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2534824452,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2534824452,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'bar',
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
