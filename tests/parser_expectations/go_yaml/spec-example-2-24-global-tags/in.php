<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\AliasNode;
use Aeliot\YamlToken\Node\AnchorNode;
use Aeliot\YamlToken\Node\BlockMappingNode;
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
use Aeliot\YamlToken\Node\ScalarNode;
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
    'hash' => 717927157,
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
            'hash' => 3293149520,
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
                    'hash' => 821266807,
                    'properties' => [
                        'nodeProperties' => [
                            'type' => NodePropertiesNode::class,
                            'hash' => 1769926137,
                        ],
                        'payload' => [
                            'type' => BlockSequenceNode::class,
                            'hash' => 419137630,
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
                            'hash' => 419137630,
                            'properties' => [
                                'entries' => [
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'hash' => 941354599,
                                    ],
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'hash' => 3642043383,
                                    ],
                                    [
                                        'type' => SequenceEntryNode::class,
                                        'hash' => 4267938073,
                                    ],
                                ],
                            ],
                            'children' => [
                                [
                                    'type' => SequenceEntryNode::class,
                                    'hash' => 941354599,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 424893130,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 990219541,
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
                                            'hash' => 424893130,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 1438482291,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 2994656245,
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
                                                    'hash' => 2994656245,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 3473370936,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 954225556,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 3473370936,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 1785621168,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 3001797952,
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
                                                                    'hash' => 1785621168,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3314959097,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3314959097,
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
                                                                    'hash' => 3001797952,
                                                                    'properties' => [
                                                                        'nodeProperties' => [
                                                                            'type' => NodePropertiesNode::class,
                                                                            'hash' => 2663847691,
                                                                        ],
                                                                        'payload' => [
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 515894793,
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
                                                                            'hash' => 515894793,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 1367597215,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 1634924370,
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
                                                                                    'hash' => 1367597215,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1189089890,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 1083372688,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1189089890,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 2473075848,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 2473075848,
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
                                                                                            'hash' => 1083372688,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 686990115,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 686990115,
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
                                                                                    'hash' => 1634924370,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1027421789,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 697512757,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1027421789,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 1149936848,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 1149936848,
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
                                                                                            'hash' => 697512757,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 3462772231,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 3462772231,
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
                                                            'hash' => 954225556,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 472096762,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 2388904622,
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
                                                                    'hash' => 472096762,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2022089010,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2022089010,
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
                                                                    'hash' => 2388904622,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2650758766,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2650758766,
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
                                    'type' => SequenceEntryNode::class,
                                    'hash' => 3642043383,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 4193269563,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 990219541,
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
                                            'hash' => 4193269563,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 2839401366,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 3335197336,
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
                                                    'hash' => 3335197336,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 2513550859,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 4149620178,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 2513550859,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2729784649,
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
                                                                    'hash' => 2729784649,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2809750283,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2809750283,
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
                                                            'hash' => 4149620178,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 3405804123,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 3474720007,
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
                                                                    'hash' => 3405804123,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3302478085,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3302478085,
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
                                                                    'hash' => 3474720007,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 2868470461,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => FlowMappingNode::class,
                                                                            'hash' => 2868470461,
                                                                            'properties' => [
                                                                                'entries' => [
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 835736541,
                                                                                    ],
                                                                                    [
                                                                                        'type' => KeyValueCoupleNode::class,
                                                                                        'hash' => 515535564,
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
                                                                                    'hash' => 835736541,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1189089890,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 3930408905,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1189089890,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 2473075848,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 2473075848,
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
                                                                                            'hash' => 3930408905,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 695781494,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 695781494,
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
                                                                                    'hash' => 515535564,
                                                                                    'properties' => [
                                                                                        'key' => [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1027421789,
                                                                                        ],
                                                                                        'valueIndicator' => [
                                                                                            'type' => ValueIndicatorNode::class,
                                                                                            'hash' => 3779730559,
                                                                                        ],
                                                                                        'value' => [
                                                                                            'type' => ValueNode::class,
                                                                                            'hash' => 85728710,
                                                                                        ],
                                                                                    ],
                                                                                    'children' => [
                                                                                        [
                                                                                            'type' => KeyNode::class,
                                                                                            'hash' => 1027421789,
                                                                                            'properties' => [
                                                                                                'name' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 1149936848,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 1149936848,
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
                                                                                            'hash' => 85728710,
                                                                                            'properties' => [
                                                                                                'payload' => [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 2925288359,
                                                                                                ],
                                                                                            ],
                                                                                            'children' => [
                                                                                                [
                                                                                                    'type' => ScalarNode::class,
                                                                                                    'hash' => 2925288359,
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
                                    'type' => SequenceEntryNode::class,
                                    'hash' => 4267938073,
                                    'properties' => [
                                        'value' => [
                                            'type' => ValueNode::class,
                                            'hash' => 2040645778,
                                        ],
                                    ],
                                    'children' => [
                                        [
                                            'type' => SyntaxTokenNode::class,
                                            'hash' => 990219541,
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
                                            'hash' => 2040645778,
                                            'properties' => [
                                                'nodeProperties' => [
                                                    'type' => NodePropertiesNode::class,
                                                    'hash' => 476121429,
                                                ],
                                                'payload' => [
                                                    'type' => BlockMappingNode::class,
                                                    'hash' => 9023295,
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
                                                    'hash' => 9023295,
                                                    'properties' => [
                                                        'entries' => [
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 2513550859,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 1047194616,
                                                            ],
                                                            [
                                                                'type' => KeyValueCoupleNode::class,
                                                                'hash' => 853717252,
                                                            ],
                                                        ],
                                                    ],
                                                    'children' => [
                                                        [
                                                            'type' => KeyValueCoupleNode::class,
                                                            'hash' => 2513550859,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2729784649,
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
                                                                    'hash' => 2729784649,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2809750283,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 2809750283,
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
                                                            'hash' => 1047194616,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 4151421375,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 3321264005,
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
                                                                    'hash' => 4151421375,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3965521038,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 3965521038,
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
                                                                    'hash' => 3321264005,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 1188679105,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 1188679105,
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
                                                            'hash' => 853717252,
                                                            'properties' => [
                                                                'indentation' => [
                                                                    'type' => IndentationNode::class,
                                                                    'hash' => 412793561,
                                                                ],
                                                                'key' => [
                                                                    'type' => KeyNode::class,
                                                                    'hash' => 2039182595,
                                                                ],
                                                                'value' => [
                                                                    'type' => ValueNode::class,
                                                                    'hash' => 1551753230,
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
                                                                    'hash' => 2039182595,
                                                                    'properties' => [
                                                                        'name' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 474157382,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 474157382,
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
                                                                    'hash' => 1551753230,
                                                                    'properties' => [
                                                                        'payload' => [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 109210347,
                                                                        ],
                                                                    ],
                                                                    'children' => [
                                                                        [
                                                                            'type' => ScalarNode::class,
                                                                            'hash' => 109210347,
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
