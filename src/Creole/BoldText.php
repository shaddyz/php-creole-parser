<?php

namespace Creole;

class BoldText
{
    protected $textElements = array();
    
    public static function consume(&$text)
    {
        if (!$textElements = self::consumeTextElements($text)) {
            return null;
        }
        
        $boldText = new self();
        $boldText->textElements = $textElements;
        return $boldText;
    }
    
    protected static function consumeTextElements(&$text)
    {
        if ('**' != substr($text, 0, 2)) {
            return array();
        }
        
        $text = substr($text, 2);
        $textElementTypes = array(
            'UnformattedText',
            'ItalicText',
            'Link',
        );
        
        $textElements = array();
        do {
            foreach ($textElementTypes as $textElementType) {
                $textElementType = '\Creole\\' . $textElementType;
                if (!is_null($textElement = $textElementType::consume($text))) {
                    $textElements[] = $textElement;
                    break;
                }
                if ('**' == substr($text, 0, 2)) {
                    $text = substr($text, 2);
                    break;
                } elseif ("\n" == $text[0]) {
                    if (TextParagraph::isParagraphBreak(substr($text, 1, 4))) {
                        break;
                    }
                    $text = substr($text, 1);
                    $textElement = new UnformattedText(' ');
                    $textElements[] = $textElement;
                }
            }
        } while (!is_null($textElement));
        
        return $textElements;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->textElements = $this->consumeTextElements($text);
        }
    }
    
    public function toHtml()
    {
        $html = '<strong>';
        foreach ($this->textElements as $textElement) {
            $html .= $textElement->toHtml();
        }
        
        return $html . '</strong>';
    }
}
