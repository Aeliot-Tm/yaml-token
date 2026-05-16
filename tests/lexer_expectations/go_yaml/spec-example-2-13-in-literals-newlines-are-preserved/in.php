<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::COMMENT,
        'text' => '# ASCII Art',
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
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
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
        'text' => "  \\//||\\/||\n  // ||  ||__\n",
    ],
];
