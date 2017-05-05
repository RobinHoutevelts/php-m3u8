<?php

namespace Chrisyue\PhpM3u8\Lexer;

interface LexerInterface
{
    /**
     * @param string $line
     * @param array  &$tokens
     *
     * @return bool success
     */
    public function lex($line, array &$tokens);
}
