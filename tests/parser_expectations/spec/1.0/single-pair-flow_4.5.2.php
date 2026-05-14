<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
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
    'hash' => 1649395623,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2606810198,
            'properties' => [],
            'children' => [
                [
                    'type' => FlowSequenceNode::class,
                    'hash' => 2733872480,
                    'properties' => [
                        'entries' => [
                            [
                                'type' => ValueNode::class,
                                'hash' => 1833005997,
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
                            'hash' => 1833005997,
                            'properties' => [
                                'keyValueCouple' => [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 2891372943,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 2891372943,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 2394387173,
                                        ],
                                        'mappingValueIndicator' => [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 675194587,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 605329290,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 2394387173,
                                            'properties' => [
                                                'name' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 3095314157,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 3095314157,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'foo',
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
                                            'hash' => 605329290,
                                            'properties' => [
                                                'scalar' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 2534824452,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 2534824452,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'bar',
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
                            'hash' => 2678523598,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FLOW_SEQUENCE_END,
                                    'text' => ']',
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
];
