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

class Heading
{
    protected $level = 0;
    protected $text;
    
    public static function consume(&$text)
    {
        $trimmedText = ltrim($text);
        if (!isset($trimmedText[0]) or $trimmedText[0] != '=') {
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
        
        $heading = new self(substr($text, 0, $i));
        $text = substr($text, $i + 1);
        return $heading;
    }
    
    public function __construct($text)
    {
        $text = rtrim(rtrim($text), '=');
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            if ('=' == $text[$i]) {
                $this->level++;
            } else {
                $this->text = trim(substr($text, $i));
                break;
            }
        }
    }
    
    public function toHtml()
    {
        return '<h' . $this->level . '>' . $this->text . '</h' . $this->level . '>' . "\n";
    }
}
