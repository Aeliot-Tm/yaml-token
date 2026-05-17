<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\SingleQuotedScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 2423389310,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 2234544925,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 486073759,
                    'properties' => [
                        'payload' => [
                            'type' => SingleQuotedScalarNode::class,
                            'hash' => 3336523389,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SingleQuotedScalarNode::class,
                            'hash' => 3336523389,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SINGLE_QUOTED_SCALAR,
                                    'text' => '\'here\'\'s to "quotes"\'',
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
    ],
];
