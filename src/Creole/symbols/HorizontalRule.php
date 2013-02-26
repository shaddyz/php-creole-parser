<?php

namespace Creole\Symbol;

class HorizontalRule
{
    public function __construct($text = null)
    {
        unset($text);
    }
    
    public function toHtml()
    {
        return '<hr/>';
    }
}
