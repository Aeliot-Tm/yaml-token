# Showing of problematic position

Parser error messages append a human-readable source position (`in line … column …`) so failures point at the right place in the input.

## Behaviour

When the parser throws, the message is passed through `Parser::appendTokenLocation()`.
That helper appends coordinates only when it can resolve both a line and a column.

## Choosing the position source

The second argument of `appendTokenLocation()` is either:

1. **A `Token` instance** — when the call site already holds a non-null reference to the token that explains the error
   (the lexer’s `line` and `column` on that token are used). Prefer this whenever that reference exists,
   so the suffix matches the token described in the message even if the stream cursor has moved.

2. **`TokenStreamProxy` (from `Harvester::$tokens`)** — when there is no safe non-null `Token` to pass
   (for example after `current()` returned `null` at end-of-stream, or when the diagnostic variable is explicitly nullable).
   The proxy exposes `getLine()` / `getColumn()` derived from the last token observed through the proxy’s `current()` and `advance()`
   calls on the underlying `TokenStream`.

Call sites should not add extra null-coalescing logic: if the relevant token might be `null`, pass the proxy directly; otherwise pass the concrete `Token`.

## Implementation notes

- `TokenStreamProxy` wraps the lexer’s `TokenStream` for the parse pass and is constructed in `Parser::parseStream()`.
- `appendTokenLocation(string $message, Token|TokenStreamProxy $tokens)` branches on the type of the second argument and reads line/column accordingly.
