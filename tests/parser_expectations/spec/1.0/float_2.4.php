<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
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
    'hash' => 1208238485,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3422674779,
            'properties' => [],
            'children' => [
                [
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 3889844391,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 1253468283,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 941032218,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 1253468283,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2984777658,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2984777658,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'canonical',
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
                            'hash' => 941032218,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2750222834,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2750222834,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '1.23015e+3',
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
                    'hash' => 1709403063,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 4244267984,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3426882254,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 4244267984,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 554753560,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 554753560,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'exponential',
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
                            'hash' => 3426882254,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 1152284743,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 1152284743,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '12.3015e+02',
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
                    'hash' => 1419411036,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 3032219797,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 972837612,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 3032219797,
                            'properties' => [
                                'name' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 2232785721,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 2232785721,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'fixed',
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
                            'hash' => 972837612,
                            'properties' => [
                                'scalar' => [
                                    'type' => ScalarNode::class,
                                    'hash' => 4185121692,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => ScalarNode::class,
                                    'hash' => 4185121692,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => '1230.15',
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
