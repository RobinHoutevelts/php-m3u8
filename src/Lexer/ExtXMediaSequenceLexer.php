<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXMediaSequenceLexer implements LexerInterface
{
    public function lex($line, array &$tokens)
    {
        if (preg_match('/^#EXT-X-MEDIA-SEQUENCE:(\d+)/', $line, $matches)) {
            $tokens['mediaSequence'] = (int) $matches[1];

            return true;
        }
    }
}
