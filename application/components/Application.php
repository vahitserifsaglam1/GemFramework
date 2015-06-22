<?php

/**
 * Bu Sınıf GemFramework'un başlangıç sınıfıdr
 * Framework le ilgili olaylar ilk olarak bu s�n�fta ger�ekle�ir
 *
 * @author vahitserifsaglam <vahit.serif119@gmail.com>
 * @version 1.0.0
 * @package Gem\Components
 */

namespace Gem\Components;

use Gem\Components\Patterns\Singleton;
use Gem\Components\Patterns\Facade;
use Gem\Components\Database\Helpers\Server;
use Gem\Components\Helpers\RouteCollector;

/**
 *
 * @class Application
 *
 */
class Application extends RouteCollector
{

    const ROUTEFILE = APP . '/routes.php';

    private $framework_name;
    private $modules;
    private $starter;

    function __construct($framework_name = 'Gem', $framework_version = 1.0)
    {

        parent::__construct();
        $this->framework_name = $framework_name;
        $this->framework_version = $framework_version;
        define('FRAMEWORK_NAME', $this->framework_name);
        define('FRAMEWORK_VERSION', $this->framework_version);
        $this->starter = $this->singleton('Gem\Application\Manager\Starter',[]);

    }


    /**
     * Kullanılacak modulleri atar.
     * @param array $modules
     * @return \Gem\Components\Application
     */
    public function useModules($modules = [])
    {


        if(!is_array($modules)){
            $modules = (array) $modules;
        }

        foreach ($modules as $module) {

            $this->modules[] = new $module;


        }

        return $this;

    }



    /**
     * Yeni bir singleton objesi oluşturur
     * @param mixed $instance
     * @param mixed ...$parameters
     * @return Object
     *
     */
    function singleton($instance, array $parameters = [])
    {
        return Singleton::make($instance, $parameters);
    }


    ## tetikleyici

    function run()
    {

        if (count($this->starter->getAlias()) > 0) {

            $this->runFacades();
        }

        if (count($this->starter->getProviders()) > 0) {

            $this->runProviders();
        }
        ## url yönetimi
        $this->getUrlChecker();

        ## rotalandırmanın başlamı
        $this->router->run();

        $this->starter = null;
        $this->router = null;
    }

    /**
     *
     * Url'i kontrol eder
     *
     */
    private function getUrlChecker()
    {

        if (!isset($_GET['url']) || !$_GET['url'])
            $_GET['url'] = '/';
    }

    /**
     *
     * Facadeleri yürütür
     *
     */
    private function runFacades()
    {

        Facade::$instance = $this->starter->getAlias();
    }

    /**
     *
     * Providersları yürütür
     *
     */
    private function runProviders()
    {

        foreach ($this->starter->getProviders() as $provider) {

            new $provider($this);
        }
    }

    /**
     * Yeni bir manager objesi döndürür
     * @param $class
     * @return mixed
     */
    public function makeManager($class){

        $class = "Gem\\Application\\Managers\\".$class;
        $class = new $class();
        return $class;

    }

    /**
     * Event Dosyalarını çağırır
     */
    public function runEvent(){

        $event = APP.'events.php';

        if(file_exists($event))
            include $event;


    }
    /**
     *
     * @param array $facedes
     * @return \Gem\Components\Application
     */
    public function register($facedes = [])
    {

        if(!is_array($facedes))
            $facedes = (array) $facedes;

        $this->starter->setAlias($facedes);
        return $this;
    }


    public function provider($provider = [])
    {

        if(!is_array($provider))
            $provider = (array) $provider;

       $this->starter->setProviders($provider);
        return $this;
    }


    /**
     * Rötalandırma işleminin nerden devam edeceğine karar verir
     * @param $filePath
     * @return $this
     * @throws Exception
     */
    function routesFromFile($filePath = self::ROUTEFILE)
    {

        if (file_exists($filePath)) {
            $app = $this;
            $inc = include $filePath;
            unset($app);
            $this->run();
        } else {

            throw new Exception(sprintf("girmiş olduğunuz %s dosyası bulunmadı", $filePath));
        }

        return $this;
    }



}
