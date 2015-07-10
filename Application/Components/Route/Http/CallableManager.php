<?php
    /**
     * Created by PhpStorm.
     * User: vserifsaglam
     * Date: 29.6.2015
     * Time: 00:33
     */

    namespace Gem\Components\Route\Http;

    use Exception;

    class CallableManager extends Dispatch
    {

        /**
         * Controller atanmasını engeller
         *
         * @param null $controller
         * @throws Exception
         */
        public function setController($controller = null)
        {
            throw new Exception('%s sınıfından controller ataması yapamassınız', __CLASS__);
        }

        /**
         * Callable atamasını engeller
         *
         * @param callable $callable
         * @return $this
         */
        public function setCallable(callable $callable = null)
        {

            $this->setRouteCallableForDispatch($callable);

            return $this;
        }
    }
