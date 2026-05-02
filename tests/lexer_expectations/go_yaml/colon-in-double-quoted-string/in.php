<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => '"foo: bar\\": baz"',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
