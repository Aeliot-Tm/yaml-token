<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarEntryNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarOptionsNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 2945787128,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2742083340,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 825937979,
                    'properties' => [
                        'payload' => [
                            'type' => MultilinePlainScalarNode::class,
                            'hash' => 90328439,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => MultilinePlainScalarNode::class,
                            'hash' => 90328439,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 2042132213,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'Bare',
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
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3369976133,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'document',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
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
        [
            'type' => DocumentNode::class,
            'hash' => 2437195110,
            'properties' => [],
            'children' => [
                [
                    'type' => CommentNode::class,
                    'hash' => 206637241,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# No document',
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
        [
            'type' => DocumentNode::class,
            'hash' => 4101804183,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 2213953396,
                    'properties' => [
                        'payload' => [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 2149854371,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarEntryNode::class,
                            'hash' => 2149854371,
                            'properties' => [],
                            'children' => [
                                [
                                    'type' => BlockScalarOptionsNode::class,
                                    'hash' => 3707031435,
                                    'properties' => [
                                        'typeIndicator' => [
                                            'type' => BlockScalarIndicatorNode::class,
                                            'hash' => 1768284065,
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
                                    'hash' => 3110358139,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                            'text' => "%!PS-Adobe-2.0 # Not the first line\n",
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
