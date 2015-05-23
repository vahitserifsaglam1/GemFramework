<?php

/**
 * 
 *  Modellerde extends edilecek s�n�f, facede g�revinde kullan�l�r
 *  
 *  @package Gem\Components\Database
 *  
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  
 *  @copyright MyfcYazilim
 * 
 */

namespace Gem\Components\Database;

use Gem\Components\Database\Base;

class BaseStatic {

    private $instance;

    public function __construct() {

        $this->instance = new Base();
    }

    public static function __callStatic($name, $params) {

        $instance = new static();

        return call_user_func_array([$instance->instance, $name], $params);
    }

}
