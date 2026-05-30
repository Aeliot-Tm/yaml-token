<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\ChompingIndicatorNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FoldedBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 38790284,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1880872931,
            'properties' => [],
            'children' => [
                [
                    'type' => DocumentStartNode::class,
                    'hash' => 2270658446,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DOCUMENT_START,
                            'text' => '---',
                        ],
                    ],
                    'children' => [],
                ],
                [
                    'type' => WhitespaceNode::class,
                    'hash' => 1067539092,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::WHITESPACE,
                            'text' => ' ',
                        ],
                    ],
                    'children' => [],
                ],
                [
                    'type' => ValueNode::class,
                    'hash' => 1814354930,
                    'properties' => [
                        'payload' => [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 837237943,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 837237943,
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
                                    'hash' => 949161419,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                            'text' => " ab\n \n  \n",
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'type' => DocumentEndNode::class,
                    'hash' => 3858097324,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DOCUMENT_END,
                            'text' => '...',
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
            ],
        ],
    ],
];
