<?php

    /**
     *  Bu Sınıf GemFramework'de cookie işlemlerinin yapılması için yapılmıştır
     *
     * @author vahitserifsaglam <vahit.serif119@gmail.com>
     */
    namespace Gem\Components\Http;

    class CookieBag extends RequestHeadersBag
    {

        private $cookies;

        /**
         * Cookie değerlerini atar
         */
        public function __construct()
        {

            parent::__construct();
            $get = $this->getHeaders();
            if (isset($get['Cookie'])) {
                $this->cookies = $this->rendeCookieString($get['Cookie']);
            } else {
                $this->cookies = [];
            }
        }

        /**
         * Cookie verilerini parçalar
         *
         * @param string $cookie
         * @return array
         */
        private function rendeCookieString($cookie = '')
        {

            if ($cookie !== '') {

                $explode = explode(";", $cookie);
                $cookies = [];

                foreach ($explode as $ex) {

                    $ex = explode('=', $ex);
                    $cookies[trim($ex[0])] = ($ex[1]);
                }

                return $cookies;
            }
        }

        /**
         * Cookileri döndürür
         *
         * @return array
         */
        public function getCookies()
        {
            return $this->cookies;
        }
    }

