<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 21.6.2015
 * Time: 00:45
 */

namespace Gem\components\Facade;
use Gem\Components\Patterns\Facade;
use Gem\Components\Patterns\Singleton;
class Route extends Facade {

    protected static function getFacadeClass(){
        return 'Route';
    }
}
