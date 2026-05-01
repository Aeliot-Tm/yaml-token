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
        'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
        'text' => '>',
    ],
    [
        'type' => TokenType::BLOCK_SCALAR_CHOMPING_INDICATOR,
        'text' => '-',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::FOLDED_BLOCK_SCALAR,
        'text' => '  No trailing newline',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
];
