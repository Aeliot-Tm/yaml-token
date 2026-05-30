<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorPropertyNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DoubleQuotedScalarNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\SingleQuotedScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\TagPropertyNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 4186567107,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 3567331754,
            'properties' => [],
            'children' => [
                [
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 2827893622,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 1593382607,
                        ],
                    ],
                    'children' => [
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
                            'hash' => 1593382607,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3273011123,
                                ],
                                'payload' => [
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 895144465,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3273011123,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 907070353,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 907070353,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG_PROPERTY,
                                                    'text' => '!!str',
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
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 895144465,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                            'text' => '"a"',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 1580694627,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 4032933830,
                        ],
                    ],
                    'children' => [
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
                            'hash' => 4032933830,
                            'properties' => [
                                'payload' => [
                                    'type' => SingleQuotedScalarNode::class,
                                    'hash' => 634006504,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => SingleQuotedScalarNode::class,
                                    'hash' => 634006504,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::SINGLE_QUOTED_SCALAR,
                                            'text' => '\'b\'',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 392615518,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 208931739,
                        ],
                    ],
                    'children' => [
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
                            'hash' => 208931739,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 1796923944,
                                ],
                                'payload' => [
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 3516846956,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 1796923944,
                                    'properties' => [
                                        'anchor' => [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 29328054,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => AnchorPropertyNode::class,
                                            'hash' => 29328054,
                                            'properties' => [
                                                'name' => 'anchor',
                                                'token' => [
                                                    'type' => TokenType::ANCHOR_PROPERTY,
                                                    'text' => '&anchor',
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
                                    'type' => DoubleQuotedScalarNode::class,
                                    'hash' => 3516846956,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                            'text' => '"c"',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 3374614128,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2213935690,
                        ],
                    ],
                    'children' => [
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
                            'hash' => 2213935690,
                            'properties' => [
                                'payload' => [
                                    'type' => AliasNode::class,
                                    'hash' => 3134551282,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => AliasNode::class,
                                    'hash' => 3134551282,
                                    'properties' => [
                                        'name' => 'anchor',
                                        'anchorName' => 'anchor',
                                        'token' => [
                                            'type' => TokenType::ALIAS_NODE,
                                            'text' => '*anchor',
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
                    'type' => BlockSequenceEntryNode::class,
                    'hash' => 3383637218,
                    'properties' => [
                        'value' => [
                            'type' => ValueNode::class,
                            'hash' => 2753806428,
                        ],
                    ],
                    'children' => [
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
                            'hash' => 2753806428,
                            'properties' => [
                                'nodeProperties' => [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3273011123,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => NodePropertiesNode::class,
                                    'hash' => 3273011123,
                                    'properties' => [
                                        'tag' => [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 907070353,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => TagPropertyNode::class,
                                            'hash' => 907070353,
                                            'properties' => [
                                                'token' => [
                                                    'type' => TokenType::TAG_PROPERTY,
                                                    'text' => '!!str',
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
