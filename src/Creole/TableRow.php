<?php
/**
 * This file is part of Shaddy Zeineddine's Creole Parser.
 *
 * WerkBox is free software; you can redistribute it and/or modify it under the terms of version 3 of the GNU General
 * Public License as published by the Free Software Foundation.
 *
 * WerkBox is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * @copyright 2012 Shaddy Zeineddine
 * @license http://www.gnu.org/licenses/gpl.txt GPL v3
 * @link https://github.com/shaddyz/php-creole-parser
 */

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
