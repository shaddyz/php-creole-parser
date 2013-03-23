<?php

namespace Creole;

class TextLine
{
    protected $textElements = array();
    
    public static function consume(&$text, $inList = null)
    {
        if (!$textElements = self::consumeTextElements($text, $inList)) {
            return null;
        }
        
        $textLine = new self();
        $textLine->textElements = $textElements;
        return $textLine;
    }
    
    protected static function consumeTextElements(&$text, $inList = null)
    {
        if (TextParagraph::isParagraphBreak($text)) {
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
        do {
            foreach ($textElementTypes as $textElementType) {
                $textElementType = '\Creole\\' . $textElementType;
                if (!is_null($textElement = $textElementType::consume($text))) {
                    $textElements[] = $textElement;
                    break;
                }
            }
        } while (!is_null($textElement));
        
        if ("\n" == $text[0] and !TextParagraph::isParagraphBreak(substr($text, 1, 4), $inList)) {
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
        $html = '';
        foreach ($this->textElements as $textElement) {
            $html .= $textElement->toHtml();
        }
        return $html;
    }
}
