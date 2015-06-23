<?php


namespace Gem\Components\Route;

use Gem\Components\Patterns\Singleton;

class Collector
{

    protected $router;

    public function __construct()
    {


        $this->router = Singleton::make('Gem\Components\Route\Manager', []);
    }


    /**
     * Access Ataması yapar
     * @param array $access
     * @return \Gem\Components\Application
     */
    public function setAccess($access)
    {

        $this->router->setAccess($access);
        return $this;

    }

    /**
     * Get verilerini toplar
     * @param $url
     * @param $use
     * @return $this
     */
    public function get($url, $use)
    {

        $this->router->add('get', func_get_args());
        return $this;
    }

    /**
     * Post Verilerini toplar
     * @param $url
     * @param $use
     * @return $this
     */
    public function post($url, $use)
    {

        $this->router->add('post', func_get_args());
        return $this;
    }

    /**
     * Yapılan delete isteklerini toplar
     * @param $url
     * @param $use
     * @return $this
     */
    public function delete($url, $use)
    {

        $this->router->add('delete', func_get_args());
        return $this;
    }

    /**
     * put isteklerini toplar
     * @param $url
     * @param $use
     * @return $this
     */
    public function put($url, $use)
    {

        $this->router->add('put', func_get_args());
        return $this;
    }

    /**
     * yapılan her türlü isteği toplar
     * @param $url
     * @param $use
     * @return $this
     */
    public function any($url, $use)
    {

        $this->router->match($this->router->getTypes(), func_get_args());
        return $this;
    }

    /**
     * Array a g�re istekleri ekler
     * @param array $types
     * @param string $url
     * @param mixed $use
     * @return \Gem\Components\Application
     * @access public
     *
     */
    public function match($types = [], $url, $use)
    {

        $type = $types;
        $args = func_get_args();
        unset($args[0]);
        $this->router->match($type, $args);;
        return $this;
    }


    /**
     *
     * Girilen değere göre filtreleme yapar
     * @param string $filter
     * @param string $pattern
     * @return \Gem\Components\Application
     * @access public
     */
    public function filter($filter, $pattern)
    {

        $this->router->filter($filter, $pattern);
        return $this;
    }

    /**
     * Yeni bir grup ekler
     * @param array $befores
     * @param null $callback
     * @return $this
     */
    public function group($befores = [], $callback = null)
    {

        $app = $this;

        if (is_string($befores)) {

            $this->addGroupWithName($befores, $callback);

        } elseif (is_array($befores) && is_callable($callback)) {


            $response = $callback($app);

            if ($response instanceof Application) {

                $collections = $response->getCollections();

                $colls = [];
                foreach ($collections as $key => $values) {

                    foreach ($values as $valuekey => $value) {

                        $colls[$key][$valuekey] = array_merge($value, ['group' => $befores]);
                    }
                }
            }


            $this->setCollections(array_merge($this->getCollections(), $colls));
        }
        return $this;
    }

    /**
     *
     * Grup ismine göre grup ataması yapar
     * @param string $name
     * @param array $befores
     *
     */

    private function addGroupWithName($name, $befores)
    {

        $this->router->group($name, $befores);

    }

    /**
     *
     * @param array $before
     * @return \Gem\Components\Application
     * @throws InvalidArgumentException
     */
    public function before($before = [])
    {

        if (!is_array($before)) {

            $args = func_get_args();
            $before = ['name' => $args[0], 'use' => $args[1]];
        }

        if (!isset($before['name'])) {

            throw new InvalidArgumentException('before verinizde "name" index i bulunamadı');
        }

        if (!isset($before['use'])) {

            throw new InvalidArgumentException('before verinizde "use" index i bulunamadı');
        }

        $this->router->before($before);

        return $this;
    }

    /**
     * Toplanan verileri döndürür
     * @return mixed
     */
    public function getCollections()
    {

        return $this->router->getCollections();
    }

    /**
     * Verileri tatar
     * @param array $collections
     * @return \Gem\Components\Application
     */
    public function setCollections(array $collections = [])
    {

        $this->router->setCollections($collections);
        return $this;
    }


}

