<?php

namespace Creole;

class TextLine
{
    protected $textElements = array();
    
    public static function consume(&$text)
    {
        if (!$textElements = self::consumeTextElements($text)) {
            return null;
        }
        
        $textLine = new self();
        $textLine->textElements = $textElements;
        return $textLine;
    }
    
    protected static function consumeTextElements(&$text)
    {
        switch ($text[0]) {
            case '*':
                if ($text[1] == '*') {
                    break;
                }
                // no break
            case '#':
            case '=':
            case '|':
            case "\n":
            case '~': // ESCAPE
                return array();
                // no break
        }
        switch (substr($text, 0, 2)) {
            case '//':
            case '[[':
            case '{{':
                return array();
                // no break
        }
        if (substr($text, 0, 4) == '\\\\') {
                return array();
        }
        if (substr($text, 0, 4) == "{{{\n") {
                return array();
        }
        
        $textElementTypes = array(
            'UnformattedText',
            'BoldText',
            'ItalicText',
            'Link',
            'Image',
            'PreformattedText',
        );
        
        $textElements = array();
        while (!is_null($textElement = TextElement::consume($text))) {
            $textElements[] = $textElement;
        }
        
        return $textElements;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->textElements = self::consumeTextElements($text);
        }
    }
    
    public function toHtml()
    {
        $text = '';
        foreach ($this->textElements as $textElement) {
            $text .= $textElement->toHtml();
        }
        return $text;
    }
}
