<?php

namespace Chrisyue\PhpM3u8\Lexer;

class ExtXByteRangeLexer extends AbstractMediaSegmentTagLexer
{
    protected function lexLine($line)
    {
        if (preg_match('/^#EXT-X-BYTERANGE:(\d+)(@(\d+))?$/', $line, $matches)) {
            $byteRange = new \SplFixedArray(2);
            $byteRange[0] = (int) $matches[1];

            if (!empty($matches[3])) {
                $byteRange[1] = (int) $matches[3];
            }

            return array('byteRange' => $byteRange);
        }
    }
}
