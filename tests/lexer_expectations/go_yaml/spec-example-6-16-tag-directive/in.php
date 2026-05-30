<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::TAG_DIRECTIVE,
        'text' => '%TAG',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_HANDLE,
        'text' => '!yaml!',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_PREFIX,
        'text' => 'tag:yaml.org,2002:',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::DOCUMENT_START,
        'text' => '---',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!yaml!str',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"foo"',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
