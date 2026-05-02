<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\WhitespaceNode;
use Aeliot\YamlToken\Node\YamlDirectiveNode;
use Aeliot\YamlToken\Node\YamlDirectiveVersionNode;

return [
    'type' => StreamNode::class,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => YamlDirectiveNode::class,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DIRECTIVE_YAML,
                            'text' => '%YAML',
                        ],
                    ],
                    'children' => [
                        [
                            'type' => WhitespaceNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => YamlDirectiveVersionNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DIRECTIVE_YAML_VERSION,
                                    'text' => '1.1',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => WhitespaceNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => '  ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => CommentNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::COMMENT,
                                    'text' => '# comment',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => NewLineNode::class,
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
        ],
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => DocumentStartNode::class,
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
