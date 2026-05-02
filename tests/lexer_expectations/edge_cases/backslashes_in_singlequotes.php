<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => '\'foo: bar\\\'',
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
        'text' => 'baz\'',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
