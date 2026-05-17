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
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => "' 1st non-empty\n\n 2nd non-empty \n 3rd non-empty '",
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
