<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'literal',
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
        'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
        'text' => '|',
    ],
    [
        'type' => TokenType::INDENTATION_INDICATOR,
        'text' => '2',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::LITERAL_BLOCK_SCALAR,
        'text' => "  value\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'folded',
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
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!foo',
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
        'type' => TokenType::INDENTATION_INDICATOR,
        'text' => '1',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::FOLDED_BLOCK_SCALAR,
        'text' => " value\n",
    ],
];
