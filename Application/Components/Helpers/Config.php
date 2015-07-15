<?php

    /**
     * GemFramework Config Helper -> ayar dosyaları bu dosyadan çekilir
     *
     * @package Gem\Components\Helpers
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */

    namespace Gem\Components\Helpers;

    trait Config
    {

        private static $cache;

        /**
         * �stenilen ayar� getirir
         *
         * @param string $config
         * @return boolean|mixed
         * @access public
         */
        public function getConfig($config = '')
        {

            return self::getConfigStatic($config);
        }

        /**
         * İstenilen ayarı döndürür
         *
         * @param string $config
         * @return boolean|mixed
         * @access public
         */
        public static function getConfigStatic($config)
        {

            $parse = static::parse($config);

            if (count($parse) === 1) {
                $task = $parse[0];
            } elseif (count($parse) === 2) {
                list($task, $method) = $parse;
            } elseif (count($parse) === 3) {
                list($task, $method, $fname) = $parse;
            }

            if (isset(static::$cache[$task])) {
                $return = static::$cache[$task];
            } else {
                $filePath = CONFIG_PATH . $task . '.php';
                if (file_exists($filePath)) {
                    $return = static::$cache[$task] = include $filePath;
                } else {
                    $return = static::$cache[$task] = null;
                }
            }


            if (isset($method)) {

                if (isset($return[$method])) {
                    $return = $return[$method];
                    if (isset($fname)) {
                        if (isset($return[$fname])) {
                            $return = $return[$fname];
                        }
                    }

                }
            }
            return $return;

        }

        /**
         * Metni . karekterine göre parçalar ve görev listesini oluşturur
         *
         * @param string $config
         * @return array|string
         */
        private static function parse(
            $config = ''
        ) {
            if (strstr($config, ".")) {

                $parse = explode('.', $config);
                return $parse;
            } else {
                return (array)$config;
            }
        }

        /**
         * @param string $name verinin ismi
         * @param string $value değeri
         */
        public static function set($name, $value = '')
        {

            if (!strstr($name, ".")) {
                static::$cache[$name] = $value;
            } else {

                $parse = static::parse($name);
                if (count($parse) === 2) {
                    list($name, $fname) = $parse;
                    static::$cache[$name][$fname] = $value;
                } elseif (count($parse) === 3) {
                    list($name, $fname, $sname) = $parse;
                    static::$cache[$name][$fname][$sname] = $value;
                }
            }

        }

        /**
         * @param string $name eklenecek değerin ismi
         * @param string $value değeri
         */
        public static function add($name = '', $value = '')
        {
            // veri yoksa oluşturuyoruz
            if (!isset(static::$cache[$name])) {
                static::$cache[$name] = [];
            }
            static::$cache[$name] = array_merge(static::$cache[$name], $value);
        }
    }
