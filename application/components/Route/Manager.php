<?php

/**
 *  Bu sınıf GemFramework'un Route Sınıfı içindir, toplanılan route olayları çağrılır
 *
 * @package Gem\Components
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 *
 */

namespace Gem\Components\Route;

use Gem\Components\Helpers\String\Parser;
use Gem\Components\Helpers\String\Builder;
use Gem\Components\Helpers\Server;
use Gem\Components\Helpers\Config;
use RuntimeException;
use InvalidArgumentException;
use Gem\Components\App;
use BadFunctionCallException;
use Gem\Components\Helpers\Access;
use Gem\Components\Http\Response\ExcutableResponseInterface;
use Gem\Components\Route\Before;
use Gem\Components\Http\Response;


class Manager
{

    use Parser,
        Server,
        Config,
        Builder,
        Access;

    /**
     *
     * @var $collection ,$params,$types
     * @access private
     *
     */
    private $collection = [
    ];
    private $params = [];
    private $filters = [];
    private $basePath = '';
    private $namedRoutes = [];
    private $types = [
        'get', 'delete', 'post', 'put'
    ];
    private $before = [];
    private $group = [];

    public function __construct()
    {

        $this->basePath = $this->findBasePath();

    }

    public function getTypes()
    {

        return $this->types;
    }

    /**
     *
     * @param string $type
     * @param array $args
     * @access public
     */
    public function add($type, $args)
    {

        $add = [
            'action' => ltrim($args[0], '/'),
            'callback' => $args[1]
        ];

        if (is_array($args[1])) {

            if (isset($args[1]['group'])) {

                $group = $args[1]['group'];
                unset($args[1]['group']);
                $add['groupName'] = $group;
            }
        }


        $this->collection[$type][] = $add;
    }

    /**
     * Route verisinin atanmış olup olmadığına bakar
     * @param $name
     * @return bool
     */
    public function isNamedRoute($name)
    {

        return isset($this->namedRoutes[$name]);

    }

    /**
     *
     * @param array $types
     * @param array $args
     * @access public
     *
     */
    public function match($types, $args)
    {

        foreach ($types as $type) {

            $this->add($type, $args);
        }
    }

    /**
     * Collectionları döndürür
     * @return Ambigous <multitype: boolean, multitype:array >
     * @access public
     */
    public function getCollections()
    {

        return $this->collection;
    }

    /**
     * Http Methodunu Döndürür
     * @return string
     */
    public function getMethod()
    {

        return mb_convert_case($this->get('REQUEST_METHOD'), MB_CASE_LOWER);
    }

    public function before(array $before = [])
    {
        $this->before[$before['name']] = $before['use'];
    }

    /**
     * Filter eklemesi yapar
     * @param string $name
     * @param string $pattern
     * @return null
     */
    public function filter($name = '', $pattern = '')
    {

        $this->filters[$name] = $pattern;
    }

    /**
     * Filter i d�nd�r�r
     * @param string $name
     * @return boolean|string
     */
    public function getFilter($name)
    {


        return isset($this->filters[$name]) ? $this->filters[$name] : "([\w-%]+)";
    }

    /**
     * Regex i d�nd�r�r
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


        return "({$this->getFilter($matches[1])})" ?: "([\w-%]+)";
    }

    /**
     *
     * Parametreleri atar
     * @param array $params
     *
     */
    private function setParams(array $params = [])
    {

        $this->params = $params;
    }

    /**
     * Parametreleri d�nd�r�r
     * @return array
     */
    private function getParams()
    {

        return $this->params;
    }

    public function setCollections(array $collections = [])
    {

        $this->collection = $collections;
    }

    /**
     * Grup eklemesi yapar
     * @param string $name
     * @param array $befores
     */
    public function group($name, $befores)
    {

        $this->group[$name] = $befores;
    }

    /**
     *
     * $name e göre grup'u bulur, eğer yoksa exception oluşturur
     * @param string $name
     * @throw RuntimeException
     * @return array
     */
    private function getGroup($name)
    {

        if (isset($this->group[$name])) {

            return $this->group[$name];
        } else {

            throw new RuntimeException(
                sprintf('%s adında bir grup bulunamadı', $name)
            );
        }
    }

    public function run()
    {


        if (isset($this->getCollections()[$this->getMethod()]))
            $collections = $this->getCollections()[$this->getMethod()];
        else
            $collections = [];

        $url = $this->getUrl();

        ## kontrol ediliyor
        if (count($collections) > 0) {

            foreach ($collections as $collection) {

                $regex = $this->getRegex($collection['action']);
                if ($regex !== '') {

                    if (!preg_match("@^" . $regex . "*$@i", $url, $matches)) {
                        continue;
                    }
                }


                $get = $this->routeGenerateParams($url, $collection['action']);
                $argument_keys = $get['args'];
                $params = $get['params'];

                $this->setParams($params);


                if ($url == '/') {
                    $url = '';
                }

                $url = $this->basePath . $url;


                if ($this->routeGenareteNewUrl($argument_keys,
                    $params,
                    $url,
                    $this->basePath . $collection['action'])
                ) {

                    $params = array_merge([new Response()], $params);
                    $this->beforeAndRun($collection, $params);

                }
            }

        } else {

            return false;
        }
    }


