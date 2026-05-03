<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagNode;
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
                    'type' => ValueNode::class,
                    'properties' => [
                        'blockMapping' => [
                            'type' => BlockMappingNode::class,
                            'properties' => [
                                'entries' => [
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
                                                                'text' => 'Mark McGwire',
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
                                            'value' => [
                                                'type' => ValueNode::class,
                                                'properties' => [],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
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
                                                                'text' => 'Sammy Sosa',
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
                                            'value' => [
                                                'type' => ValueNode::class,
                                                'properties' => [],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
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
                                                                'text' => 'Ken Griffey',
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
                                            'value' => [
                                                'type' => ValueNode::class,
                                                'properties' => [],
                                                'children' => [],
                                            ],
                                        ],
                                        'children' => [],
                                    ],
                                ],
                            ],
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
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!!set',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
                    'children' => [],
                ],
            ],
        ],
    ],
];
