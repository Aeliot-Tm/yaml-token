<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentEndNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;

return [
    'type' => StreamNode::class,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
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
                [
                    'type' => DocumentEndNode::class,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DOCUMENT_END,
                            'text' => '...',
                        ],
                    ],
                    'children' => [],
                ],
            ],
        ],
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
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
