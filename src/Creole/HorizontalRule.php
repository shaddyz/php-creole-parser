<?php

namespace Creole;

class HorizontalRule
{
    public static function consume(&$text)
    {
        $trimmedText = ltrim($text);
        if (substr($trimmedText, 0, 4) != '----') {
            return null;
        }
        
        $text = $trimmedText;
        unset($trimmedText);
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            if ($text[$i] == "\n") {
                break;
            }
        }
        
        $horizontalRule = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $horizontalRule;
    }
    
    public function __construct($text = null)
    {
        unset($text);
    }
    
    public function toHtml()
    {
        return '<hr/>';
    }
}
