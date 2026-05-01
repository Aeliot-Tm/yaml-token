<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"implicit block key"',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => '  ',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"implicit flow key"',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'value',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
];
