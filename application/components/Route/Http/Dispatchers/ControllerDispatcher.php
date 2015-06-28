<?php

/**
 *
 * Controller'i yürüyür.
 *
 */
namespace Gem\Components\Route\Http\Dispatchers;
use Gem\Components\Route\Http\Dispatchers\GeneralDispatcher;
class ControllerDispatcher extends GeneralDispatcher
{

    public function __construct($controller = null, array $params = [])
    {

        parent::__construct();
        if (is_string($controller)) {
            list($controller, $method) = $this->parseControllerString($controller);

            $controller = "Gem\\Controllers\\" . $controller;
            $controller = new $controller();
        } else {
            $method = "handle";
        }

        $params[] = $this->getResponse();

        $this->setContent(call_user_func_array([$controller, $method], $params));

    }

    private function parseControllerString($controller = '')
    {

        $parse = explode('::', $controller);
        if (count($parse) == 1) {
            $parse[1] = "handle";
        }

        return $parse;

    }

}
