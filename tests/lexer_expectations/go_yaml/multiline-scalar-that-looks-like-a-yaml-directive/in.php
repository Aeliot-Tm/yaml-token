<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::DOCUMENT_START,
        'text' => '---',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'scalar',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::DIRECTIVE_YAML_INDICATOR,
        'text' => '%YAML',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::DIRECTIVE_YAML_VERSION,
        'text' => '1.2',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
