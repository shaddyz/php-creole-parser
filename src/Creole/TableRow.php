<?php

namespace Creole;

class TableRow
{
    protected $tableCells = array();
    
    public static function consume(&$text)
    {
        if (!$tableCells = self::consumeTableCells($text)) {
            return null;
        }
        
        // consume trailing newline at end of row
        if (isset($text[0]) and "\n" == $text[0]) {
            $text = substr($text, 1);
        }
        
        $tableRow = new self();
        $tableRow->tableCells = $tableCells;
        return $tableRow;
    }
    
    protected static function consumeTableCells(&$text)
    {
        $tableCells = array();
        while (!is_null($tableCell = TableCell::consume($text))) {
            $tableCells[] = $tableCell;
        }
        return $tableCells;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->tableCells = self::consumeTableCells($text);
        }
    }
    
    public function toHtml()
    {
        $html = '<tr>' . "\n";
        foreach ($this->tableCells as $tableCell) {
            $html .= $tableCell->toHtml();
        }
        return $html . '</tr>' . "\n";
    }
}
