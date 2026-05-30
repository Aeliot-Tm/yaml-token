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
use Aeliot\YamlToken\Node\YamlVersionDefinitionNode;
use Aeliot\YamlToken\Node\YamlVersionNode;

return [
    'type' => StreamNode::class,
    'hash' => 3766959804,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3303822937,
            'properties' => [],
            'children' => [
                [
                    'type' => YamlVersionDefinitionNode::class,
                    'hash' => 606837880,
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
                            'hash' => 4032462578,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::YAML_VERSION,
                                    'text' => '1.1',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => WhitespaceNode::class,
                            'hash' => 3308018566,
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
                            'hash' => 3518869618,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::COMMENT,
                                    'text' => '# comment',
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
            'hash' => 1152977883,
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
            ],
        ],
    ],
];
