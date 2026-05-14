<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 2101448504,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1292443187,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 3263656304,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 1289262255,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => ScalarNode::class,
                            'hash' => 1289262255,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => "\"5 leading\n    \\\t  tab\"",
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
