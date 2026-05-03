<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::FLOW_MAPPING_START,
        'text' => '{',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'foo',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'you',
    ],
    [
        'type' => TokenType::FLOW_ENTRY,
        'text' => ',',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'bar',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'far',
    ],
    [
        'type' => TokenType::FLOW_MAPPING_END,
        'text' => '}',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
