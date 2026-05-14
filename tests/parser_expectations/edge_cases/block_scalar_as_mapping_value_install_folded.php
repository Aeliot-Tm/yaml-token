<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
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
    'hash' => 3861422436,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3370329019,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1935305042,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1061687304,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2006501940,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1061687304,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 474597276,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 474597276,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'install',
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
                            'hash' => 2006501940,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 3215220452,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockScalarIndicatorNode::class,
                                    'hash' => 3228385119,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                            'text' => '>',
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
                                    'type' => ScalarNode::class,
                                    'hash' => 3215220452,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                            'text' => "  echo \"one\"\n  echo \"two\"\n",
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
