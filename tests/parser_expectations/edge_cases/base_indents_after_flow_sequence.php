<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowSequenceEndNode;
use Aeliot\YamlToken\Node\FlowSequenceNode;
use Aeliot\YamlToken\Node\FlowSequenceStartNode;
use Aeliot\YamlToken\Node\IndentationNode;
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
    'hash' => 2013432487,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1441735494,
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
                    'hash' => 3721800213,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# Minimal excerpt reproducing issue \'unexpected indentation\' after the bumped token FLOW_SEQUENCE_START',
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
                    'hash' => 2338576679,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# (two-space indent). YamlToken Parser throws:',
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
                    'hash' => 2798903171,
                    'properties' => [
                        'token' => [
                            'type' => TokenType::COMMENT,
                            'text' => '# IndentationInvalidException (Unexpected indentation 2 while base indentation is 6).',
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
                    'type' => KeyValueCoupleNode::class,
                    'hash' => 1692217348,
                    'properties' => [
                        'key' => [
                            'type' => KeyNode::class,
                            'hash' => 307232827,
                        ],
                        'valueIndicator' => [
                            'type' => ValueIndicatorNode::class,
                            'hash' => 3779730559,
                        ],
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 3776617752,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => KeyNode::class,
                            'hash' => 307232827,
                            'properties' => [
                                'name' => [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 422097949,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => PlainScalarNode::class,
                                    'hash' => 422097949,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::PLAIN_SCALAR,
                                            'text' => 'root',
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
                            'hash' => 3776617752,
                            'properties' => [
                                'payload' => [
                                    'type' => BlockMappingNode::class,
                                    'hash' => 4278170133,
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
                                    'hash' => 4278170133,
                                    'properties' => [
                                        'entries' => [
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 78555101,
                                            ],
                                            [
                                                'type' => KeyValueCoupleNode::class,
                                                'hash' => 3864939291,
                                            ],
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => KeyValueCoupleNode::class,
                                            'hash' => 78555101,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 135724065,
                                                ],
                                                'valueIndicator' => [
                                                    'type' => ValueIndicatorNode::class,
                                                    'hash' => 3779730559,
                                                ],
                                                'value' => [
                                                    'type' => ValueNode::class,
                                                    'hash' => 3156425878,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENTATION,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 135724065,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 1230125826,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 1230125826,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'level1A',
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
                                                    'hash' => 3156425878,
                                                    'properties' => [
                                                        'payload' => [
                                                            'type' => BlockMappingNode::class,
                                                            'hash' => 79344449,
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
                                                            'hash' => 79344449,
                                                            'properties' => [
                                                                'entries' => [
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 2996401265,
                                                                    ],
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 2402312996,
                                                                    ],
                                                                    [
                                                                        'type' => KeyValueCoupleNode::class,
                                                                        'hash' => 2515573653,
                                                                    ],
                                                                ],
                                                            ],
                                                            'children' => [
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 2996401265,
                                                                    'properties' => [
                                                                        'indentation' => [
                                                                            'type' => IndentationNode::class,
                                                                            'hash' => 3551679428,
                                                                        ],
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 1438563461,
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
                                                                            'hash' => 1438563461,
                                                                            'properties' => [
                                                                                'name' => [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 3875239624,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 3875239624,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'level2A',
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
                                                                    'hash' => 2402312996,
                                                                    'properties' => [
                                                                        'indentation' => [
                                                                            'type' => IndentationNode::class,
                                                                            'hash' => 3551679428,
                                                                        ],
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 517950390,
                                                                        ],
                                                                        'valueIndicator' => [
                                                                            'type' => ValueIndicatorNode::class,
                                                                            'hash' => 3779730559,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 2830684381,
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
                                                                            'hash' => 517950390,
                                                                            'properties' => [
                                                                                'name' => [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 1072076587,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 1072076587,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'thisValueRestartsBaseIndentation',
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
                                                                            'hash' => 2830684381,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => FlowSequenceNode::class,
                                                                                    'hash' => 1556164462,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => FlowSequenceNode::class,
                                                                                    'hash' => 1556164462,
                                                                                    'properties' => [
                                                                                        'entries' => [
                                                                                            [
                                                                                                'type' => ValueNode::class,
                                                                                                'hash' => 2159477566,
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
                                                                [
                                                                    'type' => KeyValueCoupleNode::class,
                                                                    'hash' => 2515573653,
                                                                    'properties' => [
                                                                        'indentation' => [
                                                                            'type' => IndentationNode::class,
                                                                            'hash' => 3551679428,
                                                                        ],
                                                                        'key' => [
                                                                            'type' => KeyNode::class,
                                                                            'hash' => 3638377783,
                                                                        ],
                                                                        'valueIndicator' => [
                                                                            'type' => ValueIndicatorNode::class,
                                                                            'hash' => 3779730559,
                                                                        ],
                                                                        'value' => [
                                                                            'type' => ValueNode::class,
                                                                            'hash' => 1859686227,
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
                                                                            'hash' => 3638377783,
                                                                            'properties' => [
                                                                                'name' => [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 1169027169,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => PlainScalarNode::class,
                                                                                    'hash' => 1169027169,
                                                                                    'properties' => [
                                                                                        'token' => [
                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                            'text' => 'level2B',
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
                                                                            'hash' => 1859686227,
                                                                            'properties' => [
                                                                                'payload' => [
                                                                                    'type' => BlockMappingNode::class,
                                                                                    'hash' => 4099929985,
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
                                                                                    'hash' => 4099929985,
                                                                                    'properties' => [
                                                                                        'entries' => [
                                                                                            [
                                                                                                'type' => KeyValueCoupleNode::class,
                                                                                                'hash' => 3830901308,
                                                                                            ],
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyValueCoupleNode::class,
                                                                                            'hash' => 3830901308,
                                                                                            'properties' => [
                                                                                                'indentation' => [
                                                                                                    'type' => IndentationNode::class,
                                                                                                    'hash' => 4110986796,
                                                                                                ],
                                                                                                'key' => [
                                                                                                    'type' => KeyNode::class,
                                                                                                    'hash' => 4034141911,
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
                                                                                                    'hash' => 4034141911,
                                                                                                    'properties' => [
                                                                                                        'name' => [
                                                                                                            'type' => PlainScalarNode::class,
                                                                                                            'hash' => 2208058766,
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [
                                                                                                        [
                                                                                                            'type' => PlainScalarNode::class,
                                                                                                            'hash' => 2208058766,
                                                                                                            'properties' => [
                                                                                                                'token' => [
                                                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                                                    'text' => 'level3A',
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
                                            'hash' => 3864939291,
                                            'properties' => [
                                                'indentation' => [
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                ],
                                                'key' => [
                                                    'type' => KeyNode::class,
                                                    'hash' => 794622268,
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
                                                    'type' => IndentationNode::class,
                                                    'hash' => 412793561,
                                                    'properties' => [
                                                        'token' => [
                                                            'type' => TokenType::INDENTATION,
                                                            'text' => '  ',
                                                        ],
                                                    ],
                                                    'children' => [],
                                                ],
                                                [
                                                    'type' => KeyNode::class,
                                                    'hash' => 794622268,
                                                    'properties' => [
                                                        'name' => [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3926179243,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => PlainScalarNode::class,
                                                            'hash' => 3926179243,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                    'text' => 'level1B',
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
