<?php

    namespace Gem\Components\Helpers\Access\Interfaces;

    use Gem\Components\Http\Request;

    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    interface Terminate
    {

        public function terminate(Request $request);
    }
