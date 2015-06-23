<?php

namespace Gem\Application\Manager\Access;
use Gem\Components\Helpers\Access\Interfaces\HandleInterface;
use Gem\Components\Helpers\Access\Interfaces\TerminateInterface;
use Gem\Components\Request;
/**
 * 
 * GemFramework accessManager test dosyası
 * 
 */
class Auth implements HandleInterface{
    
    public function handle(Request $request, $next = null, $role = null) {

        $user = $request->user();
        if(!$user->hasRole('read')){

            echo 'yok';

        }
        
    }
}
