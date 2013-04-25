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

class TextLine
{
    protected $textElements = array();
    
    public static function consume(&$text, $inList = null)
    {
        if (!$textElements = self::consumeTextElements($text, $inList)) {
            return null;
        }
        
        $textLine = new self();
        $textLine->textElements = $textElements;
        return $textLine;
    }
    
    protected static function consumeTextElements(&$text, $inList = null)
    {
        if (TextParagraph::isParagraphBreak($text)) {
            return array();
        }
        
        $textElementTypes = array(
            'UnformattedText',
            'BoldText',
            'ItalicText',
            'Link',
            'Image',
            'PreformattedText',
            'LineBreak',
        );
        
        $textElements = array();
        do {
            foreach ($textElementTypes as $textElementType) {
                $textElementType = '\Creole\\' . $textElementType;
                if (!is_null($textElement = $textElementType::consume($text))) {
                    $textElements[] = $textElement;
                    break;
                }
            }
        } while (!is_null($textElement));
        
        if ("\n" == $text[0] and !TextParagraph::isParagraphBreak(substr($text, 1, 4), $inList)) {
            $textElements[] = new UnformattedText(' ');
            $text = substr($text, 1);
        }
        
        return $textElements;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->textElements = self::consumeTextElements($text);
        }
    }
    
    public function toHtml()
    {
        $html = '';
        foreach ($this->textElements as $textElement) {
            $html .= $textElement->toHtml();
        }
        return $html;
    }
}
