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
    'hash' => 2299804073,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1333342003,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 3295474619,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 1509452551,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => ScalarNode::class,
                            'hash' => 1509452551,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => "\"3 leading\n    \ttab\"",
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
