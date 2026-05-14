<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DirectiveNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;

return [
    'type' => StreamNode::class,
    'hash' => 3668609583,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3603258728,
            'properties' => [],
            'children' => [
                [
                    'type' => DirectiveNode::class,
                    'hash' => 3053057712,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::DIRECTIVE,
                            'text' => '%YAMLL 1.1',
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
