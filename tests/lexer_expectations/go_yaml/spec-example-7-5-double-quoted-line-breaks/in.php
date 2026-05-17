<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOUBLE_QUOTED_SCALAR,
        'text' => "\"folded \nto a space,\t\n \nto a line feed, or \t\\\n \\ \tnon-content\"",
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
