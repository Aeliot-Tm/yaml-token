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
    'hash' => 3739885182,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1259759367,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 4237312509,
                    'properties' => [
                        'payload' => [
                            'type' => SingleQuotedScalarNode::class,
                            'hash' => 595985064,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => SingleQuotedScalarNode::class,
                            'hash' => 595985064,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::SINGLE_QUOTED_SCALAR,
                                    'text' => "' 1st non-empty\n\n 2nd non-empty \n\t3rd non-empty '",
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
