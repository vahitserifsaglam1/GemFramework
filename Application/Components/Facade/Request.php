<?php
    namespace Gem\Components\Facade;

    use Gem\Components\Patterns\Facade;

    class Request extends Facade
    {
        protected static function getFacadeClass()
        {
            return "Request";
        }
    }
