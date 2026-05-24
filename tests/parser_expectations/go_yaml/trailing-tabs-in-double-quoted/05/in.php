<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 182278636,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1275677093,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 527440112,
                    'properties' => [
                        'payload' => [
                            'type' => DoubleQuotedScalarNode::class,
                            'hash' => 1470706493,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => DoubleQuotedScalarNode::class,
                            'hash' => 1470706493,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => "\"6 trailing\t  \n    tab\"",
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
