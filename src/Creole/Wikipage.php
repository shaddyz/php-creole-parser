<?php

namespace Creole\Symbol;

class Wikipage
{
    protected $paragraphs = array();
    
    public function __construct($text)
    {
        // normalize the text
        $text = preg_replace('~^(\xEF\xBB\xBF|\x1A)~', '', $text);
        $text = ltrim($text);
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        
        while ('' != $text) {
            $paragraph = Paragraph::consume($text);
            if (!is_null($paragraph)) {
                $this->paragraphs[] = $paragraph
            }
        }
    }
}
