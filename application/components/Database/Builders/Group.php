<?php

/**
 *  
 *  GemFramework Group Builder -> group burada oluştururlur
 *  
 *  @package  Gem\Components\Database\Builders;
 *  
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  
 * 
 */

namespace Gem\Components\Database\Builders;

class Group
{
    
    
    public function group($group) {
        
        return "GROUP BY $group";
        
    }
    
    
}