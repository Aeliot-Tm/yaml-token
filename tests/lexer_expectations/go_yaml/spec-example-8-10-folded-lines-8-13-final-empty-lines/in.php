<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::FOLDED_BLOCK_SCALAR_INDICATOR,
        'text' => '>',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::FOLDED_BLOCK_SCALAR,
        'text' => "\n folded\n line\n\n next\n line\n   * bullet\n\n   * list\n   * lines\n\n last\n line\n\n",
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
