<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => '\'here\'\'s to "quotes"\'',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
