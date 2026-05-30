<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\IndentNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SingleQuotedScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2682080270,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2591819721,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3841794116,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1600874168,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4013621171,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1600874168,
                            'properties' => [
                                'name' => [
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 351968075,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 351968075,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                            'text' => '"top1"',
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
                            'hash' => 4013621171,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 419041754,
                                ],
                            ],
                            'children' => [
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
                                    'hash' => 419041754,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3175725089,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 3175725089,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3951721509,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 220354459,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3951721509,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => DoubleQuotedScalarNode::class,
                                                            'hash' => 3418373552,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => DoubleQuotedScalarNode::class,
                                                            'hash' => 3418373552,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                                    'text' => '"key1"',
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
                                                    'hash' => 220354459,
                                                    'properties' => [
                                                        'nodeProperties' => [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 2210587052,
                                                        ],
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3503144888,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 2210587052,
                                                            'properties' => [
                                                                'anchor' => [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 2574897114,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 2574897114,
                                                                    'properties' => [
                                                                        'name' => 'alias1',
                                                                        'token' => [
                                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                                            'text' => '&alias1',
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
                                                            'hash' => 3503144888,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'scalar1',
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
                    'hash' => 1640383553,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3023550877,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2753631307,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3023550877,
                            'properties' => [
                                'name' => [
                                    'type' => SingleQuotedScalarNode::class,
                                    'hash' => 3367339072,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => SingleQuotedScalarNode::class,
                                    'hash' => 3367339072,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::SINGLE_QUOTED_SCALAR,
                                            'text' => '\'top2\'',
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
                            'hash' => 2753631307,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 1547997709,
                                ],
                            ],
                            'children' => [
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
                                    'hash' => 1547997709,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 193880265,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 193880265,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2522245932,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 119490247,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 2522245932,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => SingleQuotedScalarNode::class,
                                                            'hash' => 2466036972,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => SingleQuotedScalarNode::class,
                                                            'hash' => 2466036972,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::SINGLE_QUOTED_SCALAR,
                                                                    'text' => '\'key2\'',
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
                                                    'hash' => 119490247,
                                                    'properties' => [
                                                        'nodeProperties' => [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 2285004017,
                                                        ],
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 1939552529,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 2285004017,
                                                            'properties' => [
                                                                'anchor' => [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 3515154894,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 3515154894,
                                                                    'properties' => [
                                                                        'name' => 'alias2',
                                                                        'token' => [
                                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                                            'text' => '&alias2',
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
                                                            'hash' => 1939552529,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'scalar2',
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
                    'hash' => 313793523,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3473648290,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 341435409,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3473648290,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4038480634,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 4038480634,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'top3',
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
                            'hash' => 341435409,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2726557886,
                                ],
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 4176670982,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 2726557886,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 265648862,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 265648862,
                                            'properties' => [
                                                'name' => 'node3',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR_PROPERTY,
                                                    'text' => '&node3',
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
                                    'hash' => 4176670982,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1060332928,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 1060332928,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 1406094985,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2282791523,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 1406094985,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => AliasNode::class,
                                                            'hash' => 647636161,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => AliasNode::class,
                                                            'hash' => 647636161,
                                                            'properties' => [
                                                                'name' => 'alias1',
                                                                'anchorName' => 'alias1',
                                                                'token' => [
                                                                    'type' => TokenType::ALIAS_NODE,
                                                                    'text' => '*alias1',
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
                                                    'hash' => 2282791523,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2759440713,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2759440713,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'scalar3',
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
                    'hash' => 2244212056,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 975690248,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4230104387,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 975690248,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3129530801,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3129530801,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'top4',
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
                            'hash' => 4230104387,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 2044103995,
                                ],
                            ],
                            'children' => [
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
                                    'hash' => 2044103995,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3090216982,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 3090216982,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 1445920179,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 788514992,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 1445920179,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => AliasNode::class,
                                                            'hash' => 4076147166,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => AliasNode::class,
                                                            'hash' => 4076147166,
                                                            'properties' => [
                                                                'name' => 'alias2',
                                                                'anchorName' => 'alias2',
                                                                'token' => [
                                                                    'type' => TokenType::ALIAS_NODE,
                                                                    'text' => '*alias2',
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
                                                    'hash' => 788514992,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3997643266,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3997643266,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'scalar4',
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
                    'hash' => 516743536,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 2477431285,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1075673020,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 2477431285,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1835686377,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 1835686377,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'top5',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                            ],
                        ],
                        [
                            'type' => WhitespaceNode::class,
                            'hash' => 913287119,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => '   ',
                                ],
                            ],
                            'children' => [],
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
                            'hash' => 966532359,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::WHITESPACE,
                                    'text' => '    ',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => ValueNode::class,
                            'hash' => 1075673020,
                            'properties' => [
                                'payload' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 967160410,
                                ],
                            ],
                            'children' => [
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
                                    'type' => IndentNode::class,
                                    'hash' => 2852255048,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::INDENT,
                                            'text' => '  ',
                                        ],
                                    ],
                                    'children' => [],
                                ],
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 967160410,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'scalar5',
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
                    'hash' => 2686476994,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 577180909,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4235270265,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 577180909,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3460095808,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 3460095808,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'top6',
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
                            'hash' => 4235270265,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 1190764097,
                                ],
                            ],
                            'children' => [
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
                                    'hash' => 1190764097,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 2237444025,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 2237444025,
                                            'properties' => [
                                                'indent' => [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 436252612,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 1125507446,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentNode::class,
                                                    'hash' => 2852255048,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENT,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 436252612,
                                                    'properties' => [
                                                        'nodeProperties' => [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 3828103501,
                                                        ],
                                                        'name' => [
                                                            'type' => SingleQuotedScalarNode::class,
                                                            'hash' => 3692124085,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 3828103501,
                                                            'properties' => [
                                                                'anchor' => [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 2728976943,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 2728976943,
                                                                    'properties' => [
                                                                        'name' => 'anchor6',
                                                                        'token' => [
                                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                                            'text' => '&anchor6',
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
                                                            'type' => SingleQuotedScalarNode::class,
                                                            'hash' => 3692124085,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::SINGLE_QUOTED_SCALAR,
                                                                    'text' => '\'key6\'',
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
                                                    'hash' => 1125507446,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2599630067,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2599630067,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'scalar6',
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
