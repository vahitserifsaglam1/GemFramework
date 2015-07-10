<?php

    /**
     *  Bu Dosya GemFramework'un bir dosyasıdır,
     *  İstenildiği gibi alınıp kullanılabilir.
     *
     * @package Gem\Components
     * @author  vahitserifsaglam <vahit.serif119@gmail.com>
     * @copyright (c)  GemFramework, vahit serif saglam
     */

    namespace Gem\Components;

    class Redirect
    {

        /**
         * Yönlendirme işlemi yapar
         *
         * @param string  $adress
         * @param integer $time
         */
        public static function to($adress, $time = null)
        {

            if ($time === null) {

                static::location($adress);
            } else {

                static::refresh($adress, $time);
            }
        }

        /**
         *  Eski sayfaya geri döndürür
         */

        public static function back()
        {

            self::to($_SERVER['HTTP_REFERER']);
        }

        private static function refresh($url, $time)
        {

            header("Refresh:{$time},url=$url");
        }

        private static function location($url)
        {

            header("Location:$url");
        }
    }
