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
    'hash' => 2347881725,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3253415172,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 440444646,
                    'properties' => [
                        'payload' => [
                            'type' => DoubleQuotedScalarNode::class,
                            'hash' => 1612315192,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => DoubleQuotedScalarNode::class,
                            'hash' => 1612315192,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => "\"folded \nto a space,\t\n \nto a line feed, or \t\\\n \\ \tnon-content\"",
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
