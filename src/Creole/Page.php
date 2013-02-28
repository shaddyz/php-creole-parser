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
        
        $paragraphTypes = array(
            'PreformattedBlock',
            'BlankParagraph',
            'Heading',
            'HorizontalRule',
            'UnorderedList',
            'OrderedList',
            'Table',
            'TextParagraph',
        );
        
        while ('' != $text) {
        #for ($i = 0; $i < 100; $i++) {
            foreach ($paragraphTypes as $paragraphType) {
                $paragraphType = '\Creole\\' . $paragraphType;
                if (!is_null($paragraph = $paragraphType::consume($text))) {
                    $this->paragraphs[] = $paragraph;
                    $j = 0;
                    while ("\n" == $text[$j]) {
                        $j++;
                    }
                    $text = substr($text, $j);
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
