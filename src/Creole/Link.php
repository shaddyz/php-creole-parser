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

class Link
{
    protected $uri;
    protected $description;
    
    public static function consume(&$text)
    {
        if ('[[' != substr($text, 0, 2)) {
            return null;
        }
        
        $textLength = strlen($text);
        for ($i = 2; $i < $textLength; $i++) {
            if (']]' == substr($text, $i, 2)) {
                $i += 2;
                break;
            } elseif ("\n" == $text[$i]) {
                break;
            }
        }
        
        $link = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $link;
    }
    
    public function __construct($text)
    {
        $text = substr($text, 2);
        if (']]' == substr($text, -2)) {
            $text = substr($text, 0, strlen($text) - 2);
        }
        // TODO: add support for wiki and interwiki links!!
        // TODO: add support for bold/italic text or an image in description
        $text = explode('|', $text, 2);
        $this->uri = $text[0];
        $this->description = isset($text[1]) ? $text[1] : $text[0];
    }
    
    public function toHtml()
    {
        return '<a href="' . $this->uri . '">' . $this->description . '</a>';
    }
}
