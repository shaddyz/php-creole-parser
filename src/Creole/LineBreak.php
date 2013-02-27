<?php

namespace Creole;

class LineBreak
{
    public static function consume(&$text)
    {
        return null;
    }
    
    public function __construct($text = null)
    {
    }
    
    public function toHtml()
    {
        return '<br/>' . "\n";
    }
}
