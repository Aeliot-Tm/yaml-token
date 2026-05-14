<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
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
    'hash' => 3976195407,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1614576750,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3378663703,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3650162701,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1484827340,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3650162701,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 243826210,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 243826210,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'brace',
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
                            'hash' => 1484827340,
                            'properties' => [
                                'flowMapping' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 3994447170,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 3994447170,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1497218408,
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
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 1497218408,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 874425984,
                                                ],
                                                'mappingValueIndicator' => [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 1836325670,
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
                                                    'type' => ValueNode::class,
                                                    'hash' => 1836325670,
                                                    'properties' => [
                                                        'flowMapping' => [
                                                            'type' => FlowMappingNode::class,
                                                            'hash' => 35515058,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => FlowMappingNode::class,
                                                            'hash' => 35515058,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 1588424408,
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
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 1588424408,
                                                                    'properties' => [
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 3626635258,
                                                                        ],
                                                                        'mappingValueIndicator' => [
                                                                            'type' => SyntaxTokenNode::class,
                                                                            'hash' => 675194587,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 3148532560,
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
                                                                            'hash' => 3148532560,
                                                                            'properties' => [
                                                                                'scalar' => [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 2315645,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => ScalarNode::class,
                                                                                    'hash' => 2315645,
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
                                                            ],
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
                ],
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2552097691,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1634715455,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1875494442,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1634715455,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3261914480,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 3261914480,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'bracket',
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
                            'hash' => 1875494442,
                            'properties' => [
                                'flowMapping' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 4231710090,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 4231710090,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 4226570337,
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
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 4226570337,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 874425984,
                                                ],
                                                'mappingValueIndicator' => [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 2707524912,
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
                                                    'type' => ValueNode::class,
                                                    'hash' => 2707524912,
                                                    'properties' => [
                                                        'flowSequence' => [
                                                            'type' => FlowSequenceNode::class,
                                                            'hash' => 4258963218,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => FlowSequenceNode::class,
                                                            'hash' => 4258963218,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => ValueNode::class,
                                                                        'hash' => 3148532560,
                                                                    ],
                                                                    [
                                                                        'type' => ValueNode::class,
                                                                        'hash' => 3649238165,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => SyntaxTokenNode::class,
                                                                    'hash' => 3296102772,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::FLOW_SEQUENCE_START,
                                                                            'text' => '[',
                                                                        ],
                                                                    ],
                                                                    'children' => [],
                                                                ],
                                                                [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 3148532560,
                                                                    'properties' => [
                                                                        'scalar' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2315645,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2315645,
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
                                                                [
                                                                    'type' => SyntaxTokenNode::class,
                                                                    'hash' => 3965909453,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::FLOW_ENTRY,
                                                                            'text' => ',',
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
                                                                    'hash' => 3649238165,
                                                                    'properties' => [
                                                                        'scalar' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2742408148,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2742408148,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => '2',
                                                                                ],
                                                                            ],
                                                                            'children' => [],
                                                                        ],
                                                                    ],
                                                                ],
                                                                [
                                                                    'type' => SyntaxTokenNode::class,
                                                                    'hash' => 2678523598,
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
                ],
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2550123170,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 895475469,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3643463127,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 895475469,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 157107263,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 157107263,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'comma',
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
                            'hash' => 3643463127,
                            'properties' => [
                                'flowMapping' => [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 341057528,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowMappingNode::class,
                                    'hash' => 341057528,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 1704804051,
                                            ],
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3225374673,
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
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 1704804051,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 874425984,
                                                ],
                                                'mappingValueIndicator' => [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 4172322135,
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
                                                    'type' => ValueNode::class,
                                                    'hash' => 4172322135,
                                                    'properties' => [],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 3965909453,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::FLOW_ENTRY,
                                                    'text' => ',',
                                                ],
                                            ],
                                            'children' => [],
                                        ],
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 3225374673,
                                            'properties' => [
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 3626635258,
                                                ],
                                                'mappingValueIndicator' => [
                                                    'type' => SyntaxTokenNode::class,
                                                    'hash' => 675194587,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 3649238165,
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
                                                    'hash' => 3649238165,
                                                    'properties' => [
                                                        'scalar' => [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 2742408148,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => ScalarNode::class,
                                                            'hash' => 2742408148,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => '2',
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
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
