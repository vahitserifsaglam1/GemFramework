<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 25.6.2015
 * Time: 20:48
 */

namespace Gem\Components\Facade;
use Gem\Components\Patterns\Facade;

class Cookie extends Facade{

    protected static function getFacadeClass(){

        return "Cookie";

    }

}
