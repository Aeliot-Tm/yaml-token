<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1127222531,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1081942131,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 2156459520,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1490154007,
                        ],
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 1583972959,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1490154007,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'hash' => 4203679380,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagNode::class,
                                    'hash' => 4203679380,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!',
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
