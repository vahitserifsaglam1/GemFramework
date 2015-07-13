<?php

    namespace Gem\Components;

    use Gem\Components\Redis\RedisConnector;

    class Redis extends RedisConnector
    {

        /**
         * Sınıfı başlatır ve Ebeveyn sınıfının da başlatılmasını sağlar
         *
         * @throws \Exception
         */
        public function __construct()
        {
            parent::__construct();
        }

        /**
         * Dinamik olarak method çağrımı
         * @param string $method
         * @param array $params
         * @return mixed
         */
        public function __call($method, $params = [])
        {
            return call_user_func_array([$this->getRedisObj(), $method], $params);
        }
    }
