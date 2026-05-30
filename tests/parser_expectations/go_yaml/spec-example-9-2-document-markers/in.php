<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\YamlVersionDirectiveNode;
use Aeliot\YamlToken\Node\YamlVersionNode;

return [
    'type' => StreamNode::class,
    'hash' => 1132065685,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3039714280,
            'properties' => [],
            'children' => [
                [
                    'type' => YamlVersionDirectiveNode::class,
                    'hash' => 1831138458,
                    'properties' => [],
                    'children' => [
                        [
                            'type' => YamlDirectiveIndicatorNode::class,
                            'hash' => 3872005402,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DIRECTIVE_YAML_INDICATOR,
                                    'text' => '%YAML',
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
                            'type' => YamlVersionNode::class,
                            'hash' => 1393358939,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::YAML_VERSION,
                                    'text' => '1.2',
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
            ],
        ],
        [
            'type' => DocumentNode::class,
            'hash' => 3271030008,
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
                    'type' => ValueNode::class,
                    'hash' => 516778104,
                    'properties' => [
                        'payload' => [
                            'type' => PlainScalarNode::class,
                            'hash' => 1191735796,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => PlainScalarNode::class,
                            'hash' => 1191735796,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'Document',
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
                    'type' => CommentNode::class,
                    'hash' => 3725557781,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# Suffix',
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
