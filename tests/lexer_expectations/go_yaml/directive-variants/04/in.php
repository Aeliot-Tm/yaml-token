<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
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
        'text' => '1.1',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '  ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# comment',
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
