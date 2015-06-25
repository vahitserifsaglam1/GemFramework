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
use Gem\Components\Security\TypeHint;
use Exception;

/**
 *
 * @class Application
 *
 */
class Application
{

    use Server;
    const ROUTEFILE = 'Application/routes.php';

    private $frameworkName;
    private $starter;
    private $frameworkVersion;

    public function __construct($frameworkName = '',$frameworkVersion = 1)
    {


        $this->$frameworkName = $frameworkName;
        $this->frameworkVersion = $frameworkVersion;
        define('FRAMEWORK_NAME', $this->frameworkName);
        define('FRAMEWORK_VERSION', $this->frameworkVersion);
        $this->starter = $this->singleton('Gem\Manager\Starter');

    }


    /**
     * $bool girilirse fonksiyonlar tip yakalaması gerçekleşir
     * @param bool $bool
     *
     */
    public function typeHint($bool = true){

        if(true === $bool)
        {
            TypeHint::setErrorHandler();

        }

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
        Singleton::make('Gem\Components\Route\Manager',[])->run();

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

        if (file_exists($event)) {

            include($event);

        }

    }

    /**
     *
     * @param array $facedes
     * @return \Gem\Components\Application
     */
    public function facede($facedes = [])
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

        if (file_exists($filePath)) {

            include($filePath);
            $this->run();
        } else {

            throw new Exception(
                sprintf("girmiş olduğunuz %s dosyası bulunmadı", $filePath)
            );
        }

        return $this;
    }

    /**
     * İçeriği belirtilen dosya yolundan çeker
     * @param string $filePath
     * @throws Exception
     */
    public function getProvidersAndAliasFromFile($filePath = ''){

        if(file_exists($filePath)){

            $rende = Yaml::decode(file_get_contents($filePath));
            $this->starter->setAlias($rende['alias']);
            $this->starter->setProviders($rende['providers']);

        }else{

            throw new Exception(sprintf(
                'Girdiğiniz %s url\' inde herhangi bir dosya yok',$filePath
            ));

        }

    }

}
