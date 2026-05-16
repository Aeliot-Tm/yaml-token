<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2625594677,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2889030070,
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
                    'hash' => 1578878114,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 3892030076,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => ScalarNode::class,
                            'hash' => 3892030076,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => "\"quoted\nstring\"",
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
            ],
        ],
        [
            'type' => DocumentNode::class,
            'hash' => 1766861328,
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
                    'hash' => 2643791071,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 657363694,
                        ],
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 3095314157,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 657363694,
                            'properties' => [
                                'anchor' => [
                                    'type' => AnchorNode::class,
                                    'hash' => 318752197,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => AnchorNode::class,
                                    'hash' => 318752197,
                                    'properties' => [
                                        'name' => 'node',
                                        'token' => [
                                            'type' => TokenType::ANCHOR,
                                            'text' => '&node',
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
            ],
        ],
    ],
];
