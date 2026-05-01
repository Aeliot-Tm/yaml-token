<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\BlockScalarChompingIndicatorNode;
use Aeliot\YamlToken\Node\BlockScalarIndicatorNode;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FOLDED_BLOCK_SCALAR,
                                    'text' => '  root line 1
  root line 2
',
                                ],
                            ],
                            'children' => [],
                        ],
                    ],
                    'children' => [
                        [
                            'type' => BlockScalarIndicatorNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
                                    'text' => '>',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => BlockScalarChompingIndicatorNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
                                    'text' => '+',
                                ],
                            ],
                            'children' => [],
                        ],
                        [
                            'type' => NewLineNode::class,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::NEWLINE,
                                    'text' => '
',
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
