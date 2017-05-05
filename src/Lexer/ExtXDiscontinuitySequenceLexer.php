<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXDiscontinuitySequenceLexer implements LexerInterface
{
    public function lex($line, array &$tokens)
    {
        if (preg_match('/^#EXT-X-DISCONTINUITY-SEQUENCE:(\d+)/', $line, $matches)) {
            $tokens['discontinuitySequence'] = (int) $matches[1];

            return true;
        }
    }
}
