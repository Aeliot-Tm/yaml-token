<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::SEQUENCE_ENTRY,
        'text' => '-',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'first',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => '  ',
    ],
    [
        'type' => TokenType::SEQUENCE_ENTRY,
        'text' => '-',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'nested',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
