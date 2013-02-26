<?php

namespace Creole\Symbol;

class Paragraph
{
    public static function consume(&$text)
    {
        $paragraphTypes = array(
            'PreformattedText',
            'BlankParagraph',
            'Heading',
            'HorizontalRule',
            'UnorderedList',
            'OrderedList',
            'Table',
            'TextParagraph',
        );
        
        foreach ($paragraphTypes as $paragraphType) {
            if (!is_null($paragraph = $paragraphType::consume($text))) {
                return $paragraph;
            }
        }
    }
    
    public function __construct($text)
    {
        if ('{{{' == substr($text, 0, 3)) {
            
        }
        
        $text = ltrim($text);
        
        switch ($text[0]) {
            case '=':
                $this->type = new Heading($text);
                break;
            case '*':
                $this->type = new UnorderedList($text);
                break;
            case '#':
                $this->type = new OrderedList($text);
                break;
            case '|':
                $this->type = new Table($text);
                break;
            default:
                if ('----' == substr($text, 0, 4)) {
                    $this->type = new HorizontalRule($text);
                } else {
                    $this->type = new TextParagraph($text);
                }
        }
    }
}
