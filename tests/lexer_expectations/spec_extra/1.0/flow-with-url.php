<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'https://simple.uri',
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
        'text' => 'https://with.query?a[]=b&a[]=b',
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
        'text' => 'https://with.anchor?a=b#anc',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
