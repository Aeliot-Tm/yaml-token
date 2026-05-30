<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\ChompingIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FoldedBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 2015426486,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3476862362,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 2577765930,
                    'properties' => [
                        'payload' => [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 239078945,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 239078945,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => BlockScalarOptionsNode::class,
                                    'hash' => 1527289005,
                                    'properties' => [
                                        'typeIndicator' => [
                                            'type' => BlockScalarIndicatorNode::class,
                                            'hash' => 3228385119,
                                        ],
                                        'chompingIndicator' => [
                                            'type' => ChompingIndicatorNode::class,
                                            'hash' => 2395912562,
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
                                            'type' => ChompingIndicatorNode::class,
                                            'hash' => 2395912562,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::CHOMPING_INDICATOR,
                                                    'text' => '+',
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
                                [
                                    'type' => FoldedBlockScalarNode::class,
                                    'hash' => 1513830886,
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
        ],
    ],
];
