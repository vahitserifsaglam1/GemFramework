<?php

    /**
     *   GemFramework dosyalarda Controller ve Model leri �a��rmakta kullan�lacak
     *
     * @package Gem\Components
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright MyfcYazilim
     */

    namespace Gem\Components;

    use Gem\Components\Helpers\Config;
    use Gem\Components\Patterns\Singleton;
    use Gem\Manager\Starter;

    class App
    {

        use Config;
        const CONTROLLER = 'Controller';
        const MODEL = 'Model';
        private static $starter;

        /**
         * Controller, method yada bir s�n�f �a��r�r
         *
         * @param mixed  $names
         * @param string $type
         * @return mixed
         * @access public
         */
        public static function uses($names, $type)
        {

            $names = (array)$names;
            foreach ($names as $name) {
                switch ($type) {
                    case self::CONTROLLER:
                        $return[$name] = self::includeController($name);
                        break;
                    case self::MODEL:
                        $return[$name] = self::includeModel($name);
                        break;
                }
            }

            if (count($return) == 1) {

                $return = array_reverse($return);
                $return = end($return);
            }

            return $return;
        }

        /**
         * Html da kullan�lmak i�in base kodunu olu�turur
         *
         * @return string
         */
        public static function base()
        {
            $config = self::getConfigStatic('configs')['url'];

            return '<base href="' . $config . '" target="_blank">';
        }

        /**
         * @param string $controller
         * @return null|object
         */
        private static function includeController($controller)
        {

            $controllername = 'Gem\\Controllers\\' . $controller;

            return new $controllername;
        }

        /**
         * @param string $model
         * @return null|object
         */
        private static function includeModel($model)
        {
            $modelname = 'Gem\\Models\\' . $model;

            return new $modelname;
        }

        /**
         * Starter objesini oluşturur
         */
        private static function starter()
        {

            if (static::$starter && static::$starter instanceof Starter) {
                return;
            }

            static::$starter = Singleton::make('Gem\Manager\Starter');
        }

        /**
         * Sınıfa facede ekler
         *
         * @param array $facedes
         * @return bool
         */
        public static function facede($facedes = [])
        {
            static::starter();
            if (!is_array($facedes)) {
                $facedes = (array)$facedes;
            }

            static::$starter->setAlias($facedes);

            return true;
        }

        /**
         * Sınıfa providers ekler
         *
         * @param array $providers
         * @return bool
         */
        public static function serviceProviders($providers = [])
        {
            static::starter();
            if (!is_array($providers)) {
                $providers = (array)$providers;
            }
            static::$starter->setProviders($providers);
            return true;
        }
    }
