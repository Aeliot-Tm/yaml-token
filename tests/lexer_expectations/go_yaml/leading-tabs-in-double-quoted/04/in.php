<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => "\"5 leading\n    \\\t  tab\"",
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
