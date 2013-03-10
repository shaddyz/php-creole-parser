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
        
        $textLength = strlen($text);
        $end = $textLength;
        for ($i = 4; $i < $textLength - 4; $i++) {
            if ("\n}}}" == substr($text, $i, 4)) {
                $end = $i + 4;
                break;
            }
        }
        
        $preformattedBlock = new self(substr($text, 0, $end));
        $text = substr($text, $end);
        return $preformattedBlock;
    }
    
    public function __construct($text)
    {
        if ("{{{\n" == substr($text, 0, 4)) {
            $text = substr($text, 4);
        }
        if ("\n}}}" == substr($text, -4, 4)) {
            $text = substr($text, 0, strlen($text) - 4);
        }
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return '<pre>' . $this->text . '</pre>';
    }
}
