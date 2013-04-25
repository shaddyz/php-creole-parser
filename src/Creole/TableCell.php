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

class TableCell
{
    protected $textLine;
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
        $this->textLine = new TextLine($text);
        $this->isHeader = (boolean) $header;
    }
    
    public function toHtml()
    {
        $html = ($this->isHeader ? '<th>' : '<td>') . $this->textLine->toHtml();
        return $html . ($this->isHeader ? '</th>' : '</td>') . "\n";
    }
}
