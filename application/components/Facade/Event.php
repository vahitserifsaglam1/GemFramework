<?php

namespace Gem\Components\Facade;
use Gem\Components\Patterns\Facade;
use Gem\Components\Patterns\Singleton;

class Event extends Facade {

    protected static function getFacadeClass()
    {

        return Singleton::make('Gem\Components\Event');
    }
}
