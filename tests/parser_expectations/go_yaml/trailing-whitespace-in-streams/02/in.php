<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1804044199,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4156720562,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 1916633873,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 804140599,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SequenceEntryNode::class,
                            'hash' => 4074150559,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SEQUENCE_ENTRY,
                                    'text' => '-',
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
                            'hash' => 804140599,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 599544538,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarEntryNode::class,
                                    'hash' => 599544538,
                                    'properties' => [],
                                    'children' => [
                                        [
                                            'type' => BlockScalarOptionsNode::class,
                                            'hash' => 622944022,
                                            'properties' => [
                                                'typeIndicator' => [
                                                    'type' => BlockScalarIndicatorNode::class,
                                                    'hash' => 1768284065,
                                                ],
                                                'chompingIndicator' => [
                                                    'type' => BlockScalarChompingIndicatorNode::class,
                                                    'hash' => 414092453,
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
                                            'hash' => 1187226077,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                    'text' => '   ',
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
