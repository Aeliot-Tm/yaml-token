<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"foo\\nbar:baz\\tx \\\\$%^&*()x"',
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
        'text' => '23',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => '\'x\\ny:z\\tx $%^&*()x\'',
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
        'text' => '24',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
