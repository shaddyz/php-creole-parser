<?php

namespace Creole;

class TableCell
{
    protected $text;
    
    public static function consume(&$text)
    {
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            switch ($text[$i]) {
                case ' ':
                case "\t":
                    continue 2;
                case '|':
                    break 2;
                default:
                    return null;
            }
        }
        
        for ($i++; $i < $textLength; $i++) {
            switch ($text[$i]) {
                case "\n";
                case '|';
                    break 2;
                case '~';
                    if (isset($text[$i + 1]) and '|' == $text[$i + 1]) {
                        $i++;
                    }
            }
        }
        
        $tableCell = new TableCell(substr($text, 0, $i));
        $text = substr($text, $i);
        return $tableCell;
    }
    
    public function __construct($text)
    {
        $this->text = $text;
    }
    
    public function toHtml()
    {
        $html = '<td>';
        /*
        foreach ($this->textElements as $textElement) {
            $html .= $textElement->toHtml();
        }*/
        $html .= $this->text;
        return $html . '</td>' . "\n";
    }
}
