<?php
/**
 * This file is part of Shaddy Zeineddine's Creole Parser.
 *
 * WerkBox is free software; you can redistribute it and/or modify it under the terms of version 3 of the GNU General
 * Public License as published by the Free Software Foundation.
 *
 * WerkBox is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @copyright 2012 Shaddy Zeineddine
 * @license http://www.gnu.org/licenses/gpl.txt GPL v3
 * @link https://github.com/shaddyz/php-creole-parser
 */

namespace Creole;

class TextParagraph
{
    protected $textLines = array();
    
    public static function consume(&$text)
    {
        if (!$textLines = self::consumeTextLines($text)) {
            return null;
        }
        
        $textParagraph = new self();
        $textParagraph->textLines = $textLines;
        return $textParagraph;
    }
    
    public static function isParagraphBreak($text, $inList = null)
    {
        $text = ltrim($text, "\t ");
        if ($text === '') {
            return true;
        }
        if (is_null($inList)) {
            $inList = '';
        }
        switch ($text[0]) {
            case '#':
            case '|':
            case '=':
                return true;
                // no break
            case "\n":
                return true;
                break;
            case '*':
                if ('*' == $inList) {
                    return true;
                } elseif (isset($text[1]) and '*' != $text[1]) {
                    return true;
                } else {
                    return false;
                }
                // no break
        }
        if ("{{{\n" == substr($text, 0, 4) or '----' == substr($text, 0, 4)) {
            return true;
        }
        return false;
    }
    
    protected static function consumeTextLines(&$text)
    {
        $textLines = array();
        while (!is_null($textLine = TextLine::consume($text))) {
            $textLines[] = $textLine;
        }
        
        return $textLines;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->textLines = self::consumeTextLines($text);
        }
    }
    
    public function toHtml()
    {
        $text = '<p>';
        foreach ($this->textLines as $textLine) {
            $text .= $textLine->toHtml();
        }
        return $text . '</p>' . "\n";
    }
}
