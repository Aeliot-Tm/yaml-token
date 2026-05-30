<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowMappingEndNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowMappingStartNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
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
    'hash' => 4100784936,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4184340060,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 2056848459,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 41229591,
                        ],
                        'payload' => [
                            'type' => FlowSequenceNode::class,
                            'hash' => 1924892936,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 41229591,
                            'properties' => [
                                'anchor' => [
                                    'type' => AnchorPropertyNode::class,
                                    'hash' => 2153958522,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => AnchorPropertyNode::class,
                                    'hash' => 2153958522,
                                    'properties' => [
                                        'name' => 'flowseq',
                                        'token' => [
                                            'type' => TokenType::ANCHOR_PROPERTY,
                                            'text' => '&flowseq',
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
                            'type' => FlowSequenceNode::class,
                            'hash' => 1924892936,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => ValueNode::class,
                                        'hash' => 3523680059,
                                    ],
                                    [
                                        'type' => ValueNode::class,
                                        'hash' => 3713953398,
                                    ],
                                    [
                                        'type' => ValueNode::class,
                                        'hash' => 3678027671,
                                    ],
                                    [
                                        'type' => ValueNode::class,
                                        'hash' => 2195643652,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceStartNode::class,
                                    'hash' => 2336973104,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_SEQUENCE_START,
                                            'text' => '[',
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
                                    'hash' => 3523680059,
                                    'properties' => [
                                        'payload' => [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 2534009283,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 2534009283,
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
                                                    'hash' => 1154444269,
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
                                                    'hash' => 1154444269,
                                                    'properties' => [
                                                        'payload' => [
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
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => FlowEntryNode::class,
                                    'hash' => 1715075807,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_ENTRY,
                                            'text' => ',',
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
                                    'hash' => 3713953398,
                                    'properties' => [
                                        'payload' => [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 340348729,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 340348729,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3293093241,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 999563081,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3293093241,
                                                    'properties' => [
                                                        'nodeProperties' => [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 4225618949,
                                                        ],
                                                        'name' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2183480583,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => NodePropertiesNode::class,
                                                            'hash' => 4225618949,
                                                            'properties' => [
                                                                'anchor' => [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 152605018,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => AnchorPropertyNode::class,
                                                                    'hash' => 152605018,
                                                                    'properties' => [
                                                                        'name' => 'c',
                                                                        'token' => [
                                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                                            'text' => '&c',
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
                                                            'hash' => 2183480583,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'c',
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
                                                    'hash' => 999563081,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3357265484,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3357265484,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'd',
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
                                [
                                    'type' => FlowEntryNode::class,
                                    'hash' => 1715075807,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_ENTRY,
                                            'text' => ',',
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
                                    'hash' => 3678027671,
                                    'properties' => [
                                        'payload' => [
                                            'type' => FlowMappingNode::class,
                                            'hash' => 1587109802,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => FlowMappingNode::class,
                                            'hash' => 1587109802,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'hash' => 2876763228,
                                                    ],
                                                ],
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
                                                    'hash' => 2876763228,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 2337473570,
                                                        ],
                                                        'valueIndicator' => [
                                                            'type' => ValueIndicatorNode::class,
                                                            'hash' => 3779730559,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 2622256201,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 2337473570,
                                                            'properties' => [
                                                                'nodeProperties' => [
                                                                    'type' => NodePropertiesNode::class,
                                                                    'hash' => 865941048,
                                                                ],
                                                                'name' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 536432148,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => NodePropertiesNode::class,
                                                                    'hash' => 865941048,
                                                                    'properties' => [
                                                                        'anchor' => [
                                                                            'type' => AnchorPropertyNode::class,
                                                                            'hash' => 542865567,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => AnchorPropertyNode::class,
                                                                            'hash' => 542865567,
                                                                            'properties' => [
                                                                                'name' => 'e',
                                                                                'token' => [
                                                                                    'type' => TokenType::ANCHOR_PROPERTY,
                                                                                    'text' => '&e',
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
                                                                    'hash' => 536432148,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'e',
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
                                                            'hash' => 2622256201,
                                                            'properties' => [
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 3165636797,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 3165636797,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'f',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                            ],
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
                                    ],
                                ],
                                [
                                    'type' => FlowEntryNode::class,
                                    'hash' => 1715075807,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_ENTRY,
                                            'text' => ',',
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
                                    'hash' => 2195643652,
                                    'properties' => [
                                        'nodeProperties' => [
                                            'type' => NodePropertiesNode::class,
                                            'hash' => 936872327,
                                        ],
                                        'payload' => [
                                            'type' => FlowMappingNode::class,
                                            'hash' => 3827808317,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => NodePropertiesNode::class,
                                            'hash' => 936872327,
                                            'properties' => [
                                                'anchor' => [
                                                    'type' => AnchorPropertyNode::class,
                                                    'hash' => 2387271139,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => AnchorPropertyNode::class,
                                                    'hash' => 2387271139,
                                                    'properties' => [
                                                        'name' => 'g',
                                                        'token' => [
                                                            'type' => TokenType::ANCHOR_PROPERTY,
                                                            'text' => '&g',
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
                                            'type' => FlowMappingNode::class,
                                            'hash' => 3827808317,
                                            'properties' => [
                                                'entries' => [
                                                    [
                                                        'type' => KeyValueCoupleNode::class,
                                                        'hash' => 1206375925,
                                                    ],
                                                ],
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
                                                    'hash' => 1206375925,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 1942398671,
                                                        ],
                                                        'valueIndicator' => [
                                                            'type' => ValueIndicatorNode::class,
                                                            'hash' => 3779730559,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 67027110,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 1942398671,
                                                            'properties' => [
                                                                'name' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 1800227045,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 1800227045,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'g',
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
                                                            'hash' => 67027110,
                                                            'properties' => [
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 684908075,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 684908075,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'h',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                            ],
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
                                    'type' => FlowSequenceEndNode::class,
                                    'hash' => 539304155,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FLOW_SEQUENCE_END,
                                            'text' => ']',
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
