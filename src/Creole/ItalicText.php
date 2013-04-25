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

class ItalicText
{
    protected $textElements = array();
    
    public static function consume(&$text)
    {
        if (!$textElements = self::consumeTextElements($text)) {
            return null;
        }
        
        $boldText = new self();
        $boldText->textElements = $textElements;
        return $boldText;
    }
    
    protected static function consumeTextElements(&$text)
    {
        if ('//' != substr($text, 0, 2)) {
            return array();
        }
        
        $text = substr($text, 2);
        $textElementTypes = array(
            'UnformattedText',
            'BoldText',
            'Link',
        );
        
        $textElements = array();
        do {
            foreach ($textElementTypes as $textElementType) {
                $textElementType = '\Creole\\' . $textElementType;
                if (!is_null($textElement = $textElementType::consume($text))) {
                    $textElements[] = $textElement;
                    break;
                }
                if ('//' == substr($text, 0, 2)) {
                    $text = substr($text, 2);
                    break;
                } elseif ("\n" == $text[0]) {
                    if (TextParagraph::isParagraphBreak(substr($text, 1, 4))) {
                        break;
                    }
                    $text = substr($text, 1);
                    $textElement = new UnformattedText(' ');
                    $textElements[] = $textElement;
                    break;
                }
            }
        } while (!is_null($textElement));
        
        return $textElements;
    }
    
    public function __construct($text = null)
    {
        if (!is_null($text)) {
            $this->textElements = $this->consumeTextElements($text);
        }
    }
    
    public function toHtml()
    {
        $html = '<em>';
        foreach ($this->textElements as $textElement) {
            $html .= $textElement->toHtml();
        }
        
        return $html . '</em>';
    }
}
