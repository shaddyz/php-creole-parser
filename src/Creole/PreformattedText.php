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
        
        $stringLength = strlen($text);
        $start = 3;
        $end = $stringLength;
        for ($i = $start; $i < $stringLength - 3; $i++) {
            if ('}}}' == substr($text, $i, 3)) {
                $end = $i + 3;
            }
        }
        $preformattedText = new self(substr($text, $start, $end));
        $text = substr($text, $end);
        return $preformattedText;
    }
    
    public function __construct($text)
    {
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return htmlspecialchars($this->text);
    }
}
