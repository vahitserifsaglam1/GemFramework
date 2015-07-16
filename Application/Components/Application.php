<?php

    /**
     *      * Bu Sınıf GemFramework'un başlangıç sınıfıdr
     *      * Framework le ilgili olaylar ilk olarak bu s�n�fta ger�ekle�ir
     *      *
     *      * @author <vahitserifsaglam <vahit.serif119@gmail.com>
     *      * @version 1.0.0
     *      * @package Gem\Components
     *      */

    namespace Gem\Components;

    use Gem\Components\Helpers\Server;
    use Gem\Components\Patterns\Singleton;
    use Gem\Components\Security\TypeHint;
    use Exception;
    use Gem\Components\Installation\AllConfigsLoader;
    use Gem\Components\Installation\AliasAndProviders;
    use Gem\Components\Installation\ErrorConfigs;
    use Gem\System\SystemManager;

    /**
     * @class Application
     *
     */
    final class Application
    {

        use Server;
        private $frameworkName;
        private $starter;
        private $frameworkVersion;
        private $routeFile;

        private $bootstraps = [
            AllConfigsLoader::class,
            SystemManager::class,
            AliasAndProviders::class,
            ErrorConfigs::class,
        ];

        /**
         *    Framework 'un adı ve versionu girilir,
         *    Ve framework başlatılır
         *
         * @param string $frameworkName
         * @param int $frameworkVersion
         *
         */
        public function __construct($frameworkName = '', $frameworkVersion = 1)
        {

            $this->$frameworkName = $frameworkName;
            $this->frameworkVersion = $frameworkVersion;

            define('FRAMEWORK_NAME', $this->frameworkName);
            define('FRAMEWORK_VERSION', $this->frameworkVersion);

            $this->starter = $this->singleton('Gem\Components\Installation\Starter');
            $this->runBootstraps();
        }


        /**
         * Başlatıcı sınıfları yürütür
         */
        private function runBootstraps()
        {
            $classes = $this->bootstraps;

            foreach ($classes as $class) {
                new $class($this);
            }
        }

        /**
         *          $bool girilirse fonksiyonlar tip yakalaması gerçekleşir
         *
         * @param bool $bool
         *
         */
        public function typeHint($bool = true)
        {

            if (true === $bool) {
                TypeHint::setErrorHandler();
            }
        }


        /**
         *           Yeni bir singleton objesi oluşturur
         *
         * @param mixed $instance
         * @param mixed ...$parameters
         * @return Object
         *
         */
        public function singleton($instance, array $parameters = [])
        {

            return Singleton::make($instance, $parameters);
        }


        /**
         * Uygulamayı Yürütür
         * @throws Exception
         */
        public function run()
        {
            $this->routeFile = ROUTE . 'routes.php';
            if (file_exists($this->routeFile)) {
                include $this->routeFile;
                $make = $this->singleton('Gem\Components\Route\Router');
                $make->run();
            } else {
                throw new Exception(sprintf('%s yolunda olması gerek röta dosyanız bulunamadı, lütfen oluşturun',
                    $this->routeFile));
            }
        }

        /**
         * Yeni bir manager objesi döndürür
         *
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
         * Önbelleğe alınmış ayar dosyasını döndürür
         * @return string
         */
        public function getCachedConfig()
        {
            return 'stroge/cache/system/config.php';
        }

        /**
         * Fonksiyonu yürütür
         * @param $class
         * @param array $method
         * @param array $params
         * @return mixed
         */
        public function call($class, $method = '', $params = [])
        {
            return call_user_func_array([$class, $method], $params);
        }
    }