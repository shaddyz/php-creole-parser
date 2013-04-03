<?php

namespace Creole;

class TableCell
{
    protected $text;
    protected $isHeader = false;
    
    public static function consume(&$text)
    {
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            switch ($text[$i]) {
                case ' ':
                case "\t":
                    continue 2;
                case '|':
                    $start = $i + 1;
                    break 2;
                default:
                    return null;
            }
        }
        
        $endDelim = true;
        
        for ($i++; $i < $textLength; $i++) {
            switch ($text[$i]) {
                case "\n";
                    $endDelim = false;
                    // no break
                case '|';
                    $end = $i;
                    break 2;
                case '~';
                    if (isset($text[$i + 1]) and '|' == $text[$i + 1]) {
                        $i++;
                    }
            }
        }
        
        if (isset($text[$start]) and '=' == $text[$start]) {
            $header = true;
            $start++;
        } else {
            $header = false;
        }
        
        $tableCellText = trim(substr($text, $start, $end - $start));
        $text = substr($text, $i);
        
        // handles trailing |
        if (!$endDelim and !$tableCellText) {
            return null;
        }
        
        $tableCell = new TableCell($tableCellText, $header);
        return $tableCell;
    }
    
    public function __construct($text, $header = false)
    {
        $this->text = trim($text);
        $this->isHeader = (boolean) $header;
    }
    
    public function toHtml()
    {
        $html = $this->isHeader ? '<th>' : '<td>';
        /*
        foreach ($this->textElements as $textElement) {
            $html .= $textElement->toHtml();
        }*/
        $html .= $this->text;
        return $html . ($this->isHeader ? '</th>' : '</td>') . "\n";
    }
}
