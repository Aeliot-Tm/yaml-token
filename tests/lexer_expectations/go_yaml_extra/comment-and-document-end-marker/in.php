<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::COMMENT,
        'text' => '# comment',
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
];
