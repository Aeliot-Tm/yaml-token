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
        'text' => " \n  \n  literal\n   \n  \n  text\n\n",
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => ' ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# Comment',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
