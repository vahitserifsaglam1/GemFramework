<?php

/**
 * 
 *  Modellerde extends edilecek s�n�f, facede g�revinde kullan�l�r
 *  
 *  @package Gem\Components\Database 
 *  @author vahitserifsaglam <vahit.serif119@gmail.com>
 *  @copyright MyfcYazilim
 * 
 */

namespace Gem\Components\Database;

use Gem\Components\Database\Base;

class Model {

    /**
     *
     * @var Base 
     */
    private $instance;

    /**
     * Static olarak kullanılması için yeni bir base objesi oluşturur
     */
    public function __construct() {

        $this->instance = new Base();
    }

    /**
     * 
     * @param string $name
     * @param array $params
     * @return mixed
     */
    public static function __callStatic($name, $params) {

        $instance = new static();
        return call_user_func_array([$instance->instance, $name], $params);
    }
    
    
    /**
     * 
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function __call($name, $args){
        
        return call_user_func_array([$this->instance, $name], $args);
        
    }

}
