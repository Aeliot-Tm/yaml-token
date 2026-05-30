<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\ChompingIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\IndentationIndicatorNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1685031500,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3650795730,
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
                    'hash' => 2870210649,
                    'properties' => [
                        'payload' => [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 317168638,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 317168638,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => BlockScalarOptionsNode::class,
                                    'hash' => 1090225229,
                                    'properties' => [
                                        'typeIndicator' => [
                                            'type' => BlockScalarIndicatorNode::class,
                                            'hash' => 1768284065,
                                        ],
                                        'chompingIndicator' => [
                                            'type' => ChompingIndicatorNode::class,
                                            'hash' => 2395912562,
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
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
