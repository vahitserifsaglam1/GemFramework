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
class Auth implements Handle{
    
    public function handle(Request $request, $next = null, $role = null) {

        $user = $request->user();
        if(!$user->hasRole('read')){

            echo 'yok';

        }

        
    }

    
}
    