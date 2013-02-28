<?php

namespace Creole;

class Link
{
    protected $uri;
    protected $description;
    
    public static function consume(&$text)
    {
        if ('[[' != substr($text, 0, 2)) {
            return null;
        }
        
        $textLength = strlen($text);
        for ($i = 2; $i < $textLength; $i++) {
            if (']]' == substr($text, $i, 2)) {
                $i += 2;
                break;
            } elseif ("\n" == $text[$i]) {
                break;
            }
        }
        
        $link = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $link;
    }
    
    public function __construct($text)
    {
        $text = substr($text, 2);
        if (']]' == substr($text, -2)) {
            $text = substr($text, 0, strlen($text) - 2);
        }
        // TODO: add support for wiki and interwiki links!!
        // TODO: add support for bold/italic text or an image in description
        $text = explode('|', $text, 2);
        $this->uri = $text[0];
        $this->description = isset($text[1]) ? $text[1] : $text[0];
    }
    
    public function toHtml()
    {
        return '<a href="' . $this->uri . '">' . $this->description . '</a>';
    }
}
