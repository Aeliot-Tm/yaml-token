<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\LiteralBlockScalarNode;
use Aeliot\YamlToken\Node\MultilinePlainScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 909673243,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2354284416,
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
                    'hash' => 3322939406,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 3675476179,
                        ],
                        'payload' => [
                            'type' => BlockMappingNode::class,
                            'hash' => 534220693,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 3675476179,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'hash' => 3477114139,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagNode::class,
                                    'hash' => 3477114139,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!<tag:clarkevans.com,2002:invoice>',
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
                            'hash' => 534220693,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 3880289803,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 2609948015,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 91378591,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 3386721143,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 890124622,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 2174469380,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 2255166951,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 1911723594,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 3880289803,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 81872006,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2582563141,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 81872006,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 1465588365,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 1465588365,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'invoice',
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
                                            'hash' => 2582563141,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2136685630,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2136685630,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => '34843',
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
                                    'hash' => 2609948015,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 3000178607,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2019064746,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 3000178607,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 133505891,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 133505891,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'date',
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
                                            'hash' => 2019064746,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 328928421,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 328928421,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => '2001-01-23',
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
                                    'hash' => 91378591,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 1627171644,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 3824472808,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 1627171644,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 806349909,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 806349909,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'bill-to',
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
                                            'hash' => 3824472808,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 1971890266,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 4276104029,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 1971890266,
                                                    'properties' => [
                                                        'anchor' => [
                                                            'type' => AnchorNode::class,
                                                            'hash' => 3406760715,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => AnchorNode::class,
                                                            'hash' => 3406760715,
                                                            'properties' => [
                                                                'name' => 'id001',
                                                                'token' => [
                                                                    'type' => TokenType::ANCHOR,
                                                                    'text' => '&id001',
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
                                                    'hash' => 4276104029,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 618649019,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 1330261012,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 1262385461,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 618649019,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2024514055,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 2542682394,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::INDENTATION,
                                                                            'text' => '    ',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2024514055,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 349867198,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 349867198,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'given',
                                                                                ],
                                                                            ],
                                                                            'children' => [],
                                                                        ],
                                                                    ],
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
                                                                    'hash' => 2542682394,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 3840792336,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 3840792336,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'Chris',
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
                                                            'hash' => 1330261012,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 1141253318,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 914419242,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::INDENTATION,
                                                                            'text' => '    ',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 1141253318,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 3407888184,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 3407888184,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'family',
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
                                                                    'hash' => 914419242,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 1278925010,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 1278925010,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'Dumars',
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
                                                            'hash' => 1262385461,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2786629895,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 2311909777,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::INDENTATION,
                                                                            'text' => '    ',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2786629895,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2666275166,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2666275166,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'address',
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
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 2311909777,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => BlockMappingNode::class,
                                                                            'hash' => 3553931219,
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
                                                                            'hash' => 3553931219,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 2638410057,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 1167321028,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 3385022698,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 1662013153,
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 2638410057,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2064614724,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 1813038427,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '        ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2064614724,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 687425034,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 687425034,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'lines',
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
                                                                                            'hash' => 1813038427,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => LiteralBlockScalarNode::class,
                                                                                                    'hash' => 3533346899,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => BlockScalarIndicatorNode::class,
                                                                                                    'hash' => 1768284065,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
                                                                                                            'text' => '|',
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
                                                                                                    'type' => LiteralBlockScalarNode::class,
                                                                                                    'hash' => 3533346899,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::LITERAL_BLOCK_SCALAR,
                                                                                                            'text' => "            458 Walkman Dr.\n            Suite #292\n",
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                ],
                                                                                [
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 1167321028,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2462000227,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 1906730473,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '        ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2462000227,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3025485624,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3025485624,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'city',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
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
                                                                                            'hash' => 1906730473,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2798223914,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2798223914,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'Royal Oak',
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
                                                                                    'hash' => 3385022698,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1296404254,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 14977068,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '        ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1296404254,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1134341915,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1134341915,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'state',
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
                                                                                            'hash' => 14977068,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 442237418,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 442237418,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'MI',
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
                                                                                    'hash' => 1662013153,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3369863553,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 654309560,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 2695069651,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '        ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3369863553,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 4092344682,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 4092344682,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'postal',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
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
                                                                                            'hash' => 654309560,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 4151874908,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 4151874908,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '48046',
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
                                    'hash' => 3386721143,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 4184792626,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2295571747,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 4184792626,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2609678868,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2609678868,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'ship-to',
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
                                            'hash' => 2295571747,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => AliasNode::class,
                                                    'hash' => 774875236,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => AliasNode::class,
                                                    'hash' => 774875236,
                                                    'properties' => [
                                                        'name' => 'id001',
                                                        'anchorName' => 'id001',
                                                        'token' => [
                                                            'type' => TokenType::ALIAS,
                                                            'text' => '*id001',
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
                                    'hash' => 890124622,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 744762270,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 3581804530,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 744762270,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 3764445963,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 3764445963,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'product',
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
                                            'type' => ValueNode::class,
                                            'hash' => 3581804530,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => BlockSequenceNode::class,
                                                    'hash' => 2031500856,
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
                                                    'type' => BlockSequenceNode::class,
                                                    'hash' => 2031500856,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => BlockSequenceEntryNode::class,
                                                                'hash' => 2221761306,
                                                            ],
                                                            [
                                                                'type' => BlockSequenceEntryNode::class,
                                                                'hash' => 66179702,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => BlockSequenceEntryNode::class,
                                                            'hash' => 2221761306,
                                                            'properties' => [
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1582354307,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::INDENTATION,
                                                                            'text' => '    ',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => SequenceEntryNode::class,
                                                                    'hash' => 4074150559,
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
                                                                    'hash' => 1582354307,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => BlockMappingNode::class,
                                                                            'hash' => 2386144887,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => BlockMappingNode::class,
                                                                            'hash' => 2386144887,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 255692075,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 3587208582,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 185243412,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 3398563397,
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 255692075,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2597833061,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 1334225945,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2597833061,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3450191229,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3450191229,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'sku',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
                                                                                        ],
                                                                                        [
                                                                                            'type' => WhitespaceNode::class,
                                                                                            'hash' => 1849114649,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::WHITESPACE,
                                                                                                    'text' => '         ',
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
                                                                                            'hash' => 1334225945,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2558857567,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2558857567,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'BL394D',
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
                                                                                    'hash' => 3587208582,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3490383271,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 740214988,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '      ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3490383271,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1426495168,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1426495168,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'quantity',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
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
                                                                                            'hash' => 740214988,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2521897326,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2521897326,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '4',
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
                                                                                    'hash' => 185243412,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2900422909,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 2998665512,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '      ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2900422909,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2289083247,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2289083247,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'description',
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
                                                                                            'hash' => 2998665512,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 301619928,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 301619928,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'Basketball',
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
                                                                                    'hash' => 3398563397,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 291636680,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 4257515414,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '      ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 291636680,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1677248614,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1677248614,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'price',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
                                                                                        ],
                                                                                        [
                                                                                            'type' => WhitespaceNode::class,
                                                                                            'hash' => 563711611,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::WHITESPACE,
                                                                                                    'text' => '       ',
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
                                                                                            'hash' => 4257515414,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3598613650,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3598613650,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '450.00',
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
                                                            'type' => BlockSequenceEntryNode::class,
                                                            'hash' => 66179702,
                                                            'properties' => [
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1979523987,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 3551679428,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::INDENTATION,
                                                                            'text' => '    ',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => SequenceEntryNode::class,
                                                                    'hash' => 4074150559,
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
                                                                    'hash' => 1979523987,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => BlockMappingNode::class,
                                                                            'hash' => 844674213,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => BlockMappingNode::class,
                                                                            'hash' => 844674213,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 3558704065,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 2289744721,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 203787383,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 3714934175,
                                                                                    ],
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 3558704065,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2597833061,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 2130846101,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2597833061,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3450191229,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3450191229,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'sku',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
                                                                                        ],
                                                                                        [
                                                                                            'type' => WhitespaceNode::class,
                                                                                            'hash' => 1849114649,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::WHITESPACE,
                                                                                                    'text' => '         ',
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
                                                                                            'hash' => 2130846101,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1517308585,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1517308585,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'BL4438H',
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
                                                                                    'hash' => 2289744721,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3490383271,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 3849392142,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '      ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3490383271,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1426495168,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1426495168,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'quantity',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
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
                                                                                            'hash' => 3849392142,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2832962772,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2832962772,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '1',
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
                                                                                    'hash' => 203787383,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2900422909,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 773529451,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '      ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 2900422909,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2289083247,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2289083247,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'description',
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
                                                                                            'hash' => 773529451,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1532282141,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1532282141,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'Super Hoop',
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
                                                                                    'hash' => 3714934175,
                                                                                    'properties' => [
                                                                                        'indentation' => [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                        ],
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 291636680,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 4026782470,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => IndentationNode::class,
                                                                                            'hash' => 4110986796,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::INDENTATION,
                                                                                                    'text' => '      ',
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [],
                                                                                        ],
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 291636680,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1677248614,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1677248614,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'price',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
                                                                                        ],
                                                                                        [
                                                                                            'type' => WhitespaceNode::class,
                                                                                            'hash' => 563711611,
                                                                                            'properties' => [
                                                                                                'token' => [
                                                                                                    'type' => TokenType::WHITESPACE,
                                                                                                    'text' => '       ',
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
                                                                                            'hash' => 4026782470,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2885053574,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2885053574,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '2392.00',
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
                                    'hash' => 2174469380,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 2429610237,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 355239222,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 2429610237,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 3296463652,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 3296463652,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'tax',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
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
                                            'hash' => 355239222,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 1261610922,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 1261610922,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => '251.42',
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
                                    'hash' => 2255166951,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 412592947,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 3381358667,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 412592947,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 3475080602,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 3475080602,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'total',
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
                                            'hash' => 3381358667,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 582323480,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 582323480,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => '4443.52',
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
                                    'hash' => 1911723594,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 2724310033,
                                        ],
                                        'valueIndicator' => [
                                            'type' => ValueIndicatorNode::class,
                                            'hash' => 3779730559,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 957103009,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 2724310033,
                                            'properties' => [
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 1772567586,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 1772567586,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'comments',
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
                                            'type' => ValueNode::class,
                                            'hash' => 957103009,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => MultilinePlainScalarNode::class,
                                                    'hash' => 3075157577,
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
                                                    'type' => MultilinePlainScalarNode::class,
                                                    'hash' => 3075157577,
                                                    'properties' => [],
                                                    'children' => [
                                                        [
                                                            'type' => IndentationNode::class,
                                                            'hash' => 3551679428,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::INDENTATION,
                                                                    'text' => '    ',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 720152677,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'Late afternoon is best.',
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
                                                            'type' => IndentationNode::class,
                                                            'hash' => 3551679428,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::INDENTATION,
                                                                    'text' => '    ',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 2446416637,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'Backup contact is Nancy',
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
                                                            'type' => IndentationNode::class,
                                                            'hash' => 3551679428,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::INDENTATION,
                                                                    'text' => '    ',
                                                                ],
                                                            ],
                                                            'children' => [],
                                                        ],
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 838369140,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'Billsmer @ 338-4338.',
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
