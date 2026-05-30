<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\IndentationIndicatorNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2234431340,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1462322922,
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
                    'hash' => 1886408960,
                    'properties' => [
                        'payload' => [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 613055165,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 613055165,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => BlockScalarOptionsNode::class,
                                    'hash' => 2805377645,
                                    'properties' => [
                                        'typeIndicator' => [
                                            'type' => BlockScalarIndicatorNode::class,
                                            'hash' => 1768284065,
                                        ],
                                        'chompingIndicator' => [
                                            'type' => BlockScalarChompingIndicatorNode::class,
                                            'hash' => 414092453,
                                        ],
                                        'indentationIndicator' => [
                                            'type' => IndentationIndicatorNode::class,
                                            'hash' => 3127960550,
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
                                            'type' => IndentationIndicatorNode::class,
                                            'hash' => 3127960550,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::INDENTATION_INDICATOR,
                                                    'text' => '1',
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
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
