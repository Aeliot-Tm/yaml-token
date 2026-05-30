<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!set',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
        'text' => '?',
    ],
    [
        'type' => TokenType::BLOCK_INDENT,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Mark McGwire',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
        'text' => '?',
    ],
    [
        'type' => TokenType::BLOCK_INDENT,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Sammy Sosa',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::EXPLICIT_KEY_INDICATOR,
        'text' => '?',
    ],
    [
        'type' => TokenType::BLOCK_INDENT,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Ken Griffey',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
