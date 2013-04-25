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
