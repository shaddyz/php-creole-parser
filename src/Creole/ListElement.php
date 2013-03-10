<?php

namespace Creole;

class ListElement
{
    protected $textLines = array();
    
    public static function consume(&$text, $markup)
    {
        if (!$textLines = self::consumeTextLines($text, $markup)) {
            return null;
        }
        
        $listElement = new self();
        $listElement->textLines = $textLines;
        return $listElement;
    }
    
    protected static function consumeTextLines(&$text, $markup)
    {
        $textLines = array();
        while (!is_null($textLine = TextLine::consume($text, $markup))) {
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
        $html = '';
        foreach ($this->textLines as $textLine) {
            $html .= $textLine->toHtml();
        }
        return $html;
    }
}
