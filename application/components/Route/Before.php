<?php
/**
 * Created by PhpStorm.
 * User: vserifsaglam
 * Date: 24.6.2015
 * Time: 17:10
 */

namespace Gem\Components\Route;


class Before {

    private $callback;
    private $params;
    public function __construct(callable $callback = null, array $params = []){

        $this->callback = $callback;
        $this->params = $params;

    }

    public function execute(){

        $response = call_user_func_array($this->callback, $this->params);

        if($response)
            return true;

    }

}
