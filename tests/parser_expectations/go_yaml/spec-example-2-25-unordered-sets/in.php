<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockIndentationNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\ExplicitKeyIndicatorNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 2564941659,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1104706828,
            'properties' => [],
            'children' => [
                [
                    'type' => CommentNode::class,
                    'hash' => 231804378,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# Sets are represented as a',
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
                    'type' => CommentNode::class,
                    'hash' => 3149746668,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# Mapping where each key is',
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
                    'type' => CommentNode::class,
                    'hash' => 720068509,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# associated with a null value',
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
        [
            'type' => DocumentNode::class,
            'hash' => 2190825222,
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
                    'hash' => 810300676,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1464818344,
                        ],
                        'payload' => [
                            'type' => BlockMappingNode::class,
                            'hash' => 1160342309,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1464818344,
                            'properties' => [
                                'tag' => [
                                    'type' => TagPropertyNode::class,
                                    'hash' => 778916065,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagPropertyNode::class,
                                    'hash' => 778916065,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG_PROPERTY,
                                            'text' => '!!set',
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
                            'hash' => 1160342309,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 1275139939,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 4061555495,
                                    ],
                                    [
                                        'type' => KeyValueCoupleNode::class,
                                        'hash' => 3718922122,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => KeyValueCoupleNode::class,
                                    'hash' => 1275139939,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 298891370,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 298891370,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 675266324,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => BlockIndentationNode::class,
                                                    'hash' => 2285796975,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::BLOCK_INDENT,
                                                            'text' => ' ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 675266324,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'Mark McGwire',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
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
                                    'hash' => 4061555495,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 717863661,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 717863661,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 773302588,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => BlockIndentationNode::class,
                                                    'hash' => 2285796975,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::BLOCK_INDENT,
                                                            'text' => ' ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 773302588,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'Sammy Sosa',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
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
                                    'hash' => 3718922122,
                                    'properties' => [
                                        'key' => [
                                            'type' => KeyNode::class,
                                            'hash' => 1144404328,
                                        ],
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyNode::class,
                                            'hash' => 1144404328,
                                            'properties' => [
                                                'explicitKeyIndicatorNode' => [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                ],
                                                'name' => [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2879653380,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => ExplicitKeyIndicatorNode::class,
                                                    'hash' => 3326054058,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::EXPLICIT_KEY_INDICATOR,
                                                            'text' => '?',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => BlockIndentationNode::class,
                                                    'hash' => 2285796975,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::BLOCK_INDENT,
                                                            'text' => ' ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => PlainScalarNode::class,
                                                    'hash' => 2879653380,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::PLAIN_SCALAR,
                                                            'text' => 'Ken Griff',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                            ],
                                        ],
                                        [
                                            'type' => ValueNode::class,
                                            'hash' => 4172322135,
                                            'properties' => [],
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
