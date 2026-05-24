<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 1337277850,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1312206770,
            'properties' => [],
            'children' => [
                [
                    'type' => WhitespaceNode::class,
                    'hash' => 1861937045,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::WHITESPACE,
                            'text' => "\t",
                        ],
                    ],
                    'children' => [],
                ],
                [
                    'type' => FlowMappingNode::class,
                    'hash' => 639776339,
                    'properties' => [
                        'entries' => [],
                    ],
                    'children' => [
                        [
                            'type' => FlowMappingStartNode::class,
                            'hash' => 1553869732,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_START,
                                    'text' => '{',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => FlowMappingEndNode::class,
                            'hash' => 1100359731,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_END,
                                    'text' => '}',
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
