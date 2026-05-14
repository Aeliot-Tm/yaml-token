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
    'hash' => 3771786806,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1159927193,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 2393113730,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1214589382,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2275982152,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1214589382,
                            'properties' => [
                                'name' => [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 3432914130,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => FlowSequenceNode::class,
                                    'hash' => 3432914130,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => ValueNode::class,
                                                'hash' => 3686031790,
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
                                            'hash' => 3686031790,
                                            'properties' => [
                                                'scalar' => [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 2199425904,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ScalarNode::class,
                                                    'hash' => 2199425904,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'flow',
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
                            'hash' => 2275982152,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 729764549,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 729764549,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'block',
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
