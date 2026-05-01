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
        'text' => 'https://example.com',
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
        'text' => 'omitted value',
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
        'type' => TokenType::FLOW_ENTRY,
        'text' => ',',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
        'text' => '?',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
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
        'text' => 'omitted key',
    ],
    [
        'type' => TokenType::FLOW_MAPPING_END,
        'text' => '}',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
];