    /**
     *
     * Karşılaştırır ve yürütür
     * @param string $url
     * @param string $replaced
     * @param array $collection
     */
    private function beforeAndRun($collection, $params)
    {

        $this->setParams($params);
        if ((new Before($collection['callback'], $params))->execute()) {

            if ($this->actionGroup($collection, $params)) {

                if ($this->actionAccessControl($collection['callback'])) {

                    $response = $this->dispatch($collection['callback']);

                    if ($response instanceof ExcutableResponseInterface){
                        $response->execute();
                    }
                }

            }


        }

    }


    /**
     *
     * @param mixed $callback
     * @return boolean
     */
    private function actionAccessControl($callback)
    {

        if (is_array($callback))
        {
            if (isset($callback['access']))
            {

                $access = $callback['access'];
                $name = $access['name'];

                $next = isset($access['next']) ? $access['next'] : null;
                $role = isset($access['role']) ? $access['role'] : null;

                $response = $this->checkAccess($name, $next, $role);
                return ($response) ? true : false;
            }
            else
            {

                return true;
            }
        }
        else
        {

            return true;
        }
    }

    /**
     *
     * Grupları kontrol eder.
     * @param array $action
     * @param array $params
     * @return boolean
     */
    private function actionGroup($action = [], array $params = [])
    {


        $return = true;
        if (is_array($action))
        {

            if (isset($action['groupName']))
            {

                $action['group'] = $this->getGroup($action['groupName']);
            }

            if (isset($action['group']))
            {

                foreach ($action['group'] as $group)
                {

                    if ($before = $this->isBefore($group))
                    {


                        if (!(new Before($before, $params))->execute())
                        {

                            $return = false;
                            break;
                        }
                    }
                }
            }

            if ($return) {

                if (isset($action['access'])) {

                    if ($this->actionAccessControl($action))
                    {

                        $return = true;
                    }
                }
            }
        }

        return $return;
    }

    /**
     *
     * @param array $action
     * @param array $params
     * @return boolean
     * @throws InvalidArgumentException
     */
    private function actionBefore($action, $params)
    {

        if (is_array($action)) {

            if (!isset($action['before']))
            {
                return true;
            }
            else
            {
                if ($before = $this->isBefore($action['before']))
                {
                    return (new Before($before, $params))->execute();
                }
                else
                {

                    throw new InvalidArgumentException(sprintf('%s adında bir before bulunamadı', $action['before']));
                }
            }
        }
        else
        {

            return true;
        }
    }

    /**
     * Girilen $name değişkeninde bir before varmı yokmu diyo kontrol eder
     * @param string $name
     * @return boolean|Clourse
     */
    private function isBefore($name)
    {

        return (isset($this->before[$name])) ? $this->before[$name] : false;
    }

    /**
     * Callback parçalama i�lemi burada ger�ekle�ir
     * @param array $callback
     * @return mixed
     */
    private function dispatch($callback = [])
    {


        if (is_array($callback)) {

            return $this->dispatchArray($callback);
        } elseif (is_callable($callback)) {

            return $this->dispatchCallable($callback);
        } elseif (is_string($callback)) {

            return $this->dispatchString($callback);
        }
    }

    /**
     *
     * @param array $callback
     * @throws RuntimeException
     */
    private function dispatchArray(array $callback = [])
    {


        if (isset($callback['action']))
            $call = $this->dispatch($callback['action']);
        else
            throw new RuntimeException(sprintf("%s route olayınızda izlenecek bir olay yok", $callback['action']));

        if (isset($callback['name']))
            $this->namedRoutes[$callback['name']] = $call;
    }

    /**
     * callable functionlar çağrılır
     * @param callable $callback
     * @return mixed
     */
    private function dispatchCallable(callable $callback)
    {

        $params = $this->getParams();

        return call_user_func_array($callback, $params);
    }

    /**
     * Controllerı çağırır
     * @param string $callback
     * @return mixed
     */
    private function dispatchString($callback = '')
    {

        if (strstr($callback, '::')) {

            list($controller, $method) = $this->parseFromExploder($callback, '::');
        } else {

            $controller = $callback;
            $method = '';
        }

        return $this->dispatchRunController($controller, $method);
    }

    /**
     *
     * @param string $controllerName
     * @param string $method
     * @return mixed
     */
    private function dispatchRunController($controllerName, $method = '')
    {
        $controller = App::uses($controllerName, 'Controller');

        if ($controller) {

            if ($method !== '') {


                if (is_callable([$controller, $method])) {

                    return call_user_func_array([$controller, $method], $this->getParams());
                } else {

                    throw new BadFunctionCallException(sprintf("%s cagrilabilir bir fonksiyon degil", $method));
                }
            }

            return $controller;
        } else {

            throw new InvalidArgumentException(sprintf("%s kontrolleri yok, kontrol ediniz", $controllerName));
        }
    }

}
