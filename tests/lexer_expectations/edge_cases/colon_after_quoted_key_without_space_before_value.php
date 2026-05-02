<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::FLOW_MAPPING_START,
        'text' => '{',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"double quoted"',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# comment',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '  ',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"bar"',
    ],
    [
        'type' => TokenType::FLOW_ENTRY,
        'text' => ',',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => '\'single quoted\'',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# comment',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '  ',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => '\'bar\'',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::FLOW_MAPPING_END,
        'text' => '}',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
