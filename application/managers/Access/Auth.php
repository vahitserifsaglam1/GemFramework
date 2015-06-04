<?php

namespace Gem\Application\Manager\Access;
use Gem\Components\Helpers\AccessManager\Interfaces\Handle;
use Gem\Components\Helpers\AccessManager\Interfaces\Terminate;
use Gem\Components\Request;
/**
 * 
 * GemFramework accessManager test dosyası
 * 
 */
class Auth implements Handle,  Terminate{
    
    public function handle(Request $request, $next = null, $role = null) {


    
        
    }
    
    public function terminate(Request $request){
        
        echo 'ahanda geldi';
        
    }
    
}
    