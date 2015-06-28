<?php

/**
 * Bu sınıf GemFramework'de rötalama işlemi'ni yapan ana sınıftır
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 *
 */
namespace Gem\Components\Route;
use Gem\Components\Patterns\Singleton;
use Gem\Components\Helpers\Server;
use Gem\Components\Helpers\String\Parser;
use Gem\Components\Helpers\String\Builder;
use Exception;
/**
 * Class Router
 * @package Gem\Components\Route
 */

class Router {

    use Server, Parser, Builder;
    /**
     * Rötalama koleksiyonları'nın tutalacağı yer
     * @var RouteListener $listener
     */
    private $listener;
    private $basePath;
    private  $routes;
    private $collector;
    public function __construct()
    {
        $this->listener = Singleton::make('Gem\Components\Route\RouteListener');
        $this->basePath = $this->findBasePath();
        $this->routes = $this->listener->getRoutes();
        $this->collector = Singleton::make('Gem\Components\Route\RouteCollector');
    }

    /**
     * Koleksiyonları Döndürür
     * @return array
     */
    public function getCollections()
    {

        return $this->collector->getCollections();

    }

    public function getFilter($name = '')
    {
        return $this->collector->filter[$name];
    }

    /**
     * Regex i döndürür
     * @return mixed
     */
    private function getRegex($url)
    {

        return preg_replace_callback("/:(\w+)/", [$this, 'substituteFilter'], $url);
    }

    /**
     *
     * @param array $matches
     * @return string
     */
    private function substituteFilter(array $matches = [])
    {

        return isset($this->collector->filter[$matches[1]]) ? "({$this->getFilter($matches[1])})" : "([\w-%]+)";
    }

    public function run()
    {
        $collections = $this->getCollections();
        $url = $this->getUrl();
        if(isset($collections[$this->getMethod()]))
        {

            if(count($collections)>0)
            {

                foreach($collections as $collection)
                {

                    $regex = $this->getRegex($collection['action']);
                    if ($regex !== '') {
                        if (!preg_match("@^" . $regex . "*$@i", $url, $matches)) {
                            continue;
                        }
                    }
                    $get = $this->routeGenerateParams($url, $collection['action']);
                    $argument_keys = $get['args'];
                    $params = $get['params'];
                    
                    if ($url == '/') {
                        $url = '';
                    }
                    $url = $this->basePath . $url;


                    if ($this->routeGenareteNewUrl($argument_keys,
                        $params,
                        $url,
                        $this->basePath . $collection['action']))
                    {


                        if(isset($this->routes[$collection['callback']]))
                        {
                            $router = $this->routes[$collection['callback']];
                            $router = new $router();
                            $router->setParams($params);
                            $router->handle();

                        }else{
                            throw new Exception(sprintf('%s adında bir router kayıtlı değil', $collection['callback']));
                        }

                    }

                }

            }

        }else{

            //

        }

    }

}