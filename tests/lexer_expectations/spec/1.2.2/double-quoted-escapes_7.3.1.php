<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'key',
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
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"\\0 \\a \\b \\e \\f \\n \\r \\t \\v \\\\ \\/ \\_ \\N \\L \\P"',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
