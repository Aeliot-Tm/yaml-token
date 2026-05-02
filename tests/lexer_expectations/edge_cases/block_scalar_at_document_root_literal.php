<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
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
        'text' => "  root line 1\n  root line 2\n",
    ],
];
