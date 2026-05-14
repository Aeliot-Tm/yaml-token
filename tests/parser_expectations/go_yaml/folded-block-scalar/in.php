<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 4036221117,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 698833780,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 3267080159,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 765778081,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarIndicatorNode::class,
                            'hash' => 3228385119,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                    'text' => '>',
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
                            'type' => ScalarNode::class,
                            'hash' => 765778081,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                    'text' => " ab\n cd\n \n ef\n\n\n gh\n",
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
