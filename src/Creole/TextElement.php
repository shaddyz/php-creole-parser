<?php

namespace Creole;

class TextElement
{
    protected $text;
    
    public static function consume(&$text)
    {
        switch ($text[0]) {
            case "\n":
                return null;
                // no break
            case '~':
                // escape sequence
        }
        switch (substr($text, 0, 2)) {
            case '\\\\':
                // forced line break
            case '**':
                // bold
            case '//':
                // italic
            case '[[':
                // link
            case '{{':
                // image or nowiki
            
                
        }
        
        $textLength = strlen($text);
        
        for ($i = 0; $i < $textLength; $i++) {
            if ($text[$i] == "\n") {
                break;
            }
        }
        
        $textElement = new self(substr($text, 0, $i));
        $text = substr($text, $i);
        return $textElement;
    }
    
    public function __construct($text)
    {
        $this->text = $text;
    }
    
    public function toHtml()
    {
        return $this->text;
    }
}
/*
text_unformatted
:
(
~( ITAL
|
STAR
|
LINK_OPEN
|
IMAGE_OPEN
|
NOWIKI_OPEN
|
EXTENSION
|
FORCED_LINEBREAK
|
ESCAPE
|
NEWLINE
|
EOF )
|
forced_linebreak
|
escaped )+
;

link
image
nowiki_inline
*/
