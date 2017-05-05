<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXVersionLexer implements LexerInterface
{
    public function lex($line, array &$tokens)
    {
        if (preg_match('/^#EXT-X-VERSION:(\d+)/', $line, $matches)) {
            $tokens['version'] = $matches[1];

            return true;
        }
    }
}
