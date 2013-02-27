<?php

namespace Creole;

abstract class FormattedText
{
    protected $textElements;
    
    protected function consumeTextElements(&$text)
    {
        $textElementTypes = array(
            'UnformattedText',
            'BoldText',
            'ItalicText',
            'Link',
        );
        
        $textElements = array();
        while (!is_null($textElement = TextElement::consume($text))) {
            $textElements[] = $textElement;
        }
        
        return $textElements;
    }
}
