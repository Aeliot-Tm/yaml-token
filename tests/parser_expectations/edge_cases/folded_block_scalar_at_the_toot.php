<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 4104060978,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2010940921,
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
                    'hash' => 2864761281,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 61165995,
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
                            'hash' => 61165995,
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
