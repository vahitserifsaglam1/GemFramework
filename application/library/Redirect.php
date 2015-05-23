<?php
/**
 * 
 *  Bu Dosya GemFramework'un bir dosyasıdır,
 * 
 *  İstenildiği gibi alınıp kullanılabilir.
 *  
 *  @package Gem\Components
 *  @author  vahitserifsaglam <vahit.serif119@gmail.com>
 *  @copyright (c)  GemFramework, vahit serif saglam
 *  
 * 
 */

namespace Gem\Components;

use Gem\Components\Redirect\Factory;
class Redirect extends Factory
{
    /**
     * 
     * Yönlendirme işlemi yapar
     * @param string $adress
     * @param integer $time
     */
    
    public function to($adress, $time = null)
    {
        
        if($time === null)
        {
            
            static::location($adress);
            
        }else{
            
            static::refresh($adress, $time);
            
        }
        
    }
    
    
}