<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'properties' => [],
    'children' => [
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
                [
                    'type' => SequenceEntryNode::class,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'properties' => [
                                                'name' => '😁',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&😁',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'unicode anchor',
                                        ],
                                    ],
                                    'children' => [],
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
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
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
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => ' ',
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
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
