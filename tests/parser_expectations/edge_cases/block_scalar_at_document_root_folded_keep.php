<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 2514542005,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3229357040,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 2642760727,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 3525660230,
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
                            'type' => BlockScalarChompingIndicatorNode::class,
                            'hash' => 414092453,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
                                    'text' => '+',
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
                            'hash' => 3525660230,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
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
