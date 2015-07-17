<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Cache;

    /**
     * Interface CacheInterface
     * @package Gem\Components\Cache
     */

    interface CacheInterface
    {

        /**
         * $name ile girilen veriyi çeker
         *
         * @param string $name
         * @return array|string
         */
        public function get($name = '');

        /**
         * Önbelleğe 'e veri ataması yapar
         *
         * @param $name
         * @param string $value
         * @param int $time
         * @return $this
         */
        public function set($name, $value = '', $time = 3600);

        /**
         * Veri varsa veriyi yoksa false döndürür
         *
         * @param string $name
         * @return array|bool|string
         */
        public function has($name = '');

        /**
         * Veriyi Önbellekden siler
         *
         * @param string $name
         * @return $this
         */
        public function delete($name = '');


        /**
         * Tüm önbellek verilerini siler
         *
         * @return $this
         */
        public function flush();
    }
