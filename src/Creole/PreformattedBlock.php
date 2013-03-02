<?php

namespace Creole;

class PreformattedBlock
{
    protected $text;
    
    public static function consume(&$text)
    {
        if ("{{{\n" != substr($text, 0, 4)) {
            return null;
        }
        
        $stringLength = strlen($text);
        $start = 4;
        $end = $stringLength;
        for ($i = $start; $i < $stringLength - 4; $i++) {
            if ("\n}}}" == substr($text, $i, 4)) {
                $end = $i + 4;
            }
        }
        $preformattedBlock = new self(substr($text, $start, $end));
        $text = substr($text, $end);
        return $preformattedBlock;
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
