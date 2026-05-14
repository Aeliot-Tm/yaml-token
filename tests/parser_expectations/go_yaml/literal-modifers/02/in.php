<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndentationIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2811587027,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 591127263,
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
                    'hash' => 2075560395,
                    'properties' => [],
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
                            'type' => BlockScalarIndentationIndicatorNode::class,
                            'hash' => 964000784,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
                                    'text' => '1',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => BlockScalarChompingIndicatorNode::class,
                            'hash' => 2238875574,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
                                    'text' => '-',
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
