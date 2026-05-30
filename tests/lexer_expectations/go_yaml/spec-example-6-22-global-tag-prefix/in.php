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
        'text' => '!e!',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_PREFIX,
        'text' => 'tag:example.com,2000:app/',
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
        'type' => TokenType::SEQUENCE_ENTRY,
        'text' => '-',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!e!foo',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"bar"',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
