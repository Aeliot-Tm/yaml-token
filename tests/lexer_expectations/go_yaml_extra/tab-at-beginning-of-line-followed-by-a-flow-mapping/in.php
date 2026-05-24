<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::WHITESPACE,
        'text' => "\t",
    ],
    [
        'type' => TokenType::FLOW_MAPPING_START,
        'text' => '{',
    ],
    [
        'type' => TokenType::FLOW_MAPPING_END,
        'text' => '}',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
