<?php

namespace Creole;

class UnorderedList
{
    protected $markup = '*';
    protected $level;
    
    public static function consume(&$text)
    {
    }
    
    public function __construct($text)
    {
        $text = rtrim($text);
        $text = rtrim($text, '=');
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            if ($this->markup == $text[$i]) {
                $this->level++;
            } else {
                $this->text = substr($text, $i);
                break;
            }
        }
    }
    
    public function toHtml()
    {
        return '<h' . $this->level . '>' . $this->text . '</h' . $this->level . '>';
    }
}
