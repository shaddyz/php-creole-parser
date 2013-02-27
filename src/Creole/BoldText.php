<?php

namespace Creole;

class BoldText extends FormattedText
{
    public static function consume(&$text)
    {
        if ('**' != substr($text, 0, 2)) {
            return null;
        }
        
        $textLength = strlen($text);
        for ($i = 2; $i < $textLength; $i++) {
            if ('**' == substr($text, 0, 2)) {
                $i++;
                break;
            } elseif ('~**' == substr($text, 0, 3)) {
                $i += 2;
            }
        }
        
        $boldText = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $boldText;
    }
    
    public function __construct($text)
    {
        $text = substr($text, 2);
        if ('**' == substr($text, -2)) {
            $text = substr($text, 0, strlen($text) - 2);
        }
        
        $this->consumeTextElements($text);
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
