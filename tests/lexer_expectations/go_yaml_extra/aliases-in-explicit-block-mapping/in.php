<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
        'text' => '?',
    ],
    [
        'type' => TokenType::BLOCK_INDENT,
        'text' => ' ',
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'a',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
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
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&b',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'b',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
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
        'type' => TokenType::ALIAS_NODE,
        'text' => '*a',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
