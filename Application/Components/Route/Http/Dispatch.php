<?php

    namespace Gem\Components\Route\Http;

    use Exception;
    use Gem\Components\Helpers\Access\Interfaces\Handle;
    use Gem\Components\Helpers\Access\Interfaces\Terminate;
    use Gem\Components\Http\Request;
    use Gem\Components\Http\Response\ShouldBeResponse;
    use Gem\Components\Route\Http\Dispatchers\CallableDispatcher;
    use Gem\Components\Route\Http\Dispatchers\ControllerDispatcher;
    use Gem\Components\View\ShouldBeView;

    class Dispatch
    {

        private $dispatchController;
        private $dispatchCallable;
        private $method = null;

        private $before = null;
        private $access = null;
        private $params = null;
        private $next = null;
        private $role = null;

        const CONTROLLER_METHOD = 1;
        const CALLABLE_METHOD = 2;

        protected function setRouteControllerForDispatch($controller = null)
        {
            $this->method = self::CONTROLLER_METHOD;
            $this->dispatchController = $controller;
        }

        /**
         * Route olayında bir callable çağırmak istiyorsanız bunu kullanırsınız
         *
         * @param null $callable
         * @return $this
         */
        protected function setRouteCallableForDispatch($callable = null)
        {

            $this->method = self::CALLABLE_METHOD;
            $this->dispatchCallable = $callable;
        }

        /**
         * @param callable $next
         * @return $this
         */
        protected function setNext(callable $next = null)
        {

            $this->next = $next;

            return $this;
        }

        /**
         * Before ataması yapar
         *
         * @param callable $before
         * @return $this
         */
        public function setBefore(callable $before = null)
        {
            $this->before = $before;
            return $this;
        }

        /**
         * Access Yöneticisini atar.
         *
         * @param HandleInterface $handler
         * @return $this
         */
        public function setAccess(Handle $handler = null)
        {

            $this->access = $handler;

            return $this;
        }

        public function setParams(array $params = [])
        {

            $this->params = $params;

            return $this;
        }

        /**
         * Çıktıyı oluşturur
         *
         * @throws Exception
         */
        public function dispatch()
        {

            $controller = $this->dispatchController;
            $callable = $this->dispatchCallable;
            if (is_null($controller) && is_null($callable)) {

                throw new Exception('Herhangi bir Controller veya Callable methodu atamadınız');
            }

            $method = $this->method;

            if ($this->beforeChecker() && $this->accessChecker()) {

                switch ($method) {

                    case self::CALLABLE_METHOD:
                        $this->response($this->callableDispatcher());
                        break;
                    case self::CONTROLLER_METHOD:
                        $this->response($this->controllerDispatcher());
                        break;
                    default:
                        throw new Exception('Geçersiz bir yapı girdiniz');
                        break;
                }
            }
        }

        public function getParams()
        {

            return $this->params;
        }

        /**
         * @param null $role
         * @return $this
         */

        protected function setRole($role = null)
        {
            $this->role = $role;

            return $this;
        }

        /**
         * Çağrılabilir fonksiyonu çalıştırır
         *
         * @return mixed
         */
        private function callableDispatcher()
        {

            return (new CallableDispatcher($this->dispatchCallable, $this->getParams()))->getContent();
        }

        private function controllerDispatcher()
        {

            return (new ControllerDispatcher($this->dispatchController, $this->getParams()))->getContent();
        }

        private function response($response = '')
        {

            // eğer düz bir metinse
            if (is_string($response)) {
                $response = response($response);
            }
            // eğer view objesi döndüyse response e döndür
            if ($response instanceof ShouldBeView) {
                $response = response($response->execute());
            }
            // response içeriğini yazdır
            if ($response instanceof ShouldBeResponse) {
                $response->execute();
            }
        }

        /**
         * giriş yetkisinin olup olmadığını kontrol ediyoruz
         * @return bool
         */
        private function accessChecker()
        {

            $access = $this->access;
            if (null === $access) {
                return true;
            }
            $next = $this->next;
            $request = new Request();
            $role = $this->role;
            $handle = call_user_func_array([$access, 'handle'], [$request, $next, $role]);
            if ($handle) {
                return true;
            } else {

                if ($access instanceof Terminate) {
                    call_user_func_array([$access, 'terminate'], [$request]);
                }
            }
        }

        /**
         * Before olayını test eder
         *
         * @return bool
         */
        private function beforeChecker()
        {

            if (null === $this->before) {
                return true;
            }
            if (call_user_func_array($this->before, $this->getParams())) {
                return true;
            }
        }
    }
