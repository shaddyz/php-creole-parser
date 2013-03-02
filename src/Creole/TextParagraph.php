<?php

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
    
    public static function isParagraphBreak($text)
    {
        $text = ltrim($text, "\t ");
        if ($text === '') {
            return true;
        }
        switch ($text[0]) {
            case '#':
            case '|':
            case '=':
                return true;
                // no break
            case "\n":
                if (isset($text[1]) and "\n" == $text[1]) {
                    return true;
                }
                break;
            case '*':
                if (isset($text[1]) and '*' != $text[1]) {
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
