<?php

    namespace Gem\Components\Route\Http\Dispatchers;

    use Gem\Components\Support\Accessors;

    /**
     * Class ControllerDispatcher
     * @package Gem\Components\Route\Http\Dispatchers
     */
    class ControllerDispatcher
    {
        protected $content;
        use Accessors;

        /**
         * @param null $controller
         * @param array $params
         */
        public function __construct($controller = null, array $params = [])
        {

            if (is_string($controller)) {
                list($controller, $method) = $this->parseControllerString($controller);

                $controller = "Gem\\Controllers\\" . $controller;
                $controller = new $controller();
            } else {
                $method = "handle";
            }

            $this->setContent(call_user_func_array([$controller, $method], $params));
        }

        /**
         * Veriyi :: ile parçalar
         *
         * @param string $controller
         * @return array
         */
        private function parseControllerString($controller = '')
        {

            $parse = explode('::', $controller);
            if (count($parse) == 1) {
                $parse[1] = "handle";
            }

            return $parse;
        }
    }

