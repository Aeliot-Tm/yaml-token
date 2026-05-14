<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 898533906,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1638537006,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2213372570,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 874425984,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 313574918,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 874425984,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1583972959,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1583972959,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'a',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
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
                            'type' => ValueNode::class,
                            'hash' => 313574918,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 183124049,
                                ],
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 273471049,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 183124049,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorNode::class,
                                            'hash' => 4251425094,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorNode::class,
                                            'hash' => 4251425094,
                                            'properties' => [
                                                'name' => ':@*!$"<foo>:',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR,
                                                    'text' => '&:@*!$"<foo>:',
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
                                    'type' => ScalarNode::class,
                                    'hash' => 273471049,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'scalar a',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
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
                    'hash' => 1560278651,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3626635258,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3576322803,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3626635258,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 4248765686,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 4248765686,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'b',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
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
                            'type' => ValueNode::class,
                            'hash' => 3576322803,
                            'properties' => [
                                'alias' => [
                                    'type' => AliasNode::class,
                                    'hash' => 766441886,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => AliasNode::class,
                                    'hash' => 766441886,
                                    'properties' => [
                                        'name' => ':@*!$"<foo>:',
                                        'anchorName' => ':@*!$"<foo>:',
                                        'token' => [
                                            'type' => TokenType::ALIAS,
                                            'text' => '*:@*!$"<foo>:',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
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
