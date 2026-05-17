<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 2144329107,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1602419405,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 2003780525,
                    'properties' => [
                        'payload' => [
                            'type' => LiteralBlockScalarNode::class,
                            'hash' => 92126014,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarIndicatorNode::class,
                            'hash' => 1768284065,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                    'text' => '|',
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
                        [
                            'type' => LiteralBlockScalarNode::class,
                            'hash' => 92126014,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                    'text' => "  root line 1\n  root line 2\n",
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
