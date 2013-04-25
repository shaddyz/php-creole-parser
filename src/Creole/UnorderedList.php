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

class UnorderedList
{
    protected $level;
    protected $listElements = array();
    protected $htmlTag = 'ul';
    
    public static function consume(&$text)
    {
        if ($listElements = self::consumeListElements($text, '*')) {
            $list = new UnorderedList();
            $list->listElements = $listElements;
            return $list;
        }
        if ($listElements = self::consumeListElements($text, '#')) {
            $list = new OrderedList();
            $list->listElements = $listElements;
            return $list;
        }
        return null;
    }
    
    protected static function consumeListElements(&$text, $markup)
    {
        $listElements = array();
        $first = true;
        $textLength = strlen($text);
        
        do {
            $level = 1;
            for ($i = 0; $i < $textLength; $i++) {
                switch ($text[$i]) {
                    case $markup:
                        if ($first) {
                            if ($markup == $text[$i + 1]) {
                                return $listElements;
                            } else {
                                $first = false;
                            }
                        }
                        $i++;
                        while ($markup == $text[$i++]) {
                            $level++;
                        }
                        break 2;
                    case ' ':
                    case "\t":
                        break;
                    default:
                        return $listElements;
                }
            }
            
            $text = substr($text, $i);
            if (is_null($listElement = ListElement::consume($text, $markup))) {
                print $i . ' ' . $textLength . "\n";
                $listElement = new Blank();
            }
            if ("\n" == $text[0]) {
                $text = substr($text, 1);
            }
            $listElement->level = $level;
            $listElements[] = $listElement;
            $textLength = strlen($text);
        } while ($textLength);
        
        return $listElements;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->listElements = self::consumeListElements($text);
        }
    }
    
    public function toHtml()
    {
        return $this->getListHtml($this->listElements);
    }
    
    protected function getListHtml($elements)
    {
        if (!$elements) {
            return '';
        }
        
        $html = '<' . $this->htmlTag . '>' . "\n" . '<li>' . $elements[0]->toHtml();
        $level = $elements[0]->level;
        $elementCount = count($elements);
        
        for ($i = 1; $i < $elementCount; $i++) {
            if ($elements[$i]->level > $level) {
                $sublevel = $elements[$i]->level;
                $subelements = array($elements[$i]);
                for ($i++; $i < $elementCount and $sublevel <= $elements[$i]->level; $i++) {
                    $subelements[] = $elements[$i];
                }
                $html .= "\n" . $this->getListHtml($subelements);
            } else {
                $html .= '</li>' . "\n" . '<li>' . $elements[$i]->toHtml();
            }
        }
        
        return $html .= '</li>' . "\n" . '</' . $this->htmlTag . '>' . "\n";
    }
}
