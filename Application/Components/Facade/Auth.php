<?php

    namespace Gem\Components\Facade;

    use Gem\Components\Patterns\Facade;

    class Auth extends Facade
    {

        protected static function getFacadeClass()
        {

            return "Auth";
        }
    }

