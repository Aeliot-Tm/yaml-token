<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;
use Aeliot\YamlToken\Node\DocumentNode;
use Aeliot\YamlToken\Node\NewLineNode;
use Aeliot\YamlToken\Node\ScalarNode;
use Aeliot\YamlToken\Node\StreamNode;
use Aeliot\YamlToken\Node\ValueNode;

return [
    'type' => StreamNode::class,
    'hash' => 3528594562,
    'properties' => [],
    'children' => [
        [
            'type' => DocumentNode::class,
            'hash' => 1037025284,
            'properties' => [],
            'children' => [
                [
                    'type' => ValueNode::class,
                    'hash' => 3121574374,
                    'properties' => [
                        'scalar' => [
                            'type' => ScalarNode::class,
                            'hash' => 2107349815,
                        ],
                    ],
                    'children' => [
                        [
                            'type' => ScalarNode::class,
                            'hash' => 2107349815,
                            'properties' => [
                                'token' => [
                                    'type' => TokenType::DOUBLE_QUOTED_SCALAR,
                                    'text' => '"1 inline\\ttab"',
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
