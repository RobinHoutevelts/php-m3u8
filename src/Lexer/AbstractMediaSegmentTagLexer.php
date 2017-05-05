<?php

namespace Chrisyue\PhpM3u8\Lexer;

abstract class AbstractMediaSegmentTagLexer implements LexerInterface
{
    public function lex($line, array &$tokens)
    {
        $token = $this->lexLine($line);
        if (null !== $token) {
            $index = $this->getMediaSegmentIndex($tokens);
            if (!isset($tokens['playlist'][$index])) {
                $tokens['playlist'][$index] = array();
            }

            $tokens['playlist'][$index] += $token;

            return true;
        }
    }

    abstract protected function lexLine($line);

    private function getMediaSegmentIndex(array $tokens)
    {
        $index = isset($tokens['playlist']) ? count($tokens['playlist']) : 0;

        if (isset($tokens['playlist'][$index]['uri'])) {
            ++$index;
        }

        return $index;
    }
}
