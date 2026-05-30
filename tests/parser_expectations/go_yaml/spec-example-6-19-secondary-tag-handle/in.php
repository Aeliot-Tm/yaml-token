<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagDefinitionNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Node\TagHandleNode;
use Aeliot\YamlToken\Node\TagPrefixNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 4288458671,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 859399485,
            'properties' => [],
            'children' => [
                [
                    'type' => TagDefinitionNode::class,
                    'hash' => 2286697498,
                    'properties' => [],
                    'children' => [
                        [
                            'type' => TagDirectiveNode::class,
                            'hash' => 414177067,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::TAG_DIRECTIVE,
                                    'text' => '%TAG',
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
                            'type' => TagHandleNode::class,
                            'hash' => 1248822115,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::TAG_HANDLE,
                                    'text' => '!!',
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
                            'type' => TagPrefixNode::class,
                            'hash' => 2050170584,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::TAG_PREFIX,
                                    'text' => 'tag:example.com,2000:app/',
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
            'hash' => 1948590667,
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
                    'hash' => 2753799425,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1456294572,
                        ],
                        'payload' => [
                            'type' => PlainScalarNode::class,
                            'hash' => 259515171,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1456294572,
                            'properties' => [
                                'tag' => [
                                    'type' => TagPropertyNode::class,
                                    'hash' => 2530070910,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagPropertyNode::class,
                                    'hash' => 2530070910,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG_PROPERTY,
                                            'text' => '!!int',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
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
                            'type' => PlainScalarNode::class,
                            'hash' => 259515171,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::PLAIN_SCALAR,
                                    'text' => '1 - 3',
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
                            'hash' => 2160745761,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::COMMENT,
                                    'text' => '# Interval, not integer',
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
