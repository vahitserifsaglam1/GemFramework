<?php

namespace Gem\Components\Facade;
use Gem\Components\Patterns\Facade;


class Event extends Facade {

    protected static function getFacadeClass()
    {

        return 'Event';
    }
}
