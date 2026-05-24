<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::WHITESPACE,
        'text' => "\t",
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
        'text' => "\t",
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
