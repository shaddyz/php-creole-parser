<?php

namespace Creole\Symbol;

class PreformattedText
{
    protected $text;
    
    public static function consume(&$text)
    {
        if ("{{{\n" == substr($text, 0, 4)) {
            $stringLength = strlen($text);
            $start = 4;
            $end = $stringLength;
            for ($i = $start; $i < $stringLength - 4; $i++) {
                if ("\n}}}" == substr($text, $i, 4)) {
                    $end = $i + 4;
                }
            }
            $preformattedText = new self(($text, $start, $end - $start));
            $text = substr($text, $end);
            return $preformattedText;
        }
    }
    
    public function __construct($text)
    {
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return '<pre>' . $this->text . '</pre>';
    }
}
