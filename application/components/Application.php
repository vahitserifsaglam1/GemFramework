<?php

/**
 * Bu dosya GemFramework un ba�lang�� s�n�f�na ait dosyad�r
 * Framework le ilgili olaylar ilk olarak bu s�n�fta ger�ekle�ir
 * 
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @version 1.0.0
 * @package Gem\Components
 */

namespace Gem\Components;

use Gem\Components\Patterns\Singleton;
use Gem\Components\Route\Manager;
use Gem\Components\Patterns\Facade;
use Exception;
use Composer\Autoload\ClassLoader;
use InvalidArgumentException;
use Gem\Components\File;

/**
 * 
 * @class Application
 * 
 */
class Application {

    const ROUTEFILE = APP . '/routes.php';

    /**
     * 
     * @var String -> framework un ad�
     * @var Float  -> framework un versiyonu
     * @access private
     * 
     */
    private $framework_name;
    private $framework_version;
    private $router;
    private $alias = [];
    private $provider = [];
    private $modules;

    function __construct($framework_name = 'Gem', $framework_version = 1.0) {

        $this->framework_name = $framework_name;
        $this->framework_version = $framework_version;
        $this->router = $this->singleton(new Manager());
        $this->autoloader = new ClassLoader();

        $this->autoloader->register();
    }

    /**
     * Autoloader'a yeni sınıf ekler
     * @param array $autoload
     * @return \Gem\Components\Application
     */
    public function addAutoload($autoload = []) {

        foreach ($autoload as $key => $value) {

            $this->autoloader->add($key, $value);
        }
        
        return $this;
    }

    /**
     * Kullanılacak modulleri atar.
     * @param array $modules
     * @return \Gem\Components\Application
     */
    public function useModules($modules = []){
        
        
        foreach($modules as $module)
        {
            
            $this->modules[] = new $module;
            
            
        }
        
        return $this;
        
    }
    
    /**
     * Access Ataması yapar
     * @param array $access
     * @return \Gem\Components\Application
     */
    public function setAccess($access){
        
        $this->router->setAccess($access);
        return $this;
        
    }


    /**
     * Yeni bir singleton objesi oluşturur
     * @param mixed $instance
     * @param mixed ...$parameters
     * @return Object
     * 
     */
    function singleton($instance, array $parameters = []) {

        return Singleton::make($instance, $parameters);
    }

    /**
     * Dosyadaki i�eri�i �eker
     * @param string $filePath
     * @return \Gem\Components\Application
     */
    function routesFromFile($filePath = self::ROUTEFILE) {

        if (file_exists($filePath)) {

            $app = $this;
            $inc = include $filePath;
        } else {

            throw new Exception(sprintf("girmiş olduğunuz %s dosyası bulunmadı", $filePath));
        }

        return $this;
    }

    /**
     * 
     * Get isteklerini yakalar
     * 
     * @param string $url
     * @param mixed $use
     */
    function get($url, $use) {

        $this->router->add('get', func_get_args());
        return $this;
    }

    /**
     *
     * Post isteklerini yakalar
     *
     * @param string $url
     * @param mixed $use
     */
    function post($url, $use) {

        $this->router->add('post', func_get_args());
        return $this;
    }

    /**
     *
     * Delete isteklerini yakalar
     *
     * @param string $url
     * @param mixed $use
     */
    function delete($url, $use) {

        $this->router->add('delete', func_get_args());
        return $this;
    }

    /**
     *
     * Put isteklerini yakalar
     *
     * @param string $url
     * @param mixed $use
     */
    function put($url, $use) {

        $this->router->add('put', func_get_args());
        return $this;
    }

    /**
     *
     * Tüm isteklerini yakalar
     *
     * @param string $url
     * @param mixed $use
     */
    function any($url, $use) {

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
    function match($types = [], $url, $use) {

        $type = $types;
        $args = func_get_args();
        unset($args[0]);
        $this->router->match($type, $args);
        ;
        return $this;
    }

    /**
     * Koleksiyonlar� d�nd�r�r
     */
    function getCollections() {

        return $this->router->getCollections();
    }

    /**
     * 
     * @param array $collections
     * @return \Gem\Components\Application
     */
    function setCollections(array $collections = []) {

        $this->router->setCollections($collections);
        return $this;
    }

    /**
     * 
     * @param string $filter
     * @param string $pattern
     * @return \Gem\Components\Application
     * @access public 
     */
    function filter($filter, $pattern) {

        $this->router->filter($filter, $pattern);
        return $this;
    }

    ## tetikleyici

    function run() {

        if (count($this->alias) > 0) {

            $this->runFacades();
        }

        if (count($this->provider) > 0) {

            $this->runProviders();
        }
        ## url yönetimi
        $this->getUrlChecker();

        ## rotalandırmanın başlamı
        $this->router->run();
    }


    /**
     * yeni bir grup ekler
     * @param arraay $befores
     * @param mixed $callback
     * @return \Gem\Components\Application
     */
    
    public function group($befores = [], $callback = null) {

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
     * Url'i kontrol eder
     * 
     */
    private function getUrlChecker() {

        if (!isset($_GET['url']) || !$_GET['url'])
            $_GET['url'] = '/';
    }

    /**
     * 
     * Facadeleri yürütür
     * 
     */
    private function runFacades() {

        Facade::$instance = $this->alias;
    }

    /**
     * 
     * Providersları yürütür
     * 
     */
    private function runProviders() {

        foreach ($this->provider as $provider) {

            new $provider($this);
        }
    }

    /**
     * 
     * @param array $facedes
     * @return \Gem\Components\Application
     */
    public function register($facedes = []) {

        $this->alias = array_merge($this->alias,$facedes);
        return $this;
    }

    /**
     * 
     * @param array $before
     * @return \Gem\Components\Application
     * @throws InvalidArgumentException
     */
    public function before($before = []) {

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

    public function provider($provider = []) {

        $this->provider = array_merge($this->provider,$provider);
        return $this;
    }

}
