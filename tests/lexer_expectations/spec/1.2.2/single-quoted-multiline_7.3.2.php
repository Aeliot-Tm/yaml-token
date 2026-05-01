<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'key',
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
        'type' => TokenType::SINGLE_QUOTED_SCALAR,
        'text' => '\' 1st non-empty

 2nd non-empty 3rd non-empty \'',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => '
',
    ],
];
