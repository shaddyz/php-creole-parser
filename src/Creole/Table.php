<?php

namespace Creole;

class Table
{
    protected $tableRows = array();
    
    public static function consume(&$text)
    {
        if (!$tableRows = self::consumeTableRows($text)) {
            return null;
        }
        
        $table = new self();
        $table->tableRows = $tableRows;
        return $table;
    }
    
    protected static function consumeTableRows(&$text)
    {
        $tableRows = array();
        while (!is_null($tableRow = TableRow::consume($text))) {
            $tableRows[] = $tableRow;
        }
        
        return $tableRows;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->tableRows = self::consumeTableRows($text);
        }
    }
    
    public function toHtml()
    {
        $html = '<table>';
        foreach ($this->tableRows as $tableRow) {
            $html .= $tableRow->toHtml();
        }
        return $html . '</table>' . "\n";
    }
}
