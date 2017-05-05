<?php

namespace Chrisyue\PhpM3u8\Lexer;

class MediaSegmentUriLexer extends AbstractMediaSegmentTagLexer
{
    public function lexLine($line)
    {
        if (preg_match('/^[^#]+/', $line, $matches)) {
            return array('uri' => $matches[0]);
        }
    }
}
