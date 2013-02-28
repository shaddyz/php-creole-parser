<?php

namespace Creole;

class Heading
{
    protected $level = 0;
    protected $text;
    
    public static function consume(&$text)
    {
        $trimmedText = ltrim($text);
        if ($trimmedText[0] != '=') {
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
        
        $heading = new self(substr($text, 0, $i));
        $text = substr($text, $i + 1);
        return $heading;
    }
    
    public function __construct($text)
    {
        $text = rtrim(rtrim($text), '=');
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            if ('=' == $text[$i]) {
                $this->level++;
            } else {
                $this->text = trim(substr($text, $i));
                break;
            }
        }
    }
    
    public function toHtml()
    {
        return '<h' . $this->level . '>' . $this->text . '</h' . $this->level . '>' . "\n";
    }
}
