<?php
    /**
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright GemMedya, 2015
     */

    namespace Gem\Components\Cache;

    interface CacheDriverInterface
    {

        /**
         * Driver 'ın yönetmeye uygun olup olmadığına bakar
         *
         * @return mixed
         */
        public function checkDriver();

        /**
         * Driver ismini döndürür
         *
         * @return mixed
         */
        public function getName();

    }