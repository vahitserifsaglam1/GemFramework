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
use Gem\Components\Helpers\Server;
use Gem\Components\Route\Collector;
use Exception;

/**
 *
 * @class Application
 *
 */
class Application extends Collector
{

    use Server;
    const ROUTEFILE = 'application/routes.php';

    private $framework_name;
    private $modules;
    private $starter;
    private $file;

    public function __construct($framework_name = 'Gem', $framework_version = 1.0)
    {

        $this->file = $this->singleton('Gem\Components\File');
        $this->framework_name = $framework_name;
        $this->framework_version = $framework_version;
        define('FRAMEWORK_NAME', $this->framework_name);
        define('FRAMEWORK_VERSION', $this->framework_version);
        $this->starter = $this->singleton('Gem\Application\Manager\Starter', []);
        parent::__construct();
    }

    /**
     * $name 'e göre veriyi döndürür
     * @param string $name
     * @return mixed
     */
    public function getModule($name = '')
    {

        if (isset($this->modules[$name])) {
            return $this->modules[$name];
        }

    }

    /**
     * Kullanılacak modulleri atar.
     * @param array $modules
     * @return \Gem\Components\Application
     */
    public function useModules($modules = [])
    {


        if (!is_array($modules)) {
            $modules = (array)$modules;
        }

        foreach ($modules as $key => $module) {

            $this->modules[$key] = new $module;


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
    public function singleton($instance, array $parameters = [])
    {
        return Singleton::make($instance, $parameters);
    }


    ## tetikleyici

    public function run()
    {

        if (count($this->starter->getAlias()) > 0) {

            $this->runFacades();
        }

        if (count($this->starter->getProviders()) > 0) {

            $this->runProviders();
        }

        ## rotalandırmanın başlamı
        $this->router->run();

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
    public function makeManager($class)
    {

        $class = "Gem\\Application\\Managers\\" . $class;
        $class = new $class();
        return $class;

    }

    /**
     * Event Dosyalarını çağırır
     */
    public function runEvent()
    {

        $event = APP . 'events.php';

        if ($this->file->exists($event)) {

            $this->file->inc($event);

        }

    }

    /**
     *
     * @param array $facedes
     * @return \Gem\Components\Application
     */
    public function register($facedes = [])
    {

        if (!is_array($facedes))
            $facedes = (array)$facedes;

        $this->starter->setAlias($facedes);
        return $this;
    }


    public function provider($provider = [])
    {

        if (!is_array($provider))
            $provider = (array)$provider;

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

        if ($this->file->exists($filePath)) {

            $this->file->inc($filePath);
            $this->run();
        } else {

            throw new Exception(sprintf("girmiş olduğunuz %s dosyası bulunmadı", $filePath));
        }

        return $this;
    }


}
