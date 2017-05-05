<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8;

use Chrisyue\PhpM3u8\Lexer;
use Chrisyue\PhpM3u8\Loader\LoaderInterface;
use Chrisyue\PhpM3u8\M3u8\M3u8;
use Chrisyue\PhpM3u8\M3u8\MediaSegment;
use Chrisyue\PhpM3u8\M3u8\Playlist;

class Parser
{
    private $loader;
    private $lexers;

    public function __construct()
    {
        $this->lexers = array(
            new Lexer\ExtXVersionLexer(),
            new Lexer\ExtXTargetDurationLexer(),
            new Lexer\ExtXDiscontinuitySequenceLexer(),
            new Lexer\ExtXMediaSequenceLexer(),
            new Lexer\ExtXDiscontinuityLexer(),
            new Lexer\ExtXByteRangeLexer(),
            new Lexer\ExtInfLexer(),
            new Lexer\MediaSegmentUriLexer(),
            new Lexer\ExtXEndlistLexer(),
        );
    }

    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    public function parseFromUri($uri)
    {
        if (null === $this->loader) {
            throw new \BadMethodCallException('You should set an m3u8 loader first');
        }

        return $this->parse($this->loader->load($uri));
    }

    public function parse($content)
    {
        $tokens = $this->lex($content);

        if (!isset($tokens['version'])) {
            $tokens['version'] = 3;
        }

        if (!isset($tokens['mediaSequence'])) {
            $tokens['mediaSequence'] = 0;
        }

        if (!isset($tokens['discontinuitySequence'])) {
            $tokens['discontinuitySequence'] = null;
        }

        if (!isset($tokens['isEndless'])) {
            $tokens['isEndless'] = true;
        }

        $mediaSegments = array();
        foreach ($tokens['playlist'] as $index => $row) {
            $mediaSegment = new MediaSegment(
                $row['uri'],
                $row['duration'],
                $tokens['mediaSequence'] + $index,
                !empty($row['isDiscontinuity']),
                empty($row['title']) ? null : $row['title'],
                empty($row['byteRange']) ? null : $row['byteRange']
            );
            $mediaSegments[] = $mediaSegment;
        }
        $playlist = new Playlist($mediaSegments, $tokens['isEndless']);

        return new M3u8($playlist, $tokens['version'], $tokens['targetDuration'], $tokens['discontinuitySequence']);
    }

    private function lex($content)
    {
        $tokens = array();

        $mediaSequence = 0;

        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            $line = trim($line);

            foreach ($this->lexers as $lexer) {
                if ($lexer->lex($line, $tokens)) {
                    continue 2;
                }
            }
        }

        return $tokens;
    }
}
