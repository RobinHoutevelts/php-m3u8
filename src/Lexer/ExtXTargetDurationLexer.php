<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXTargetDurationLexer implements LexerInterface
{
    public function lex($line, array &$tokens)
    {
        if (preg_match('/^#EXT-X-TARGETDURATION:(\d+)/', $line, $matches)) {
            $tokens['targetDuration'] = (int) $matches[1];

            return true;
        }
    }
}
