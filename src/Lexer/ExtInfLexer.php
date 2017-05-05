<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtInfLexer extends AbstractMediaSegmentTagLexer
{
    protected function lexLine($line)
    {
        if (preg_match('/^#EXTINF:(.+),(.*)$/', $line, $matches)) {
            $token = array('duration' => $matches[1]);

            if (isset($matches[2])) {
                $token['title'] = $matches[2];
            }

            return $token;
        }
    }
}
