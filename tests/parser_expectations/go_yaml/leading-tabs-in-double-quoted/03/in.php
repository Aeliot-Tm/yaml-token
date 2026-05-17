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
    'hash' => 67484544,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2917960536,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 1854873959,
                    'properties' => [
                        'payload' => [
                            'type' => DoubleQuotedScalarNode::class,
                            'hash' => 424533781,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => DoubleQuotedScalarNode::class,
                            'hash' => 424533781,
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
