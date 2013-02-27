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
