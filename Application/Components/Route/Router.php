<?php

    /**
     * Bu sınıf GemFramework'de rötalama işlemi'ni yapan ana sınıftır
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Route;

    use Gem\Components\Http\Request;
    use Gem\Components\Helpers\Server;
    use Gem\Components\Patterns\Singleton;
    use Exception;
    use Gem\Components\Redirect;
    use Gem\Components\Route\Http\ControllerManager;
    use Gem\Components\Route\Http\Dispatch;
    use Gem\Components\Helpers\Config;

    /**
     * Class Router
     *
     * @package Gem\Components\Route
     */
    class Router
    {

        use Server, Config;
        /**
         * Rötalama koleksiyonları'nın tutalacağı yer
         *
         * @var RouteListener $listener
         */
        private $listener;
        private $basePath;
        private $routes;
        private $collector;
        private $filter;
        private $configs;

        public function __construct()
        {
            $this->listener = Singleton::make('Gem\Components\Route\RouteListener');
            $this->basePath = $this->findBasePath();
            $this->routes = $this->listener->getRoutes();
            $this->collector = Singleton::make('Gem\Components\Route\RouteCollector');
            $this->filter = $this->collector->getFilter();
            $this->configs = $this->getConfig('general')['route'];
        }

        /**
         * Koleksiyonları Döndürür
         *
         * @return array
         */
        public function getCollections()
        {

            return $this->collector->getCollections();
        }


        public function getFilter($name = '')
        {
            return $this->filter[$name];
        }

        /**
         * Regex i döndürür
         *
         * @return mixed
         */
        private function getRegex($url)
        {

            return preg_replace_callback("/:(\w+)/", [$this, 'substituteFilter'], $url);
        }

        /**
         * @param array $matches
         * @return string
         */
        private function substituteFilter(array $matches = [])
        {

            return isset($this->collector->filter[$matches[1]]) ? "({$this->getFilter($matches[1])})" : "([\w-%]+)";
        }

        /**
         * Rötaları Yürütür
         *
         * @return bool
         */
        public function run()
        {

            $collections = $this->getCollections();
            $method = $this->getMethod();
            if (isset($collections[$method])) {
                $collections = $collections[$method];
            } else {
                return false;
            }

            $run = $this->runCollections($collections);
            if ($run !== true) {
                $url = $this->configs['miss'];

                if (is_string($url)) {
                    $url = substr($url, 1, strlen($url));
                    Redirect::to($url);
                } elseif (is_callable($url)) {
                    $url(new Request());
                }

            }
        }

        /**
         * Koleksiyonları Parçalar
         *
         * @param array $collections
         * @return void
         */
        private function runCollections(array $collections = [])
        {
            foreach ($collections as $col) {
                $delimeter = $this->configs['delimiter'];
                $action = str_replace($delimeter, " ", $col['action']);
                $url = str_replace($delimeter, " ", $this->getUrl());
                $regex = $this->regexChecker($action, $url);
                if (false === $regex) {
                    continue;
                }
                $this->runRouter($col['callback'], $regex);
                return true;
            }
        }

        /**
         * @param string $action
         * @param string $url
         * @return mixed
         */
        private function regexChecker($action = '', $url = '')
        {

            if ($action === $url) {
                return [];
            }

            $regex = $this->getRegex($action);

            if ($regex !== ' ') {
                if (preg_match("@" . ltrim($regex) . "@si", $url, $matches)) {

                    unset($matches[0]);

                    return $matches;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        /**
         * Rötalandırmanın Sınıfı çağırma ve yürütme kısımlarını yürütür.
         *
         * @param       $callback
         * @param array $params
         * @throws Exception
         */

        private function runRouter($callback, array $params = [])
        {

            $params = array_merge([new Request()], $params);
            if (is_string($callback)) {

                if (isset($this->routes[$callback])) {

                    $router = new $this->routes[$callback]();
                    if (!$router instanceof ShouldBeRoute) {
                        throw new Exception(sprintf('%s rötalandırma sınıfınız ShouldBeRoute e sahip değil',
                            get_class($router)));
                    }

                    $router->setParams($params);
                    $router->handle();
                    $router->dispatch();
                } else {
                    throw new Exception(sprintf('%s adında bir röta bulunamadı.', $callback));
                }
            } else {

                $router = new ControllerManager();
                $router->setParams($params);
                $response = call_user_func($callback, $router);
                if ($response instanceof Dispatch) {
                    $router->dispatch();
                } else {
                    throw new Exception('Çağrılabilir fonksiyondan herhangi bir dönüş yapmadığınız
                yada dönen değer uygun tipte değildi');
                }
            }
        }
    }
