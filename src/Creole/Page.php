<?php

namespace Creole;

class Page
{
    protected $paragraphs = array();
    
    public function __construct($text)
    {
        // normalize the text
        $text = preg_replace('~^(\xEF\xBB\xBF|\x1A)~', '', $text);
        $text = ltrim($text);
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        
        #while ('' != $text) {
        for ($i = 0; $i < 100; $i++) {
            $paragraph = Paragraph::consume($text);
            if (!is_null($paragraph)) {
                $this->paragraphs[] = $paragraph;
                $j = 0;
                while ("\n" == $text[$j]) {
                    $j++;
                }
                $text = substr($text, $j);
                for ($j; $j > 0; $j--) {
                    $this->paragraphs[] = new LineBreak();
                }
            }
        }
    }
    
    public function toHtml()
    {
        $html = '';
        foreach ($this->paragraphs as $paragraph) {
            $html .= $paragraph->toHtml();
        }
        return $html;
    }
}
