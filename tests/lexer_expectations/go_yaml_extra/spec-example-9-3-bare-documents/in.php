<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Bare',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'document',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::DOCUMENT_END,
        'text' => '...',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# No document',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::DOCUMENT_END,
        'text' => '...',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
        'text' => '|',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::LITERAL_BLOCK_SCALAR,
        'text' => "%!PS-Adobe-2.0 # Not the first line\n",
    ],
];
