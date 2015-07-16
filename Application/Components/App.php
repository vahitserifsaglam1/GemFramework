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
    use Gem\Components\Http\Response\ShouldBeResponse;
    use Gem\Components\Patterns\Singleton;
    use Gem\Components\View\ShouldBeView;
    use Gem\Components\Installation\Starter;
    use Exception;

    class App
    {
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

            static::$starter = Singleton::make('Gem\Components\Installation\Starter');
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


        /**
         * Sayfayı kapatır
         * @param callable|null $callable
         * @return mixed
         */
        public static function Down(callable $callable = null)
        {
            $response = $callable(Singleton::make('Gem\Components\Http\Request'));
            if ($response instanceof ShouldBeView) {
                $view = $response->execute();
                response($view)->execute();
            } elseif ($response instanceof ShouldBeResponse) {
                return $response->execute();
            }
        }

        /**
         * Sayfa bulunamazsa yapılacak ayarı içerik
         * @param callable|null $miss
         */
        public static function miss($miss = null)
        {
            Config::set('general.route.miss', $miss);
        }

        /**
         * @param string $delimiter
         * @throws Exception
         */
        public static function delimiter($delimiter = '')
        {
            if (!is_string($delimiter)) {
                throw new Exception('Girdiğiniz sınırlayıcı değer geçerli bir string değeri değil');
            }

            Config::set('general.route.delimiter', $delimiter);

        }


        /**
         * @param callable|null $callback
         */
        public static function exception(callable $callback = null)
        {
            Config::set('app.exception.handler', $callback);
        }

        /**
         * Hataların yakalanacağı uygulamayı ayarlar
         * @param callable|null $callback
         */
        public static function error(callable $callback = null)
        {
            Config::set('app.error.handler', $callback);
        }
    }
