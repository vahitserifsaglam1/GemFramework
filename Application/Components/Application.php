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
    class Application
    {

        use Server;

        /**
         * @var string
         *
         * Önbelleğe alınmış ayarın yolunu döndürür
         */
        private $cachedConfig = 'stroge/cache/system/config.php';

        /**
         * Yürütülen Bootstrap dosyalarını tutar
         *
         * @var array
         */
        private $runnedBootstraps;

        /**
         * Uygulumanın başlangıcı için gerekli olan dosyalar
         *
         * @var array
         */

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
         * @param string $name
         * @param int $version
         *
         */
        public function __construct($name = '', $version = 1)
        {

            define('FRAMEWORK_NAME', $name);
            define('FRAMEWORK_VERSION', $version);


            $this->runBootstraps();
        }


        /**
         * Başlatıcı sınıfları yürütür
         */
        private function runBootstraps()
        {
            $classes = $this->bootstraps;

            foreach ($classes as $class) {
                $class = new $class($this);
                $this->runnedBootstraps[get_class($class)] = $class;
            }
        }

        /**
         *  $bool girilirse fonksiyonlar tip yakalaması gerçekleşir
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
         *  Yeni bir singleton objesi oluşturur
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
         *
         *
         * @throws Exception
         */
        public function run()
        {

            $route = ROUTE . 'routes.php';

            if (file_exists($route)) {

                require($route);
                $make = $this->singleton('Gem\Components\Route\Router');
                $make->run();
            } else {

                throw new Exception(sprintf('%s yolunda olması gerek röta dosyanız bulunamadı, lütfen oluşturun',
                    $route));
            }
        }

        /**
         * Önbelleğe alınmış ayar dosyasını döndürür
         * @return string
         */
        public function getCachedConfig()
        {
            return $this->cachedConfig;
        }

        /**
         * Girilen fonksiyonu çağırır
         * @param string $class
         * @param string $method
         * @param array $params
         * @return mixed
         */
        public function call($class, $method = '', $params = [])
        {
            return call_user_func_array([$class, $method], $params);
        }
    }