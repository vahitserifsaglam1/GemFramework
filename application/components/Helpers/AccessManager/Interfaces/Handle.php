<?php



namespace Gem\Components\Helpers\AccessManager\Interfaces;
use Gem\Components\Request;
/**
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
interface Handle{
    
    public function handle(Request $request, $next = null, $role = null);
    
}
