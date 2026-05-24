<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::TAG,
        'text' => '!',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
