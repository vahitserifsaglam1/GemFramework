<?php



    namespace Gem\Components\Helpers\Access\Interfaces;

    use Gem\Components\Http\Request;

    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    interface Handle
    {

        public function handle(Request $request, callable $next = null, $role = null);
    }
