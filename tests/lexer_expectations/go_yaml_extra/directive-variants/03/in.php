<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DIRECTIVE_YAML,
        'text' => '%YAML',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => " \t ",
    ],
    [
        'type' => TokenType::DIRECTIVE_YAML_VERSION,
        'text' => '1.1',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::DOCUMENT_START,
        'text' => '---',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
