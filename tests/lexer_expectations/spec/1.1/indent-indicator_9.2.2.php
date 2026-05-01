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
        'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
        'text' => '2',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => '    ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Content indented relative to indicator',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
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
        'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
        'text' => '>',
    ],
    [
        'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
        'text' => '1',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'folded',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'combined',
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
        'type' => TokenType::BLOCK_SCALAR_INDENTATION_INDICATOR,
        'text' => '1',
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
        'type' => TokenType::INDENTATION,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'strip',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
];
