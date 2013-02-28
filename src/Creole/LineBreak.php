<?php

namespace Creole;

class LineBreak
{
    public static function consume(&$text)
    {
        if ('\\\\' != substr($text, 0, 2)) {
            return null;
        }
        
        $text = substr($text, 2);
        return new self();
    }
    
    public function __construct($text = null)
    {
    }
    
    public function toHtml()
    {
        return '<br/>' . "\n";
    }
}
