<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'hr',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '  ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => '65',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '    ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# Home runs',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'avg',
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
        'text' => '0.278',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# Batting average',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'rbi',
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
        'text' => '147',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '   ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# Runs Batted In',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
