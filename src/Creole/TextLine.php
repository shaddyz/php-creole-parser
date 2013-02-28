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
        if (TextParagraph::isParagraphBreak(substr($text, 0, 4))) {
            return array();
        }
        
        $textElementTypes = array(
            'UnformattedText',
            'BoldText',
            'ItalicText',
            'Link',
            //'Image',
            'PreformattedText',
        );
        
        $textElements = array();
        do {
            foreach ($textElementTypes as $textElementType) {
                $textElementType = '\Creole\\' . $textElementType;
                if (!is_null($textElement = $textElementType::consume($text))) {
                    $textElements[] = $textElement;
                    break;
                }
            }
        } while (!is_null($textElement));
        
        if ("\n" == $text[0] and !TextParagraph::isParagraphBreak(substr($text, 0, 4))) {
            $textElements[] = new UnformattedText(' ');
            $text = substr($text, 1);
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
