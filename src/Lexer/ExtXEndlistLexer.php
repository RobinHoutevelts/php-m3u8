<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXEndlistLexer implements LexerInterface
{
    public function lex($line, array &$tokens)
    {
        if ('#EXT-X-ENDLIST' === $line) {
            $tokens['isEndless'] = false;

            return true;
        }
    }
}
