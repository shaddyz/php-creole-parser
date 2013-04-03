<?php

namespace Creole;

class UnformattedText
{
    protected $text;
    
    public static function consume(&$text)
    {
        $escape = false;
        $textLength = strlen($text);
        for ($i = 0; $i < $textLength; $i++) {
            switch ($text[$i]) {
                case "\n":
                    break 2;
                case '~':
                    if (isset($text[$i + 1]) and "\n" == $text[$i + 1]) {
                        $i++;
                        break 2;
                    }
                    $escape = true;
                    $head = substr($text, 0, $i);
                    $text = $head . substr($text, $i + 1);
                    unset($head);
            }
            if ('http://' == substr($text, $i, 7) or 'ftp://' == substr($text, $i, 6)) {
                for ($j = $i; $j < $textLength; $j++) {
                    if (' ' == $text[$j] or "\t" == $text[$i]) {
                        break;
                    }
                }
                if ('.' == $text[$j - 1] or ',' == $text[$j - 1]) {
                    $j--;
                }
                if ($escape) {
                    $escape = false;
                    $i = $j;
                    continue;
                }
                $link = '[[' . substr($text, $i, $j - $i) . ']]';
                $text = substr($text, 0, $i) . $link . substr($text, $j);
                break;
            }
            switch (substr($text, $i, 2)) {
                case '**':
                case '//':
                case '\\\\':
                case '[[':
                case '{{':
                    if ($escape) {
                        $escape = false;
                        $i++;
                        continue;
                    }
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
