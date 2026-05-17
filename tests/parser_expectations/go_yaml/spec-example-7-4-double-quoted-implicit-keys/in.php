<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\FlowEntryNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 251549153,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 4121626898,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1548878038,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 919172728,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1399510880,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 919172728,
                            'properties' => [
                                'name' => [
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 1126861821,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 1126861821,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                            'text' => '"implicit block key"',
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
                            'hash' => 1399510880,
                            'properties' => [
                                'payload' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 361676978,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 361676978,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 3342284801,
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
                                            'type' => ValueNode::class,
                                            'hash' => 3342284801,
                                            'properties' => [
                                                'payload' => [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 1490501819,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => KeyValueCoupleNode::class,
                                                    'hash' => 1490501819,
                                                    'properties' => [
                                                        'key' => [
                                                            'type' => KeyNode::class,
                                                            'hash' => 3951171730,
                                                        ],
                                                        'valueIndicator' => [
                                                            'type' => ValueIndicatorNode::class,
                                                            'hash' => 3779730559,
                                                        ],
                                                        'value' => [
                                                            'type' => ValueNode::class,
                                                            'hash' => 2159477566,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyNode::class,
                                                            'hash' => 3951171730,
                                                            'properties' => [
                                                                'name' => [
                                                                    'type' => DoubleQuotedScalarNode::class,
                                                                    'hash' => 4291518267,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => DoubleQuotedScalarNode::class,
                                                                    'hash' => 4291518267,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                                                            'text' => '"implicit flow key"',
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
                                                            'hash' => 2159477566,
                                                            'properties' => [
                                                                'payload' => [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 4152093896,
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => PlainScalarNode::class,
                                                                    'hash' => 4152093896,
                                                                    'properties' => [
                                                                        'token' => [
                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                            'text' => 'value',
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
