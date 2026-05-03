<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOCUMENT_START,
        'text' => '---',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
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
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'a',
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
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'b',
    ],
    [
        'type' => TokenType::FLOW_ENTRY,
        'text' => ',',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'c',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
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
        'text' => 'd',
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
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'e',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
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
        'text' => '23',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
