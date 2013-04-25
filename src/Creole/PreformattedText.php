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

class PreformattedText
{
    protected $text;
    
    public static function consume(&$text)
    {
        if ('{{{' != substr($text, 0, 3)) {
            return null;
        }
        
        $textLength = strlen($text);
        $end = $textLength;
        for ($i = 3; $i < $textLength - 3; $i++) {
            if ('}}}' == substr($text, $i, 3)) {
                $end = $i + 3;
                break;
            }
        }
        
        $preformattedText = new self(substr($text, 0, $end));
        $text = substr($text, $end);
        return $preformattedText;
    }
    
    public function __construct($text)
    {
        if ('{{{' == substr($text, 0, 3)) {
            $text = substr($text, 3);
        }
        if ('}}}' == substr($text, -3, 3)) {
            $text = substr($text, 0, strlen($text) - 3);
        }
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return htmlspecialchars($this->text);
    }
}
