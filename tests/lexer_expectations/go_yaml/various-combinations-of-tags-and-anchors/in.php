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
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a1',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'scalar1',
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
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a2',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'scalar2',
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
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a3',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'scalar3',
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
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a4',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!map',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a5',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'key5',
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
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'value4',
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
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'a6',
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
        'type' => TokenType::PLAIN_SCALAR,
        'text' => '1',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&anchor6',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'b6',
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
        'type' => TokenType::PLAIN_SCALAR,
        'text' => '2',
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
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!map',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a8',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'key8',
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
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'value7',
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
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!map',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a10',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'key10',
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
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'value9',
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
    [
        'type' => TokenType::TAG_PROPERTY,
        'text' => '!!str',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => ' ',
    ],
    [
        'type' => TokenType::ANCHOR_PROPERTY,
        'text' => '&a11',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'value11',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
