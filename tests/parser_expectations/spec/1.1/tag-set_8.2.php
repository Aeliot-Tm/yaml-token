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
    'hash' => 205519573,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 721689877,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 737913058,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 3067572638,
                        ],
                        'blockMapping' => [
                            'type' => BlockMappingNode::class,
                            'hash' => 1377068447,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 3067572638,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'hash' => 1576210103,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagNode::class,
                                    'hash' => 1576210103,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!!set',
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
                            'type' => BlockMappingNode::class,
                            'hash' => 1377068447,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 793220381,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 1197025055,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 9848692,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 793220381,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 2778000982,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 2778000982,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 1643430909,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
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
                                                    'type' => ScalarNode::class,
                                                    'hash' => 1643430909,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'Mark McGwire',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                            'properties' => [],
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
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 1197025055,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 2302511492,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 2302511492,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 1925332255,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
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
                                                    'type' => ScalarNode::class,
                                                    'hash' => 1925332255,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'Sammy Sosa',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                            'properties' => [],
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
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 9848692,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 849792790,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 849792790,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 431176223,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
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
                                                    'type' => ScalarNode::class,
                                                    'hash' => 431176223,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'Ken Griffey',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                            'properties' => [],
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
                ],
            ],
        ],
    ],
];
