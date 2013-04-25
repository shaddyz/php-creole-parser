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

class PreformattedBlock
{
    protected $text;
    
    public static function consume(&$text)
    {
        if ("{{{\n" != substr($text, 0, 4)) {
            return null;
        }
        
        $textLength = strlen($text);
        $end = $textLength;
        for ($i = 4; $i < $textLength - 4; $i++) {
            if ("\n}}}" == substr($text, $i, 4)) {
                $end = $i + 4;
                break;
            }
        }
        
        $preformattedBlock = new self(substr($text, 0, $end));
        $text = substr($text, $end);
        return $preformattedBlock;
    }
    
    public function __construct($text)
    {
        if ("{{{\n" == substr($text, 0, 4)) {
            $text = substr($text, 4);
        }
        if ("\n}}}" == substr($text, -4, 4)) {
            $text = substr($text, 0, strlen($text) - 4);
        }
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return '<pre>' . $this->text . '</pre>';
    }
}
