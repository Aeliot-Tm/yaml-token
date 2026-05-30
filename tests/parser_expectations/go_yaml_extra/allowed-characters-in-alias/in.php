<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2906718232,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1088525729,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1596812785,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1763095533,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 897408633,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1763095533,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4136715254,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4136715254,
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
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
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
                            'hash' => 897408633,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2257676063,
                                ],
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3897599891,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2257676063,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 2322243319,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 2322243319,
                                            'properties' => [
                                                'name' => ':@*!$"<foo>:',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR_PROPERTY,
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
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3897599891,
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
                    'hash' => 3177771660,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2014718133,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2745006272,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2014718133,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1439155551,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1439155551,
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
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
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
                            'hash' => 2745006272,
                            'properties' => [
                                'payload' => [
                                    'type' => AliasNode::class,
                                    'hash' => 3017958612,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => AliasNode::class,
                                    'hash' => 3017958612,
                                    'properties' => [
                                        'name' => ':@*!$"<foo>:',
                                        'anchorName' => ':@*!$"<foo>:',
                                        'token' => [
                                            'type' => TokenType::ALIAS_NODE,
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
