<?php

namespace Gem\Components\Helpers\AccessManager\Interfaces;
use Gem\Components\Request;
/**
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 */
interface Terminate {
    
    public function terminate(Request $request);
    
}
