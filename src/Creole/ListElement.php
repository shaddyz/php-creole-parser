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

class ListElement
{
    protected $textLines = array();
    
    public static function consume(&$text, $markup)
    {
        if (!$textLines = self::consumeTextLines($text, $markup)) {
            return null;
        }
        
        $listElement = new self();
        $listElement->textLines = $textLines;
        return $listElement;
    }
    
    protected static function consumeTextLines(&$text, $markup)
    {
        $textLines = array();
        while (!is_null($textLine = TextLine::consume($text, $markup))) {
            $textLines[] = $textLine;
        }
        
        return $textLines;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->textLines = self::consumeTextLines($text);
        }
    }
    
    public function toHtml()
    {
        $html = '';
        foreach ($this->textLines as $textLine) {
            $html .= $textLine->toHtml();
        }
        return $html;
    }
}
