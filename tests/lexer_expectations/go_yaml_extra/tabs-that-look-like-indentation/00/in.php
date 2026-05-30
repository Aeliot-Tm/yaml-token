<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'foo',
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
        'text' => ' ',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => "\t",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'bar',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
