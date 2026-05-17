<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
use Aeliot\YamlToken\Node\BlockSequenceEntryNode;
use Aeliot\YamlToken\Node\BlockSequenceNode;
use Aeliot\YamlToken\Node\CommentNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\DocumentStartNode;
use Aeliot\YamlToken\Node\FlowMappingNode;
use Aeliot\YamlToken\Node\IndentationNode;
use Aeliot\YamlToken\Node\KeyNode;
use Aeliot\YamlToken\Node\KeyValueCoupleNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\NodePropertiesNode;
use Aeliot\YamlToken\Node\PlainScalarNode;
use Aeliot\YamlToken\Node\SequenceEntryNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\SyntaxTokenNode;
use Aeliot\YamlToken\Node\TagDirectiveHandleNode;
use Aeliot\YamlToken\Node\TagDirectiveIndicatorNode;
use Aeliot\YamlToken\Node\TagDirectiveNode;
use Aeliot\YamlToken\Node\TagDirectivePrefixNode;
use Aeliot\YamlToken\Node\TagNode;
use Aeliot\YamlToken\Node\ValueIndicatorNode;
use Aeliot\YamlToken\Node\ValueNode;
use Aeliot\YamlToken\Node\WhitespaceNode;

return [
    'type' => StreamNode::class,
    'hash' => 550240943,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1434383718,
            'properties' => [],
            'children' => [
                [
                    'type' => TagDirectiveNode::class,
                    'hash' => 3124558415,
                    'properties' => [],
                    'children' => [
                        [
                            'type' => TagDirectiveIndicatorNode::class,
                            'hash' => 4058827745,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DIRECTIVE_TAG_INDICATOR,
                                    'text' => '%TAG',
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
                            'type' => TagDirectiveHandleNode::class,
                            'hash' => 1410370065,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DIRECTIVE_TAG_HANDLE,
                                    'text' => '!',
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
                            'type' => TagDirectivePrefixNode::class,
                            'hash' => 827166049,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DIRECTIVE_TAG_PREFIX,
                                    'text' => 'tag:clarkevans.com,2002:',
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
            ],
        ],
        [
            'type' => DocumentNode::class,
            'hash' => 3551918906,
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
                    'hash' => 2723110634,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1769926137,
                        ],
                        'payload' => [
                            'type' => BlockSequenceNode::class,
                            'hash' => 2886884672,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1769926137,
                            'properties' => [
                                'tag' => [
                                    'type' => TagNode::class,
                                    'hash' => 2287827780,
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => TagNode::class,
                                    'hash' => 2287827780,
                                    'properties' => [
                                        'token' => [
                                            'type' => TokenType::TAG,
                                            'text' => '!shape',
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
                            'type' => CommentNode::class,
                            'hash' => 779113289,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::COMMENT,
                                    'text' => '# Use the ! handle for presenting',
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
                            'type' => CommentNode::class,
                            'hash' => 2028883852,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::COMMENT,
                                    'text' => '# tag:clarkevans.com,2002:circle',
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
                            'type' => BlockSequenceNode::class,
                            'hash' => 2886884672,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => BlockSequenceEntryNode::class,
                                        'hash' => 2396065567,
                                    ],
                                    [
                                        'type' => BlockSequenceEntryNode::class,
                                        'hash' => 4180734560,
                                    ],
                                    [
                                        'type' => BlockSequenceEntryNode::class,
                                        'hash' => 2923509847,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => BlockSequenceEntryNode::class,
                                    'hash' => 2396065567,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2916998414,
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
                                            'hash' => 2916998414,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 1438482291,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 2203291283,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 1438482291,
                                                    'properties' => [
                                                        'tag' => [
                                                            'type' => TagNode::class,
                                                            'hash' => 2350586866,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => TagNode::class,
                                                            'hash' => 2350586866,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::TAG,
                                                                    'text' => '!circle',
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
                                                    'hash' => 2203291283,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 2731296017,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 1426610959,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 2731296017,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 3378824049,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1318774334,
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
                                                                    'hash' => 3378824049,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2874745588,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2874745588,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'center',
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
                                                                    'hash' => 1318774334,
                                                                    'properties' => [
                                                                        'nodeProperties' => [
                                                                            'type' => NodePropertiesNode::class,
                                                                            'hash' => 2663847691,
                                                                        ],
                                                                        'payload' => [
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 772598852,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => NodePropertiesNode::class,
                                                                            'hash' => 2663847691,
                                                                            'properties' => [
                                                                                'anchor' => [
                                                                                    'type' => AnchorNode::class,
                                                                                    'hash' => 583173515,
                                                                                ],
                                                                            ],
                                                                            'children' => [
                                                                                [
                                                                                    'type' => AnchorNode::class,
                                                                                    'hash' => 583173515,
                                                                                    'properties' => [
                                                                                        'name' => 'ORIGIN',
                                                                                        'token' => [
                                                                                            'type' => TokenType::ANCHOR,
                                                                                            'text' => '&ORIGIN',
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
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 772598852,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 3816735287,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 4193533053,
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
                                                                                    'hash' => 3816735287,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3361970071,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 3498701865,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3361970071,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 999351585,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 999351585,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'x',
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
                                                                                            'hash' => 3498701865,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2270183598,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2270183598,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '73',
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
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 4193533053,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 976627838,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 3522470658,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 976627838,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3966920057,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3966920057,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'y',
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
                                                                                            'hash' => 3522470658,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1573120889,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1573120889,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '129',
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
                                                            'hash' => 1426610959,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 3181237864,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 955597095,
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
                                                                    'hash' => 3181237864,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 373932351,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 373932351,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'radius',
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
                                                                    'hash' => 955597095,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 889692103,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 889692103,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => '7',
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
                                        ],
                                    ],
                                ],
                                [
                                    'type' => BlockSequenceEntryNode::class,
                                    'hash' => 4180734560,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 952120010,
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
                                            'hash' => 952120010,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 2839401366,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 2656821516,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 2839401366,
                                                    'properties' => [
                                                        'tag' => [
                                                            'type' => TagNode::class,
                                                            'hash' => 427279997,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => TagNode::class,
                                                            'hash' => 427279997,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::TAG,
                                                                    'text' => '!line',
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
                                                    'hash' => 2656821516,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 809442758,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 1522936903,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 809442758,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 910241414,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1502788877,
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
                                                                    'hash' => 910241414,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 52398492,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 52398492,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'start',
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
                                                                    'hash' => 1502788877,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => AliasNode::class,
                                                                            'hash' => 3541741332,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => AliasNode::class,
                                                                            'hash' => 3541741332,
                                                                            'properties' => [
                                                                                'name' => 'ORIGIN',
                                                                                'anchorName' => 'ORIGIN',
                                                                                'token' => [
                                                                                    'type' => TokenType::ALIAS,
                                                                                    'text' => '*ORIGIN',
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
                                                            'hash' => 1522936903,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 1647731707,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1006805091,
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
                                                                    'hash' => 1647731707,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2853744904,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2853744904,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'finish',
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
                                                                    'hash' => 1006805091,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 2902185314,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 2902185314,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 1574577337,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 574600857,
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
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 1574577337,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3361970071,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 477050185,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 3361970071,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 999351585,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 999351585,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'x',
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
                                                                                            'hash' => 477050185,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2262445051,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 2262445051,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '89',
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
                                                                                    'type' => KeyValueCoupleNode::class,
                                                                                    'hash' => 574600857,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 976627838,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 4095464643,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 976627838,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3966920057,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 3966920057,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => 'y',
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
                                                                                            'hash' => 4095464643,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1039795929,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => PlainScalarNode::class,
                                                                                                    'hash' => 1039795929,
                                                                                                    'properties' => [
                                                                                                        'token' => [
                                                                                                            'type' => TokenType::PLAIN_SCALAR,
                                                                                                            'text' => '102',
                                                                                                        ],
                                                                                                    ],
                                                                                                    'children' => [],
                                                                                                ],
                                                                                            ],
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
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                                [
                                    'type' => BlockSequenceEntryNode::class,
                                    'hash' => 2923509847,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 577414099,
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
                                            'hash' => 577414099,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 476121429,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 2503482376,
                                                ],
                                            ],
                                            'children' => [
                                                [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 476121429,
                                                    'properties' => [
                                                        'tag' => [
                                                            'type' => TagNode::class,
                                                            'hash' => 1062535236,
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => TagNode::class,
                                                            'hash' => 1062535236,
                                                            'properties' => [
                                                                'token' => [
                                                                    'type' => TokenType::TAG,
                                                                    'text' => '!label',
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
                                                    'hash' => 2503482376,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 809442758,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 2140228184,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 670063484,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 809442758,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 910241414,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1502788877,
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
                                                                    'hash' => 910241414,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 52398492,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 52398492,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'start',
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
                                                                    'hash' => 1502788877,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => AliasNode::class,
                                                                            'hash' => 3541741332,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => AliasNode::class,
                                                                            'hash' => 3541741332,
                                                                            'properties' => [
                                                                                'name' => 'ORIGIN',
                                                                                'anchorName' => 'ORIGIN',
                                                                                'token' => [
                                                                                    'type' => TokenType::ALIAS,
                                                                                    'text' => '*ORIGIN',
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
                                                            'hash' => 2140228184,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 363544481,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1543802865,
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
                                                                    'hash' => 363544481,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 1211885081,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 1211885081,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'color',
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
                                                                    'hash' => 1543802865,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 3200629787,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 3200629787,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => '0xFFEEBB',
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
                                                            'hash' => 670063484,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 557960817,
                                                                ],
                                                                'valueIndicator' => [
                                                                    'type' => ValueIndicatorNode::class,
                                                                    'hash' => 3779730559,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 105549724,
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
                                                                    'hash' => 557960817,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2876107552,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 2876107552,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'text',
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
                                                                    'hash' => 105549724,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 767367002,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => PlainScalarNode::class,
                                                                            'hash' => 767367002,
                                                                            'properties' => [
                                                                                'token' => [
                                                                                    'type' => TokenType::PLAIN_SCALAR,
                                                                                    'text' => 'Pretty vector drawing.',
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
