<?php

namespace Creole;

class PreformattedText
{
    protected $text;
    
    public static function consume(&$text)
    {
        if ('{{{' != substr($text, 0, 3)) {
            return null;
        }
        
        $textLength = strlen($text);
        $end = $textLength;
        for ($i = 3; $i < $textLength - 3; $i++) {
            if ('}}}' == substr($text, $i, 3)) {
                $end = $i + 3;
                break;
            }
        }
        
        $preformattedText = new self(substr($text, 0, $end));
        $text = substr($text, $end);
        return $preformattedText;
    }
    
    public function __construct($text)
    {
        if ('{{{' == substr($text, 0, 3)) {
            $text = substr($text, 3);
        }
        if ('}}}' == substr($text, -3, 3)) {
            $text = substr($text, 0, strlen($text) - 3);
        }
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return htmlspecialchars($this->text);
    }
}
