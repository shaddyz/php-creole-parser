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

class HorizontalRule
{
    public static function consume(&$text)
    {
        $trimmedText = ltrim($text);
        if (substr($trimmedText, 0, 4) != '----') {
            return null;
        }
        
        $text = $trimmedText;
        unset($trimmedText);
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            if ($text[$i] == "\n") {
                break;
            }
        }
        
        $horizontalRule = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $horizontalRule;
    }
    
    public function __construct($text = null)
    {
        unset($text);
    }
    
    public function toHtml()
    {
        return '<hr/>';
    }
}
