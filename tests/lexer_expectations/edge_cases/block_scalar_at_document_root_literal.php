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
        'text' => '
',
    ],
    [
        'type' => TokenType::LITERAL_BLOCK_SCALAR,
        'text' => '  root line 1
  root line 2
',
    ],
];
