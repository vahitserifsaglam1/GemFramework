<?php

    namespace Gem\Components\Redis;

    use Exception;
    use Gem\Components\Helpers\Config;
    use Redis;

    /**
     * Bu sınıf GemFramework'de Redis bağlantısı yapmak için yapılmıştr.
     * Class Connector
     *
     * @package Gem\Components\Redis
     */
    class RedisConnector
    {

        private $redisObj;

        public function __construct()
        {
            if (!extension_loaded('redis')) {

                throw new Exception('
                     Redis eklentisi yüklü olmadan bu sınıfı kullanamassınız.'
                );
            } else {

                $configArray = Config::get('stroge.redis');
                $host = $configArray['host'];
                $port = $configArray['port'];
                $timeOut = $configArray['timeout'];
                $redisObj = new Redis();
                $redisObj->connect($host, $port, $timeOut);
                $redisObj->setOption(Redis::OPT_SERIALIZER,
                   Redis::SERIALIZER_PHP);    // use built-in serialize/unserialize
                $this->redisObj = $redisObj;
            }
        }

        /**
         * Redis Bağlantısını Döndürür
         *
         * @return Redis
         */
        public function getRedisObj()
        {
            return $this->redisObj;
        }

        /**
         * Dinamik olarak method çağırım işlevi
         *
         * @param $method
         * @param $params
         * @return mixed
         */
        public function __call($method, $params)
        {
            return call_user_func([$this->redisObj, $method], $params);
        }
    }
