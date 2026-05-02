<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DIRECTIVE,
        'text' => '%YAM 1.1',
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
];
