<?php


namespace Gem\Components\Mail\Content;
use Gem\Components\Mail\Content\Manager;

/**
 *  belirli bir metin için kullanılır
 *  @package Gem\Components\Mail\Content
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
class File implements Manager{
   
    private $content;


    public function __construct($content = '') {
        
        $this->content = $content;
    }
    
    public function getContent()
    {
        
        return $this->content;
        
    }
    
    public function setContent($content)
    {
        
        $this->content = $content;
        return $this;
        
    }

}
