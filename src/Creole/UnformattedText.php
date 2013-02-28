<?php

namespace Creole;

class UnformattedText
{
    protected $text;
    
    public static function consume(&$text)
    {
        $textLength = strlen($text);
        for ($i = 0; $i < $textLength; $i++) {
            switch ($text[$i]) {
                case "\n":
                    break 2;
                case '~':
                    $i += 2;
                    break 2;
            }
            switch (substr($text, $i, 2)) {
                case '**':
                case '//':
                case '[[':
                case '{{':
                    break 2;
            }
        }
        
        if ($i == 0) {
            return null;
        }
        
        $unformattedText = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $unformattedText;
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
