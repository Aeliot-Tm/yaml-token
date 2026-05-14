<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2095264901,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4003350325,
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
                    'type' => FlowMappingNode::class,
                    'hash' => 3537476829,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => KeyValueCoupleNode::class,
                                'hash' => 3509030027,
                            ],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 1300945157,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_START,
                                    'text' => '{',
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
                            'type' => KeyValueCoupleNode::class,
                            'hash' => 3509030027,
                            'properties' => [
                                'key' => [
                                    'type' => KeyNode::class,
                                    'hash' => 1641000696,
                                ],
                                'mappingValueIndicator' => [
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                ],
                                'value' => [
                                    'type' => ValueNode::class,
                                    'hash' => 668611688,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyNode::class,
                                    'hash' => 1641000696,
                                    'properties' => [
                                        'name' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2580060403,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2580060403,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                    'text' => '"foo"',
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
                                    'type' => SyntaxTokenNode::class,
                                    'hash' => 675194587,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::VALUE_INDICATOR,
                                            'text' => ':',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => ValueNode::class,
                                    'hash' => 668611688,
                                    'properties' => [
                                        'scalar' => [
                                            'type' => ScalarNode::class,
                                            'hash' => 2534824452,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => ScalarNode::class,
                                            'hash' => 2534824452,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::PLAIN_SCALAR,
                                                    'text' => 'bar',
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
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'hash' => 2204982300,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_MAPPING_END,
                                    'text' => '}',
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
        ],
    ],
];
