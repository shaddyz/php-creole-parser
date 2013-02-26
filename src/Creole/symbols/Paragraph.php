<?php

namespace Creole\Symbol;

class Paragraph
{
    public static function consume(&$text)
    {
        NoWikiBlock::consume($text);
        if ('{{{' == substr($text, 0, 3)) {
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
