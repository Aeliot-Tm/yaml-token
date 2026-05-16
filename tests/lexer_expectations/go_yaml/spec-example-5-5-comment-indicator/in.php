<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::COMMENT,
        'text' => '# Comment only.',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
