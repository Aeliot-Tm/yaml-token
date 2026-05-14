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
    'hash' => 623579436,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 656011609,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 1974460967,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 2609134105,
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
                            'hash' => 2609134105,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 1189089890,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 3327462533,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 1189089890,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2473075848,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2473075848,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'x',
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
                                    'hash' => 3327462533,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2036126346,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2036126346,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => ':x',
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
