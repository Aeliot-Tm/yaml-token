<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'root',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENT,
        'text' => '  ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'tagged',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENT,
        'text' => '    ',
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!localTag',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'child',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENT,
        'text' => '      ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'next',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENT,
        'text' => '        ',
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
        'text' => 'a',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENT,
        'text' => '        ',
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
        'text' => 'b',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
