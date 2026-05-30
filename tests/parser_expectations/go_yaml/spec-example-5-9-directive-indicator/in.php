<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Node\YamlVersionDirectiveNode;
use Aeliot\YamlToken\Node\YamlVersionNode;

return [
    'type' => StreamNode::class,
    'hash' => 2721401781,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3418502130,
            'properties' => [],
            'children' => [
                [
                    'type' => YamlVersionDirectiveNode::class,
                    'hash' => 4026005711,
                    'properties' => [],
                    'children' => [
                        [
                            'type' => YamlDirectiveNode::class,
                            'hash' => 3809990733,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::YAML_DIRECTIVE,
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
            'hash' => 1766112900,
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
                    'hash' => 1739966451,
                    'properties' => [
                        'payload' => [
                            'type' => PlainScalarNode::class,
                            'hash' => 2876107552,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => PlainScalarNode::class,
                            'hash' => 2876107552,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => 'text',
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
    ],
];
