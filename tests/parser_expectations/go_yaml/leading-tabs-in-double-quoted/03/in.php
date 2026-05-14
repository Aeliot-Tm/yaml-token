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
    'hash' => 3715257128,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2310509191,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 985930770,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 168584048,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => ScalarNode::class,
                            'hash' => 168584048,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => "\"4 leading\n    \\t  tab\"",
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
