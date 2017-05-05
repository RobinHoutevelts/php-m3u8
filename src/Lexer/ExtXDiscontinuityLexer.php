<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXDiscontinuityLexer extends AbstractMediaSegmentTagLexer
{
    protected function lexLine($line)
    {
        if (preg_match('/^#EXT-X-DISCONTINUITY/', $line)) {
            return array('isDiscontinuity' => true);
        }
    }
}
