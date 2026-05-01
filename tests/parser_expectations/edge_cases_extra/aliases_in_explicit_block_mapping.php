<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
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
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'properties' => [
                                'explicitKeyIndicatorNode' => [
                                    'type' => ExplicitKeyIndicatorNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                            'text' => '?',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'a',
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
                                [
                                    'type' => AnchorNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::ANCHOR,
                                            'text' => '&a',
                                        ],
                                        'name' => 'a',
                                        'declarationKeyText' => 'a',
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
                        'value' => [
                            'type' => ValueNode::class,
                            'properties' => [
                                'anchor' => [
                                    'type' => AnchorNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::ANCHOR,
                                            'text' => '&b',
                                        ],
                                        'name' => 'b',
                                        'declarationKeyText' => 'a',
                                    ],
                                    'children' => [],
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'b',
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
                            'type' => NewLineNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::NEWLINE,
                                    'text' => '
',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::VALUE_INDICATOR,
                                    'text' => ':',
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
                            'text' => '
',
                        ],
                    ],
                    'children' => [],
                ],
                [
                    'type' => KeyValueCoupleNode::class,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'properties' => [],
                            'children' => [],
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'properties' => [
                                'alias' => [
                                    'type' => AliasNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::ALIAS,
                                            'text' => '*a',
                                        ],
                                        'name' => 'a',
                                        'anchorName' => 'a',
                                    ],
                                    'children' => [],
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SyntaxTokenNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::VALUE_INDICATOR,
                                    'text' => ':',
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
                            'text' => '
',
                        ],
                    ],
                    'children' => [],
                ],
            ],
        ],
    ],
];
