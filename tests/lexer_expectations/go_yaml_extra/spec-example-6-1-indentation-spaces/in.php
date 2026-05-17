<?php

declare(strict_types=1);

use Aeliot\YamlToken\Enum\TokenType;

return [
    [
        'type' => TokenType::INDENTATION,
        'text' => '  ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# Leading comment line spaces are',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => '   ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# neither content nor indentation.',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '    ',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Not indented',
    ],
    [
        'type' => TokenType::VALUE_INDICATOR,
        'text' => ':',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'By one space',
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
        'type' => TokenType::LITERAL_BLOCK_SCALAR_INDICATOR,
        'text' => '|',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::LITERAL_BLOCK_SCALAR,
        'text' => "    By four\n      spaces\n",
    ],
    [
        'type' => TokenType::INDENTATION,
        'text' => ' ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Flow style',
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
        'type' => TokenType::FLOW_SEQUENCE_START,
        'text' => '[',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '    ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# Leading spaces',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '   ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'By two',
    ],
    [
        'type' => TokenType::FLOW_ENTRY,
        'text' => ',',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '        ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# in flow style',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '  ',
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Also by two',
    ],
    [
        'type' => TokenType::FLOW_ENTRY,
        'text' => ',',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '    ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# are neither',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '  ',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => "\t",
    ],
    [
        'type' => TokenType::PLAIN_SCALAR,
        'text' => 'Still by two',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '   ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# content nor',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '    ',
    ],
    [
        'type' => TokenType::FLOW_SEQUENCE_END,
        'text' => ']',
    ],
    [
        'type' => TokenType::WHITESPACE,
        'text' => '             ',
    ],
    [
        'type' => TokenType::COMMENT,
        'text' => '# indentation.',
    ],
    [
        'type' => TokenType::NEWLINE,
        'text' => "\n",
    ],
];
